import ApiClient from './index';
import TPCStorage from '../components/common/storage';
import { copySafe } from './../utils/functions';


export default class Service {

    constructor () {
        this.client = new ApiClient();
        this.base = '/tpc-api/';
    }

    getCountries() {
        return [
            {value: '', text: 'Choose an option'},
            {value: 'US', text: 'United States'},
            {value: 'CA', text :'Canada'}
        ]
    }

    getStates(countryCode) {
        let response = this.client.get(this.base.concat(`states/${countryCode}`));
        return response.then((data) => {
            return data.json();
        }).then((json) => {
            return [{value: '', text: 'Choose an option'},
                ...Object.keys(json.states).map(function (key) {
                    return { value: key, text: json.states[key] }
                })
            ];
        });
    }

    getUser(reload = false) {
        let response = this.client.get('/wp/v2/users/me');
        if (this._user && !reload) {
            return this._user;
        }
        return response.then((data) => {
            if (data.status === 401) {
                this._user = false;
                return Promise.resolve(false);
            }
            return data.json();
        }).then(data => {
            if (!this._user && data) {
                this._user = data;
            }
            return this._user;
        });
    }

    getEmailRegistered(value) {
        let response = this.client.get(this.base.concat('users/email-registered'), {email: value});
        return response.then((data) => {
            return data.json();
        });
    }

    getCoupon(couponCode) {
        let response = this.client.get(this.base.concat('coupons'), {code: couponCode});
        return response.then((data) => {
            return data.json();
        }).then(json => {
            if ('status' in json) {
                return {};
            }
            return json;
        });
    }

    getMembershipData() {
        let response = this.client.get(this.base.concat('products/memberships'));
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        });
    }

    getProducts(products) {
        let response = this.client.get(this.base.concat('products'), { include: products /*.join()*/ });
        return response.then(data => {
            return data.json();
        });
    }

    getGateways() {
        let response = this.client.get(this.base.concat('gateways'));
        return response.then(data => {
            return data.json();
        }).then(json => {
            let array = [];
            for (let gateway of json) {
                gateway.enabled && array.push(gateway);
            }
            return array;
        });
    }

    createOrder(options = {}) {
        let data = {
            status: 'pending',
            currency: 'USD',
            billing: {
                first_name: '',
                last_name: '',
                company: '',
                address_1: '',
                address_2: '',
                city: '',
                state: '',
                postcode: '',
                country: '',
                email: '',
                phone: ''
            },
            shipping: {
                first_name: '',
                last_name: '',
                company: '',
                address_1: '',
                address_2: '',
                city: '',
                state: '',
                postcode: '',
                country: ''
            },
            payment_method: 'limelight',
            payment_method_title: 'Limelight',
            // transaction_id: '',
            meta_data: [],
            line_items: [],
            coupon_lines: [],
            coupons: [],
            'limelight-card-number': '',
            'limelight-card-expiry': '',
            'limelight-card-cvc': '',
            'limelight-card-type': ''
        };

        const { MEMBERSHIP_KEY, UPSELL_KEY, ORDER_KEY, COUPON_KEY, CART_KEY } = options;
        const PREFIX = ['shipping', 'billing'];

        let isUserLoggedIn = Boolean(window.wpReactSettings.userEmail);
        let storage = new TPCStorage();

        for (let key of storage) {
            for (let prefix of PREFIX) {
                if (key.startsWith(prefix)) {
                    data[prefix][key.substr(prefix.length + 1)] = storage.getItem(key);
                    if (prefix === 'shipping' && !Boolean(data[prefix][key.substr(prefix.length + 1)])) {
                        data[prefix][key.substr(prefix.length + 1)] = data.billing[key.substr(prefix.length + 1)];
                    }
                }
            }

            switch (key) {
                case MEMBERSHIP_KEY:
                    let membership = storage.getItem(MEMBERSHIP_KEY, '', isUserLoggedIn).replace(/^\,?/g, '');
                    data.line_items.push({
                        product_id: membership,
                        quantity: 1
                    })
                    break;
                case ORDER_KEY:
                    let order = storage.getItem(ORDER_KEY);
                    if (order) {
                        data.id = order;
                    }
                    break;
                case UPSELL_KEY:
                    let upsellsData = storage.getItem(UPSELL_KEY).replace(/^\,?/g, '');
                    if (upsellsData) {
                        let upsells = upsellsData.split(',');
                        for (let upsell of upsells) {
                            data.line_items.push({
                                product_id: upsell,
                                quantity: 1
                            });
                        }
                    }
                    break;
                case COUPON_KEY:
                    let coupon = storage.getItem(COUPON_KEY);

                    if (coupon) {
                        data.coupons.push(JSON.parse(coupon));
                    } else {
                        data.coupons = [];
                    }
                    break;
                case 'PSRID':
                    try {
                        function getCookie(name) {
                            var nameEQ = name + "=";
                            var ca = document.cookie.split(';');
                            for (var i = 0; i < ca.length; i++) {
                                var c = ca[i];
                                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
                            }
                            return null;
                        }
                        function eraseCookie(name) {
                            document.cookie = name + '=; Max-Age=-99999999;';
                        }
                        let referers = window.localStorage.getItem('PSRID');
                        for (let referer of referers.split(',')) {
                            data.meta_data.push({
                                key: referer,
                                value: getCookie(referer)
                            });
                            eraseCookie(referer);
                        }
                    } catch (error) {
                        // pass throw
                    }
                    break;
                default:
                    // gateway
                    let gateway = storage.getItem('payment_method');
                    if (`${gateway}-${key}` in data) {
                        data[`${gateway}-${key}`] = storage.getItem(key);
                    }
                    // default
                    if (key in data) {
                        data[key] = storage.getItem(key);
                    }
            }
        }

        let cartData = storage.getItem(CART_KEY, '', true).replace(/^\,?/g, '');
        if (cartData) {
            let products = cartData.split(',');
            for (let product of products) {
                product && data.line_items.push({
                    product_id: product,
                    quantity: 1
                });
            }
        }

        let membership = storage.getItem(MEMBERSHIP_KEY, '', isUserLoggedIn).replace(/^\,?/g, '');
        if (membership) {
            data.meta_data.push({
                key: 'tpc_membership_product_front',
                value: membership
            })
            data.line_items.push({
                product_id: membership,
                quantity: 1
            });
        }

        data['billing'] = copySafe({}, window.wpReactSettings.billing, data['billing']);
        data['shipping'] = copySafe({}, window.wpReactSettings.shipping, data['shipping']);

        return this.client.post(this.base.concat('orders'), data).then(data => {
            try {
                return data.json();
            } catch (exception) {
                return {
                    status: 400
                }
            }
        }).then(json => {
            return json;
        });
    }

    getPlansData(value) {
        let response = this.client.get(this.base.concat('upsells/select-your-plan'), { product_id: value });
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        });
    }

    getUpsellOneData() {
        let response = this.client.get(this.base.concat('upsells/upsell-v1'));
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        });
    }

    getUpsellTwoData() {
        let response = this.client.get(this.base.concat('upsells/upsell-v2'));
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        });
    }

    getUserData() {
        let response = this.client.get(this.base.concat('customer'));
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        });
    }

    updateUserData(data) {
        let response = this.client.put(this.base.concat('customer'), data);
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        });
    }

    getProductsPicYourBag(body = {}) {
        let response = this.client.get(this.base.concat('products/user/memberships'), body);
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        });
    }

    setNewPurse(id) {
        let response = this.client.get(this.base.concat(`customer/change-purse/${id}`));
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        });
    }

    getActualPurse() {
        let response = this.client.get(this.base.concat('products/user/purse'));
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        });
    }

    registerUser(data) {
        let response = this.client.post(this.base.concat(`users/register`), data);
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        });
    }

    getProductsShop(data) {
        let response = this.client.get(this.base.concat('products/category'), data);
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        });
    }

    getSubscriptionProductByCategory(product) {
        let response = this.client.get(this.base.concat('products/subscriptions/purse'), { product });
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        })
    }

    getCustomerOrders() {
        let response = this.client.get(this.base.concat('orders/customer'), { limit: 999 });
        return response.then(data => {
            return data.json();
        }).catch(data => {
            return { error: data.status };
        })
    }
}
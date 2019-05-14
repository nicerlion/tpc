import React, { Component } from 'react';
import { Redirect, Link } from 'react-router-dom';
import './index.css';
import './media.css';

import ServiceAPI from './../../api/service';
import Counter from './../../components/counter';
import Loader from './../../components/common/loader';
import TPCStorage from './../../components/common/storage';
import Coupon from './../../components/coupon/';


export default class OrderSummary extends Component {

    constructor(props) {
        super(props);

        this.props.redirectIfUserIsNotLogged(true);
        this.storage = new TPCStorage();
        let hasMembership = this.storage.hasItem(this.props.MEMBERSHIP_KEY, true);
        this.state = {
            coupon: {},
            membership: hasMembership,
            membershipProduct: {},
            loading: false,
            products: []
        }

        this.api = new ServiceAPI();
        this.onContinue = this.onContinue.bind(this);
        this.handleSubscription = this.handleSubscription.bind(this);
        this.isMember = Boolean(window.wpReactSettings.isMember);
    }

    componentDidMount() {
        this.getProducts();
    }

    componentDidUpdate(prevProps, prevState) {
        if (prevState.products.length && !this.state.products.length) {
            this.props.history.push({ pathname: '/shop', replace: true });
        }
    }

    getProducts() {
        let products = this.storage.getItem(this.props.CART_KEY, '', true).replace(/^\,?/g, '');
        this.setState({ loading: true });
        if (products) {
            this.api.getProducts(products).then(data => {
                this.setState({ products: data });

                if (data.length) {
                    data.sort((a, b) => {
                        return a.price - b.price
                    }).reverse();
                    this.api.getSubscriptionProductByCategory(data[0].id).then(membership => {
                        this.setState({ membershipProduct: membership });
                        if (this.state.membership) {
                            this.storage.setItem(this.props.MEMBERSHIP_KEY, membership.id, true);
                        }
                        this.setState({ loading: false });
                    }, data => {
                        console.error(data);
                        this.setState({ loading: false });
                    });
                } else {
                    this.setState({ loading: false });
                }
            }, error => {
                this.setState({ loading: false });
            });
        } else {
            this.setState({ loading: false });
            this.props.history.push({ pathname: '/shop', replace: true });
        }
    }

    handleSubscription(event) {
        this.setState({
            [event.target.name]: event.target.checked
        });
        if (event.target.checked) {
            this.storage.setItem(this.props.MEMBERSHIP_KEY, this.state.membershipProduct.id, true);
        } else {
            this.storage.removeItem(this.props.MEMBERSHIP_KEY, true);
        }
    }

    onContinue(event) {
        if (this.state.products.length) {
            this.props.history.push({ pathname: '/billing' });
        } else {
            this.props.history.push({ pathname: '/shop' });
        }
    }

    removeProduct(id) {
        let products = this.storage.getItem(this.props.CART_KEY, '', true);
        let productsList = products.split(',');
        this.setState({ loading: true });
        if (productsList.length) {
            if (productsList.indexOf(id.toString()) + 1) {
                productsList.splice(productsList.indexOf(id.toString()), 1);
            }
            let productState = this.state.products.find(elem => {return elem.id.toString() === id.toString()});
            this.state.products.splice(this.state.products.indexOf(productState), 1);
            this.setState({ products: this.state.products });
            this.storage.setItem(this.props.CART_KEY, productsList.join(','), true);
        }
        this.setState({ loading: false });
    }

    getSavingCart(total = 0) {
        let coupon = this.state.coupon;
        let saving = 0.0;

        if (this.props.getSignUpDiscount() && this.state.membership) {
            saving += parseFloat(total) / 2;
        } else if (this.state.membership) {
            saving += this._getSubTotal() - this.getSubTotal();
        }

        if (coupon.id) {
            let couponHasProducts = Boolean(coupon.product_ids.length);

            if (['recurring_percent', 'sign_up_fee_percent', 'percent'].indexOf(coupon.discount_type) + 1) {
                if (couponHasProducts) {
                    for (let product of this.state.products) {
                        if (!(coupon.product_ids.indexOf(product.id) + 1)) {
                            continue;
                        }
                        saving += parseFloat(parseFloat(product.price) * parseFloat(coupon.amount) / 100);
                    }
                }
                saving += parseFloat(parseFloat(total) * parseFloat(coupon.amount) / 100);
            } else if (['recurring_fee', 'fixed_cart', 'sign_up_fee'].indexOf(coupon.discount_type) + 1) {
                let subTotal = couponHasProducts ? 0.0 : total;

                if (couponHasProducts) {
                    for (let product of this.state.products) {
                        if (!(coupon.product_ids.indexOf(product.id) + 1)) {
                            continue;
                        }
                        subTotal += parseFloat(product.price);
                    }
                }
                saving += parseFloat(parseFloat(subTotal) - parseFloat(coupon.amount));
            } else if (coupon.discount_type === 'fixed_product') {
                if (couponHasProducts) {
                    let discount = 0.0;
                    for (let product of this.state.products) {
                        if (!(coupon.product_ids.indexOf(product.id) + 1)) {
                            continue;
                        }
                        discount += parseFloat(coupon.amount);
                    }
                    saving += parseFloat(parseFloat(total) - parseFloat(discount));
                }
            }
        }
        return saving;
    }

    getCouponSign() {
        let type = this.state.coupon.discount_type;
        return (['recurring_percent', 'sign_up_fee_percent', 'percent'].indexOf(type)) ? '%' : '$';
    }

    _getSubTotal() {
        return Boolean(this.state.products.length) ? this.state.products.map((product) => {
            if (this.state.membership || this.isMember) {
                return parseFloat(product.price_subscription || 0);
            }
            return parseFloat(product.price);
        }).reduce(function (first, next) {
            return parseFloat(first) + parseFloat(next);
        }) : 0.0;
    }

    getSubTotal() {
        return Boolean(this.state.products.length) ? this.state.products.map((product) => {
            if (this.state.membership && this.props.getSignUpDiscount()) {
                return product.price_subscription / 2 || 0;
            } else if (this.state.membership || this.isMember) {
                return parseFloat(product.price_subscription || 0);
            }
            return parseFloat(product.price);
        }).reduce(function (first, next) {
            return parseFloat(first) + parseFloat(next);
        }) : 0.0;
    }

    getTotal() {
        if (this.state.products.length) {
            let total = this._getSubTotal.bind(this)();
            total -= this.getSavingCart.bind(this)(total);
            return Boolean(total) ? total : 0.0;
        }
        return 0.0;
    }

    _membershipPriceShoulBeThrough() {
        if (this.state.membership && this.props.getSignUpDiscount()) {
            return true;
        }
        if (this.isMember) {
            return false;
        }
        return !this.state.membership;
    }

    getPriceWithDiscount(product) {
        return (parseFloat(product.price_subscription) / 2).toFixed(2) || 0;
    }

    render() {
        return (
            <div>
                <section class="shop-counter">
                    <div class="container">
                        <div class="row">
                            <Counter {...this.props} />
                        </div>
                    </div>
                </section>
                <div class="page-wrapper summary-wrapper">
                    <section class="os-header">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 os-content-header">
                                    <Link to={{ pathname: '/shop' }}>BACK TO SHOPPING</Link>
                                    <h1>SHOPPING BAG</h1>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 os-checkout">
                                    <button disabled={!Boolean(this.getTotal())} onClick={this.onContinue} type="button" id="continue-checkout-one">continue checkout</button>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="os-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 os-container">
                                    <div class="os-border">
                                        { !window.wpReactSettings.isMember && <div class="os-container-vip">
                                            <div class="os-checkbox-vip">
                                                <input type="checkbox" name="membership" checked={this.state.membership} onClick={this.handleSubscription} />
                                            </div>
                                            <div class="os-img-vip">
                                                <img src="https://www.thepurseclub.com/wp-content/uploads/2018/02/vip.png" alt="vip" />
                                            </div>
                                            <div class="os-text-vip">
                                                <p>VIP MEMBERSHIP PROGRAM</p>
                                                <p>With this purchase, you are activating your VIP Membership.</p>
                                            </div>
                                            <div class="os-clear"></div>
                                        </div> }
                                        <div class="os-container-order">
                                            <div class="os-order-header">
                                                <h2>ORDER SUMMARY</h2>
                                            </div>
                                            { !window.wpReactSettings.isMember && <div class="os-order-warning">
                                                <p> <span class="os-warning">!</span> Upgrade to VIP to save up to 50% on today’s order!</p>
                                            </div> }
                                            <div class="os-order-body">
                                                {Boolean(this.state.products.length) && this.state.products.map((product, index) => {
                                                    return (
                                                        <div class="os-order-item" key={index}>
                                                            <div class="os-product-img">
                                                                <img src={0 in product.images ? product.images[0].src : '/wp-content/plugins/woocommerce/assets/images/placeholder.png'} alt="image" />
                                                            </div>
                                                            <div class="os-order-info">
                                                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 os-order-data">
                                                                    <p>{product.name.toUpperCase()}</p>
                                                                    <p>COLOR: {product.attributes.color.toUpperCase()}</p>
                                                                    <div class="os-button">
                                                                        <button id="button-remove" onClick={() => { this.removeProduct(product.id) }}>Remove</button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 os-order-quantity">
                                                                    <p>QTY: 1</p>
                                                                </div>
                                                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 os-order-prices">
                                                                    {this.props.getSignUpDiscount() && <p style={this.state.membership ? {} : { 'text-decoration': 'line-through' }} class="os-red">50% OFF FIRST ORDER: ${this.getPriceWithDiscount(product)}</p>}
                                                                    <p style={this._membershipPriceShoulBeThrough() ? { 'text-decoration': 'line-through' } : {}} class="os-striped">${parseFloat(product.price_subscription || 0).toFixed(2)} VIP</p>
                                                                    <p style={(this.isMember || this.state.membership) ? { 'text-decoration': 'line-through' } : {}} class="os-striped">${parseFloat(product.price || 0).toFixed(2)} REG</p>
                                                                </div>
                                                                <div class="os-clear"></div>
                                                            </div>
                                                            <div class="os-clear"></div>
                                                        </div>
                                                    )
                                                })}
                                            </div>
                                            {/* <div class="os-container-accordion">
                                                <div id="accordion">
                                                    <div class="gift-card-accordion">
                                                        <div class="gift-card-header" id="headingOne">
                                                            <h5 class="mb-0">
                                                                <button class="btn btn-link admin-accordion-title-bt collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                                    add promo code / gift card
                                                                </button>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                            <div class="gift-card-body">
                                                                <Coupon onGetCoupon={this.onGetCoupon} />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> */}
                                            <div class="os-order-footer">
                                                <div class="os-order-footer-item">
                                                    <p>SUBTOTAL:</p>
                                                    <p>${this._getSubTotal().toFixed(2)}</p>
                                                    <div class="os-clear"></div>
                                                </div>
                                                {(this.props.getSignUpDiscount() && this.state.membership) && <div class="os-order-footer-item">
                                                    <p>PROMO CODE: 50% Off Entire Order</p>
                                                    <p>-50.00%</p>
                                                    <div class="os-clear"></div>
                                                </div>}
                                                <div class="os-order-footer-item">
                                                    <p>SHIPPING: Priority First Class USPS (5-7 days)</p>
                                                    <p class="os-red">FREE</p>
                                                    <div class="os-clear"></div>
                                                </div>
                                                <div class="os-order-footer-item">
                                                    <p>TOTAL:</p>
                                                    <p>${this.getTotal().toFixed(2)}</p>
                                                    <div class="os-clear"></div>
                                                </div>
                                                <div class="os-order-footer-item">
                                                    <p class="os-red">YOU ARE SAVING</p>
                                                    <p class="os-red">${this.getSavingCart(this._getSubTotal().toFixed(2)).toFixed(2)}</p>
                                                    <div class="os-clear"></div>
                                                </div>
                                            </div>
                                            <div class="os-checkout">
                                                <button type="button" id="continue-checkout" disabled={!Boolean(this.getTotal())} onClick={this.onContinue}>continue checkout</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 os-container">
                                    <img src="https://www.thepurseclub.com/wp-content/uploads/2018/03/how_vip_membership_works.jpg" alt="how vip membership works" />
                                    <div class="os-vip-membership">
                                        <p><b>Lorem ipsum</b> dolor sit amet, consectetur adipiscing elit. tauris volutpat eros, a suscipit odio ex ac turpis.
                                            Pellentesque rhoncus condimentum euismod. Fusce scelerisque aliquam ligula sit amet ullamcorper.
                                            Curabitur sed felis enim. Praesent quis urna id leo sollicitudin consequat.</p>

                                        <p><b>Lorem ipsum</b> dolor sit amet, consectetur adipiscing elit. tauris volutpat eros, a suscipit odio ex ac turpis.
                                            Pellentesque rhoncus condimentum euismod. Fusce scelerisque aliquam ligula sit amet ullamcorper.</p>

                                        <p><b>Lorem ipsum</b> dolor sit amet, consectetur adipiscing elit.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <Loader loading={this.state.loading} />
                    </section>
                </div>
            </div>
        )
    }
}

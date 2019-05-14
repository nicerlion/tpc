import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import './index.css';
import './media.css';

import Counter from './../../components/counter';
import Loader from './../../components/common/loader';
import TPCStorage from './../../components/common/storage';
import ServiceApi from './../../api/service';


class ProductBox extends Component {

    render() {
        return (
            <div class="col-xs-6 col-sm-5ths col-md-5ths col-lg-5ths">
                <div class="shop-product-content">
                    <div class="shop-product-box">
                        <div class="shop-product-image">
                            <Link to={{ pathname: `/shop/product/${this.props.data.id}`, state: { _products: this.props.toState, _cacheProduct: this.props.data } }}>
                                <img src={0 in this.props.data.images ? this.props.data.images[0].src : "/wp-content/plugins/woocommerce/assets/images/placeholder.png"} alt="product" />
                            </Link>
                        </div>
                        <Link to={{ pathname: `/shop/product/${this.props.data.id}`, state: { _products: this.props.toState, _cacheProduct: this.props.data } }}>
                            <div class="shop-button">
                                <p>{ this.props.data.name.toUpperCase() }</p>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        );
    }

}


export default class Shop extends Component {

    constructor(props) {
        super(props);
        this.props.redirectIfUserIsNotLogged(true);

        this.TABS = [
            {
                label: 'GOLD MEMBERSHIP',
                slug: 'gold'
            },
            {
                label: 'PLATINUM MEMBERSHIP',
                slug: 'platinum'
            }
        ]

        this.state = {
            loading: false,
            paginator: {
                limit: 20
            },
            currentTab: {},
            products: {},
            banner: {
                gold: {
                    desktop: {
                        src: 'https://www.thepurseclub.com/wp-content/uploads/2018/02/gold-membership.jpg',
                        alt: 'image'
                    },
                    mobile: {
                        src: 'https://www.thepurseclub.com/wp-content/uploads/2018/02/gold-membership-mob.jpg',
                        alt: 'image'
                    }
                },
                platinum: {
                    desktop: {
                        src: 'https://www.thepurseclub.com/wp-content/uploads/2018/02/platinum-membership.jpg',
                        alt: 'image'
                    },
                    mobile: {
                        src: 'https://www.thepurseclub.com/wp-content/uploads/2018/02/platinum-membership-mob.jpg',
                        alt: 'image'
                    }
                }
            }
        }

        this.selectTab = this.selectTab.bind(this);
        this.getMore = this.getMore.bind(this);
        this.storage = new TPCStorage();
    }

    componentDidMount() {
        this.service = new ServiceApi();

        let historyState = this.props.history.location.state || {};
        if (historyState._products) {
            this.setState({
                products: Object.assign(this.state.products, {
                    [historyState._products.tab.slug]: historyState._products.products,
                }),
                paginator: Object.assign(this.state.paginator, {
                    [historyState._products.tab.slug]: historyState._products.paginator
                })
            });
            this.selectTab(historyState._products.tab);
        } else if (!this.state.currentTab.tab) {
            this.selectTab(this.TABS[0]);
        }
    }

    getProducts() {
        return this.state.currentTab.products ? this.state.currentTab.products: [];
    }

    selectTab(tab) {
        if (!(tab.slug in this.state.products)) {
            this.setState({ loading: true });
            this.service.getProductsShop({
                category: tab.slug, banner: true,
                page: 1,
                limit: this.state.paginator.limit
            }).then(data => {
                if (!([400, 404, 405, 500].indexOf('data' in data ? data.data.status: data.status) + 1)) {
                    this.setState({
                        tab,
                        products: Object.assign(this.state.products, {
                            [tab.slug]: data.products
                        }),
                        banner: Object.assign(this.state.banner, {
                            [tab.slug]: data.banner
                        }),
                        loading: false,
                        currentTab: {
                            tab,
                            products: data.products,
                            banner: data.banner,
                            paginator: data.pagination
                        },
                        paginator: Object.assign(this.state.paginator, {
                            [tab.slug]: data.pagination
                        })
                    });
                } else {
                    this.setState({
                        tab,
                        products: Object.assign(this.state.products, {
                            [tab.slug]: []
                        }),
                        banner: Object.assign(this.state.banner, {
                            [tab.slug]: this.state.banner[tab.slug]
                        }),
                        loading: false,
                        currentTab: {
                            tab,
                            products: [],
                            banner: this.state.banner[tab.slug],
                            paginator: Object.assign(this.state.paginator, {
                                [tab.slug]: {
                                    page: 1,
                                    next: null,
                                    prev: null
                                }
                            })
                        },
                        paginator: Object.assign(this.state.paginator, {
                            [tab.slug]: {
                                page: 1,
                                next: null,
                                prev: null
                            }
                        })
                    });
                }
            });
        } else {
            this.setState({
                currentTab: {
                    tab,
                    products: this.state.products[tab.slug],
                    banner: this.state.banner[tab.slug],
                    paginator: this.state.paginator[tab.slug]
                }
            });
        }
    }

    getMore() {
        let slug = this.state.currentTab.tab.slug;
        let page = this.state.paginator[slug].page + 1;
        this.setState({ loading: true });
        this.service.getProductsShop({ category: slug, limit: this.state.paginator.limit, page }).then(data => {
            this.setState({
                products: Object.assign({}, this.state.products, {
                    [slug]: [...this.state.products[slug], ...data.products]
                }),
                loading: false,
                paginator: Object.assign(this.state.paginator, {
                    [slug]: data.pagination
                })
            });
            this.selectTab(this.state.currentTab.tab);
        });
    }

    hasNextPage() {
        if (this.state.currentTab.tab) {
            let slug = this.state.currentTab.tab.slug;
            return slug in this.state.paginator ? this.state.paginator[slug].next || false: false;
        }
        return false;
    }

    hasProductsInCart() {
        return Boolean(
            this.storage.getItem(this.props.CART_KEY, '', true).replace(/^\,?/g, '')
        );
    }

    render() {
        return (
            <div>
                <div class="page-wrapper shop-wrapper">
                    <section class="shop-header">
                        <div class="container">
                            <div class="row">
                                <div class="shop-header-container">
                                    { this.state.currentTab.tab && this.TABS.map((tab, index) => {
                                        return (
                                            <div>
                                                <img style={this.state.currentTab.tab.slug !== tab.slug && {'display': 'none'} || {}} class="shop-desktop-image" src={this.state.banner[tab.slug] && this.state.banner[tab.slug].desktop.src} alt={this.state.banner[tab.slug] && this.state.banner[tab.slug].desktop.alt} />
                                                <img style={this.state.currentTab.tab.slug !== tab.slug && {'display': 'none'} || {}} class="shop-mobile-image" src={this.state.banner[tab.slug] && this.state.banner[tab.slug].mobile.src} alt={this.state.banner[tab.slug] && this.state.banner[tab.slug].mobile.alt} />
                                            </div>
                                        );
                                    }) }
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="shop-counter">
                        <div class="container">
                            <div class="row">
                                <Counter {...this.props} />
                            </div>
                        </div>
                    </section>
                    <section class="shop-products">
                        <div class="container">
                            <div class="row">
                                {this.hasProductsInCart() && <div class="pd-links-container">
                                    <p class="go-checkout">
                                        <Link to={ { pathname: '/shop/summary'} }>Go to Checkout</Link>
                                    </p>
                                </div>}
                                <ul class="nav nav-pills">
                                    { this.TABS.map((tab, index) => {
                                        return (
                                            <li className={`${this.state.currentTab.tab ? tab.slug === this.state.currentTab.tab.slug && 'active' :  index === 0 && 'active'}`}>
                                                <a href={`#${tab.slug}`} data-toggle="tab" onClick={(event) => this.selectTab(tab)}>{ tab.label }</a>
                                            </li>
                                        )
                                    }) }
                                </ul>
                                <div class="tab-content clearfix">
                                    {
                                        this.TABS.map((tab, index) => {
                                            return (
                                                <div className={`tab-pane ${index === 0 && 'active'}`} id={tab.slug}>
                                                    {this.getProducts().map((product, index) => {
                                                        return <ProductBox data={product} key={index} toState={this.state.currentTab} />;
                                                    })}
                                                </div>
                                            )
                                        })
                                    }
                                    <div class="as-clear"></div>
                                    {this.hasNextPage() && <button class="as-button as-button-view" onClick={this.getMore}>VIEW MORE</button>}
                                </div>
                            </div>
                        </div>
                    </section>
                    <Loader loading={this.state.loading} />
                </div>
            </div>
        )
    }
}
import React, { Component } from 'react';

import './index.css';
import Loader from './../common/loader/';


export default class OrderSummary extends Component {

    getSavingCart(total = 0) {
        let coupon = this.props.coupon;
        if (coupon.id) {
            let products = Boolean(coupon.product_ids.length);
            // let freeShipping = coupon.free_shipping;
            // let total = freeShipping ? this.getSubTotal() : this.getTotal();
    
            if (['recurring_percent', 'sign_up_fee_percent', 'percent'].indexOf(coupon.discount_type) + 1) {
                if (products) {
                    for (let product of this.props.products) {
                        if (!(coupon.product_ids.indexOf(product.id) + 1)) {
                            continue;
                        }
                        return parseFloat(parseFloat(product.price) * parseFloat(coupon.amount) / 100);
                    }
                }
                return parseFloat(parseFloat(total) * parseFloat(coupon.amount) / 100);
            } else if (['recurring_fee', 'fixed_cart', 'sign_up_fee'].indexOf(coupon.discount_type) + 1) {
                let subTotal = products ? 0.0: total;
    
                if (products) {
                    for (let product of this.props.products) {
                        if (!(coupon.product_ids.indexOf(product.id) + 1)) {
                            continue;
                        }
                        subTotal += parseFloat(product.price);
                    }
                }
                return parseFloat(parseFloat(subTotal) - parseFloat(coupon.amount));
            } else if (coupon.discount_type === 'fixed_product') {
                if (products) {
                    let discount = 0.0;
                    for (let product of this.props.products) {
                        if (!(coupon.product_ids.indexOf(product.id) + 1)) {
                            continue;
                        }
                        discount += parseFloat(coupon.amount);
                    }
                    return parseFloat(parseFloat(total) - parseFloat(discount));
                }
            }
        }
        return 0.0;
    }

    getCouponSign() {
        let type = this.props.coupon.discount_type;
        return (['recurring_percent', 'sign_up_fee_percent', 'percent'].indexOf(type)) ? '%': '$';
    }

    getSubTotal() {
        return Boolean(this.props.products.length) ? this.props.products.map(function (product) {
            return parseFloat(product.price);
        }).reduce(function (first, next) {
            return parseFloat(first) + parseFloat(next);
        }): 0.0;
    }

    getTotal() {
        if (this.props.products.length) {
            let total = this.getSubTotal.bind(this)();
            total -= this.getSavingCart.bind(this)(total);
            return Boolean(total) ? total: 0.0;
        }
        return 0.0;
    }

    render () {
        return (
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cc-col-content">
                <div class="cc-order-box">
                    <div class="cc-order-header-content clearfix">
                        <p>Order Summary</p>
                        <span>Member Status:&nbsp;</span>
                        <span class="cc-vip-text">VIP</span>
                    </div>
                    {Boolean(this.props.products.length) && this.props.products.map((product) => {
                        return (
                            <div class="cc-watch-box clearfix">
                                <img alt={0 in product.images ? product.images[0].alt: 'subscription'} src={0 in product.images ? product.images[0].src : 'http://thepurseclub.com/wp-content/plugins/woocommerce/assets/images/placeholder.png'} />
                                <span class="cc-watch-text">{product.name}</span>
                            </div>
                        );
                    })}
                    <div class="cc-subtotal-box clearfix">
                        <div class="col-xs-6 col-sm-6 col-md-8 col-lg-8">
                            <span class="cc-subtotal-text">SUBTOTAL:</span>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                            <span>${this.getSubTotal.bind(this)().toFixed(2)}</span>
                        </div>
                    </div>
                    <div class="cc-promo-box clearfix">
                        {this.props.coupon.id && (
                            <div class="cc-promo-text-box clearfix">
                                <div class="col-xs-6 col-sm-6 col-md-8 col-lg-8">
                                    <span class="cc-promo-text">PROMOCODE:<br />{this.props.coupon.description}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                                    <span>{this.getCouponSign.bind(this)()}{this.props.coupon.amount}</span>
                                </div>
                            </div>
                        )}
                        <div class="cc-promo-text-box-2 clearfix">
                            <div class="col-xs-6 col-sm-6 col-md-8 col-lg-8">
                                <span class="cc-subtotal-text clearfix">SHIPPING:</span>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                                <span class="free-shipping">FREE</span>
                            </div>
                        </div>
                    </div>
                    <div class="cc-total-box clearfix">
                        <div class="cc-total-text-box clearfix">
                            <div class="col-xs-6 col-sm-6 col-md-8 col-lg-8">
                                <span class="cc-subtotal-text">TOTAL</span>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                                <span>${this.getTotal.bind(this)().toFixed(2)}</span>
                            </div>
                        </div>
                        {this.props.coupon.id && (
                            <div class="cc-total-text-box-2 clearfix">
                                <div class="col-xs-6 col-sm-6 col-md-8 col-lg-8">
                                    <span class="cc-total-text">YOU ARE SAVING</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                                    <span>${this.getSavingCart.bind(this)(this.getSubTotal.bind(this)().toFixed(2)).toFixed(2)}</span>
                                </div>
                            </div>
                        )}
                    </div>
                    <Loader id="summary" loading={this.props.loading} />
                </div>
            </div>
        );
    }

}

OrderSummary.defaultProps = {
    products: [],
    coupon: {},
    loading: false
}

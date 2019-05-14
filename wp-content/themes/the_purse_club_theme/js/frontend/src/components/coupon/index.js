import React, { Component } from 'react';

import './index.css';

import FormComponent from './../common/form/';
import { TextField } from './../common/form/fields';
import Alert from './../common/alert';
import Loader from './../common/loader';
import TPCStorage from './../common/storage';

export default class Coupon extends FormComponent(Component) {

    constructor(props) {
        super(props);
        this.COUPON_KEY = 'coupon';

        this.state = {
            coupon: new TextField('coupon'),
            loading: false,
            showAlert: {
                type: 'warning',
                message: ''
            }
        }
        this.applyCoupon = this.applyCoupon.bind(this);
        this.storage = new TPCStorage();
    }

    componentDidMount() {
        super.componentDidMount();
        this.getCouponFromLocalStorage.bind(this)();
    }

    getCouponFromLocalStorage() {
        let coupon = this.storage.getItem(this.COUPON_KEY);
        if (coupon) {
            coupon = JSON.parse(coupon);
            this.applyCoupon(undefined, coupon.code);
        }
    }

    applyCoupon(event, value='') {
        value = value || this.state.coupon.value;
        if (value) {
            this.setState({ loading: true });
            this.api.getCoupon(value).then(data => {
                this.setState({ loading: false });
                if (data.id) {
                    this.props.onGetCoupon && this.props.onGetCoupon(data);
                    event && this.setState({
                        showAlert: Object.assign(this.state.showAlert, {
                            type: 'success',
                            message: `Coupon '${this.state.coupon.value}' applied.`
                        }),
                        coupon: Object.assign(this.state.coupon, {
                            value: ''
                        })
                    });
                    let valueToSave = JSON.stringify({
                        code: data.code,
                        discount: data.amount,
                        discount_type: data.discount_type
                    });
                    this.storage.setItem(this.COUPON_KEY, valueToSave);
                } else {
                    event && this.setState({
                        showAlert: Object.assign(this.state.showAlert, {
                            type: 'error',
                            message: `Not coupon found with code '${this.state.coupon.value}'.`
                        })
                    });
                }
            });
        } else {
            this.setState({
                showAlert: Object.assign(this.state.showAlert, {
                    type: 'warning',
                    message: 'Not coupon to apply'
                })
            })
        }
    }

    onHideAlert() {
        this.setState({
            showAlert: Object.assign(this.state.showAlert, {
                message: ''
            })
        })
    }

    render() {
        let alert = this.state.showAlert.message ? <Alert message={this.state.showAlert.message} type={this.state.showAlert.type} onHide={this.onHideAlert.bind(this)} /> : null;
        return (
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cc-col-content">
                <div class="cc-order-box">
                    <div class="cc-order-header-content clearfix">
                        <span class="cc-shipping-address">Have a Coupon</span>
                    </div>
                    <div class="cc-promo-text-box-2 clearfix">
                        <div class="cc-card-mini-box">
                            <div class="cc-card-form">
                                <label for="coupon">Coupon Code</label>
                                {this.generateField('coupon')}
                            </div>
                        </div>
                    </div>
                    <div class="cc-promo-text-box-2 clearfix">
                        <button class="apply-coupon" type="button" onClick={this.applyCoupon} id="couponToApply">APPLY COUPON</button>
                    </div>
                    <Loader id={this.COUPON_KEY} loading={this.state.loading} />
                </div>
                { alert }
            </div>
        );
    }
}
import React, { Component } from 'react';
import { Redirect, Link } from 'react-router-dom';
import ReactPixel from 'react-facebook-pixel';
import './index.css'
import './media.css'

import ServiceApi from './../../api/service';

import Alert from './../../components/common/alert';
import Loader from './../../components/common/loader';
import OrderSummary from './../../components/summary';
import FormCreditCard from './../../components/forms/credit-card/';
import Coupon from './../../components/coupon/';
import Counter from './../../components/counter';
import TPCStorage from './../../components/common/storage';

export default class CreditCard extends Component {

    constructor(props) {
        super(props);

        this.MEMBERSHIP_KEY = props.MEMBERSHIP_KEY;
        this.UPSELL_KEY = props.UPSELL_KEY;

        this.props.redirectIfUserIsNotLogged(true);
        let terms = props.history.location.state;

        this.state = {
            terms: Boolean(terms) ? Boolean(terms.rejected): true,
            coupon: {},
            products: [],
            loading: false,
            payment_data: {},
            alert: {
                message: '',
                type: 'error',
                visible: false,
                delay: 10000
            }
        }

        this.storage = new TPCStorage();
        this.onGetCoupon = this.onGetCoupon.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.getProducts = this.getProducts.bind(this);
        this.getProductsInLocalStorage = this.getProductsInLocalStorage.bind(this);
        this.handleButton = this.handleButton.bind(this);
        this.formInit = this.formInit.bind(this);
        this.getRejected = this.getRejected.bind(this);
    }

    componentDidMount() {
        this.api = new ServiceApi();
        this.getProducts();

        this.setState({ loading: true });
        this.api.getGateways().then(array => {
            this.setState({ loading: false });
            array.map(gateway => {
                if (gateway.id === 'limelight') {
                    this.setState({
                        payment_data: {  // use underscore for php
                            payment_method: gateway.id,
                            payment_method_title: gateway.title
                        }
                    });
                    this.storage.setItem('payment_method', gateway.id);
                    this.storage.setItem('payment_method_title', gateway.title);
                }
            });
        });

        if (this.props.history.location.state) {
            let historyState = this.props.history.location.state;
            if (historyState.rejected) {
                this.setState({
                    alert: Object.assign(this.state.alert, {
                        message: 'An error ocurred during transaction',
                        visible: true
                    })
                });
            }
        }
    }

    getProductsInLocalStorage() {
        let membership = this.storage.getItem(this.props.MEMBERSHIP_KEY, '', true).replace(/^\,?/g, '');
        let upsells = this.storage.getItem(this.props.UPSELL_KEY, '').replace(/^\,?/g, '');
        let products = this.storage.getItem(this.props.CART_KEY, '', true).replace(/^\,?/g, '');

        return [...membership.split(','), ...upsells.split(','), ...products.split(',')].join(',');
    }

    getProducts() {
        let products = this.getProductsInLocalStorage();
        // NEW FLOW NOT SHOW PRODUCTS IN CHECKOUT
        // this.setState({ loading: true });
        // this.api.getProducts(products).then(data => {
        //     this.setState({
        //         products: data,
        //         loading: false
        //     })
        // });
    }

    onGetCoupon(coupon) {
        this.setState({ coupon });
    }

    handleChange(event) {
        this.setState({
            [event.target.name]: event.target.type === 'checkbox' ? event.target.checked : event.target.value
        });
    }

    formInit(child) {  // cannot access to state here yet!
        this.setState({
            form: { callback: child.validateAll }
        });
    }

    hideAlert() {
        this.setState({
            alert: Object.assign(this.state.alert, {
                visible: false
            })
        })
    }

    getRejected() {
        let rejected = false;
        if (this.props.history.location.state) {
            rejected = Boolean(this.props.history.location.state.rejected);
        }
        return Boolean(this.storage.getItem(this.props.UPSELLS_OPENED_KEY)) ? true: rejected;
    }

    handleButton(event) {
        if (this.state.terms) {
            this.setState({ loading: true });
            this.state.form.callback().then(result => {
                if (result.error) {
                    this.setState({
                        alert: Object.assign(this.state.alert, {
                            visible: true,
                            message: 'Form has errors'
                        }),
                        loading: false
                    });
                } else {
                    if (this.getRejected()) {
                        this.api.createOrder({ ...this.props }).then(response => {
                            if ('result' in response) {
                                this.storage.setItem(this.props.ORDER_KEY, response.id);
                                this.setState({
                                    alert: Object.assign(this.state.alert, {
                                        message: response.message ? response.message: 'An error ocurred during transaction',
                                        visible: true
                                    }),
                                    loading: false
                                });
                            } else {
                                this.setState({ loading: false });
                                this.props.history.push({ pathname: '/receipt', state: { order: response } });
                            }
                        });
                    } else {
                        let value = this.getProductsInLocalStorage() || '';
                        ReactPixel.track('AddToCart', { value });
                        ReactPixel.track('Lead', { value });
                        this.props.history.push({ pathname: '/upsells/v2' });
                    }
                }
            });
        } else {
            this.setState({
                alert: Object.assign(this.state.alert, {
                    message: 'You must accept terms and conditions',
                    visible: true
                })
            });
        }
        event.preventDefault();
        // handleButton
    }

    render() {
        return !(this.getProductsInLocalStorage()) ? <Redirect to={'/shop'} />: (
            <div>
                <section class="shop-counter">
                    <div class="container">
                        <div class="row">
                            <Counter {...this.props} />
                        </div>
                    </div>
                </section>
                <section class="cc-header">
                    <div class="cc-top">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <h1>COMPLETE YOUR ORDER</h1>
                                    <p>Enter Payment information</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="cc-second-sec">
                        <div class="container">
                            <div class="row">
                                {/* <div class="col-xs-12 col-md-push-8 col-md-4">
                                    <OrderSummary coupon={this.state.coupon} products={this.state.products} loading={this.state.loading}/>
                                    <Coupon onGetCoupon={this.onGetCoupon} />
                                </div> */}
                                <div class="col-xs-12 col-md-12 col-md-12">
                                    <div class="">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cc-col-content">
                                            <div class="cc-card-info">
                                                <div class="cc-card-header-content clearfix">
                                                    <span class="cc-card-address">Credit Card Information</span>
                                                    <div class="cc-lock-text">    
                                                       <img alt="lock" src="https://www.thepurseclub.com/wp-content/uploads/2018/01/lock.png" />
                                                        <span>This is a secure 128-bit<br/> SSL encrypted payment</span>
                                                    </div>
                                                </div>
                                                <div class="cc-form-content">    
                                                    <div class="cc-payment clearfix">
                                                        <span>We Accept</span>
                                                        <img alt="available-cards" src="https://www.thepurseclub.com/wp-content/uploads/2018/01/credit-cards.png" />
                                                        <span class="cc-payment-required">*Required fields</span>
                                                    </div>
                                                    {this.state.payment_data.payment_method && <FormCreditCard useStorage paymentData={this.state.payment_data} onInit={this.formInit} />}
                                                    <div class="cc-check-box clearfix">
                                                        <input type="checkbox" name="terms" id="terms" value={this.state.terms} checked={this.state.terms} onChange={this.handleChange} />
                                                        <label for="terms">I accept all <a class="check-link-terms" href="#" data-toggle="modal" data-target="#termsModal">policies</a>, <a class="check-link-terms" href="#" data-toggle="modal" data-target="#privacyModal">terms &amp; conditions</a>.</label>
                                                    </div>
                                                    <div class="cc-button-sec">
                                                        <div class="cc-order-button" id="completeCheckout">
                                                            <Link to={{ pathname: '/upsells/v2' }} onClick={this.handleButton}>COMPLETE CHECKOUT&nbsp;>></Link>
                                                        </div>
                                                    </div>
                                                    <div class="cc-security-img">
                                                        <img alt="security" src="https://www.thepurseclub.com/wp-content/uploads/2018/01/security-logos.png" />
                                                    </div>
                                                    <Loader loading={this.state.loading} />
                                                </div>    
                                            </div>
                                            {/* <div class="cc-how-content">
                                                <div class="cc-how-header-content clearfix">
                                                    <span class="cc-how-shipping-address">How VIP Membership works</span>
                                                </div>
                                                <p>Receive a New Bag Every Month.</p>
                                                <p>By signing up for the Gold or Platinum Membership with The Purse Club, you are enrolling in a monthy membership program in which you receive a new purse every 30 days. On the 30th day after your initial purchase and enrolment, and every 30 days thereafter, you will be billed the same amount as you are paying today and will be shipped another purse based upon your style preferences.</p>      
                                                <p>Cancel Anytime</p>
                                                <p>You can cancel or change your shipment at any time by logging into your online account at www.thepurseclub.com, calling 888-634-4542, or emailing support@thepurseclub.com.</p>
                                                <p>How Our Multi-Month Prepayment Options Work:</p>
                                                <p>By choosing the 3-month, 6-month or 12-month Gold or Platinum Pre-Pay options, you have agreed to pay for 3, 6 or 12 months worth of purses up front in order to receive a discount on your purchase. 1 new purse will ship to you every 30 days based upon the pre-payment option you have chosen. You will not be billed again or enrolled in a monthly membership.</p>
                                            </div> */}
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                </section>
                { this.state.alert.visible && <Alert {...this.state.alert} onHide={this.hideAlert.bind(this)} /> }
            </div>
        );
    }
}
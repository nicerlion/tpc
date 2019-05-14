import React, { Component } from 'react';
import { Redirect, Link } from 'react-router-dom';
import ReactPixel from 'react-facebook-pixel';
import './index.css';
import './media.css';

import ServiceApi from './../../api/service';
import FormCheckout from './../../components/forms/checkout/';
import Alert from '../../components/common/alert/';
import Loader from './../../components/common/loader/';
import Counter from './../../components/counter';
import TPCStorage from './../../components/common/storage';

class BillingShipping extends Component {

    constructor(props) {
        super(props);
        this.props.redirectIfUserIsNotLogged(true);

        this.state = {
            same: 'same',
            showAlert: false,
            loading: false,
            userBillingInfo: window.wpReactSettings.billing,
            userShippingInfo: window.wpReactSettings.shipping
        }

        this.handleChange = this.handleChange.bind(this);
        this.buttonSubmit = this.buttonSubmit.bind(this);
        this.formInit = this.formInit.bind(this);
        this.formDeteach = this.formDeteach.bind(this);
        this.getProductsInLocalStorage = this.getProductsInLocalStorage.bind(this);
        this.storage = new TPCStorage();
    }

    componentDidMount() {
        this.api = new ServiceApi();
    }

    getProductsInLocalStorage() {
        return this.storage.getItem(this.props.CART_KEY, false, true);
    }

    handleChange(event) {
        this.setState({
            [event.target.name]: event.target.value
        })
    }

    formInit(child) {  // cannot access to state here yet!
        this.setState({
            [child.props.type.toLowerCase()]: {callback: child.validateAll}
        });
    }

    formDeteach(child) {
        this.setState({
            [child.props.type.toLowerCase()]: {
                callback: () => {
                    return new Promise(function(resolve, reject) {
                        resolve({ error: false });
                    });
                }
            }
        })
    }

    hideAlert() {
        this.setState({
            showAlert: false
        })
    }

    buttonSubmit(event) {
        ReactPixel.track('InitiateCheckout', { value: this.props.MEMBERSHIP_KEY });
        let forms = ['shipping', 'billing'];
        let messageError = '';
        let __promises = [];

        for (let form of forms) {
            if (this.state[form] && this.state[form].callback) {
                let callbackResponse = this.state[form].callback();

                this.setState({ loading: true });
                __promises.push(callbackResponse.then(result => {
                    result.message = result.error ? `${form.toUpperCase()} has errors` : '';
                    if (messageError) {
                        messageError = 'Looks like both forms have errors!';
                    } else {
                        messageError = result.message;
                    }
                    this.setState({
                        [form]: Object.assign(this.state[form], result)
                    });
                }));
            }
        }

        Promise.all(__promises).then(results => {
            this.setState({
                showAlert: messageError,
                loading: false
            });
            if (!messageError) {
                this.props.history.push({ pathname: '/checkout' });
            }
        });
        event.preventDefault();
    }

    render() {
        let formShipping = null;
        if (this.state.same === 'different') {
            formShipping = (
                <div class="sab-box-data clearfix">
                    <FormCheckout 
                        type="Shipping"
                        onInit={this.formInit}
                        userData={this.state.userShippingInfo}
                        onDeteach={this.formDeteach}
                        httpClient={this.api}
                        useStorage />
                </div>
            );
        }

        let alert = this.state.showAlert ? <Alert message={this.state.showAlert} onHide={ this.hideAlert.bind(this) } type='error' delay='10000'/> : null;

        return !(this.getProductsInLocalStorage()) ? <Redirect to={'/shop'} />: (
            <div>
                <div class="page-wrapper">
                    <section class="shop-counter">
                        <div class="container">
                            <div class="row">
                                <Counter {...this.props} />
                            </div>
                        </div>
                    </section>
                    <section class="sab-header">
                        <div class="sab-top">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <h1>SHIPPING AND BILLING</h1>
                                        <p>Enter address information</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="sab-container">
                        <div class="container sab-container">
                            <div class="row">
                                <div class="sab-content">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="sab-big-container">
                                            <div class="sab-container-box clearfix">
                                                <div class="sab-header-content clearfix">
                                                    <span class="sab-shipping-address">Shipping Information</span>
                                                    <span>*Required fields</span>
                                                </div>
                                            </div>
                                            <div class="sab-box-data clearfix">
                                                <FormCheckout
                                                    type="Billing"
                                                    onInit={this.formInit}
                                                    userData={this.state.userBillingInfo}
                                                    httpClient={this.api}
                                                    useStorage />
                                            </div>
                                            <div class="sab-header-content clearfix">
                                                <span class="sab-shipping-address">Billing  Information</span>
                                            </div>
                                            <div class="sab-shipping-sec">
                                                <form class="sab-shipping-form">
                                                    <div class="sab-shipping-data">
                                                        <input id="same" type="radio" name="same" value="same" checked={this.state.same === 'same'} onChange={this.handleChange} />
                                                        <label for="same"> Same as Shipping Information</label>
                                                    </div>
                                                    <div class="sab-shipping-data">
                                                        <input id="different" type="radio" name="same" value="different" checked={this.state.same === 'different'} onChange={this.handleChange} />
                                                        <label for="different">Different from Shipping Information</label>
                                                    </div>
                                                </form>
                                            </div>
                                            {formShipping}
                                            <div class="sab-shipping-sec-continue-btn">
                                                <div class="sab-checkout-button">
                                                    <Link to={ {pathname: '/checkout'} } onClick={this.buttonSubmit}>CONTINUE CHECKOUT>></Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    { alert }
                    <Loader id="summary" loading={this.state.loading} />
                </div>
            </div>
        );
    }
}

export default BillingShipping;

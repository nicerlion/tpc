import React, { Component } from 'react';
import './index.css';
import './media.css';

import FormCheckout from './../../../components/forms/checkout/';
import ServiceApi from './../../../api/service';
import Loader from './../../../components/common/loader';


export default class PaymentShipping extends Component {

    constructor(props) {
        super(props);

        this.state = {
            response: {},
            loading: false
        }
        this.formInit = this.formInit.bind(this);
        this.handleButton = this.handleButton.bind(this);
    }

    componentDidMount() {
        this.api = new ServiceApi();

        this.setState({ response: window.wpReactSettings });
        this.props.onGetUserInfo && this.props.onGetUserInfo(window.wpReactSettings);
    }

    formInit(child) {  // cannot access to state here yet!
        this.setState({
            [child.props.type.toLowerCase()]: { callback: child.validateAll, getData: child.getData }
        });
    }

    handleButton(event) {
        let forms = ['billing', 'shipping'];
        let __promises = [];

        this.setState({ loading: true });

        for (let form of forms) {
            if (form in this.state) {
                let promise = this.state[form].callback();
                __promises.push(promise.then(result => {
                    if (!result.error) {
                        result.data = this.state[form].getData();
                    }
                    return result;
                }));
            }
        }

        Promise.all(__promises).then(results => {
            if (results.every(result => {return !result.error})) {
                let data = {};
                results.forEach(elem => {
                    data[elem.data[0].prefix] = {};
                    elem.data.forEach(field => {
                        data[field.prefix][field.name.replace(`${field.prefix}_`, '')] = field.value;
                    });
                });

                this.api.updateUserData(data).then(response => {
                    this.setState({
                        loading: false
                    });
                }, response => {
                    this.setState({
                        loading: false
                    });
                });
            } else {
                this.setState({
                    loading: false
                });
            }
        });

    }

    render () {
        return (
            <div>
                <section>
                    <div class="container pas-main-content">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="pas-main-text clearfix">
                                    <span class="pas-main-title">BILLING INFORMATION</span>
                                    <span>*Required fields</span>
                                </div>
                                <div class="pas-box-data clearfix">
                                    <FormCheckout edit type="Billing" onInit={this.formInit} userData={ this.state.response.billing } />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="pas-main-text clearfix">
                                <span class="pas-main-title">SHIPPING INFORMATION</span>
                                    <span>*Required fields</span>
                                </div>
                                <div class="pas-box-data clearfix">
                                    <FormCheckout edit type="Shipping" onInit={this.formInit} userData={ this.state.response.shipping } />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="pas-checkout-button">
                                    <button onClick={this.handleButton}>SAVE CHANGES</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <Loader id="customer-info" loading={this.state.loading} />
                </section>
            </div>
        )
    }
    
}
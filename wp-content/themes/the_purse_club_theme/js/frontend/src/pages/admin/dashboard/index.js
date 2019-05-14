import React, { Component } from 'react';
import { Redirect, Link } from 'react-router-dom';
import './index.css';
import './media.css';

import Orders from './../orders/';
import CustomerInfo from './../customer-info/';
import CustomerService from './../customer-service/';


export default class Dashboard extends Component {

    constructor(props) {
        super(props);

        this.state = {
            userData: {}
        }

        this.onGetUserInfo = this.onGetUserInfo.bind(this);
    }

    onGetUserInfo(userData) {
        this.setState({ userData });
    }

    render () {
        return (
            <div class="page-wrapper">
                <section>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="admin-header">
                                    <div class="admin-line"></div>
                                    <div class="admin-title-header">
                                        <h1>MY ACCOUNT</h1>
                                    </div>
                                    <div class="admin-account-section clearfix">
                                        {/* <div class="admin-type-mini-box">
                                            <p>GOLD</p>
                                            <p>MEMBERSHIP</p>
                                        </div> */}
                                        <div class="admin-user-name">
                                            <p>WELCOME, { this.state.userData.billing ? `${this.state.userData.billing.first_name.toUpperCase()}`: '' }</p>
                                        </div>
                                        { window.wpReactSettings.isMember && <div class="admin-store">
                                            <Link to={ '/admin/pick-your-bag' }>
                                                Change your bag
                                            </Link>
                                        </div> }
                                        <div class="admin-store asrm">
                                            <Link to={'/shop'}>
                                                Go to shop
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link admin-accordion-title-bt collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                    BILLING & SHIPPING
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body">
                                                <CustomerInfo onGetUserInfo={this.onGetUserInfo} />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link admin-accordion-title-bt collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    ORDER SUMMARY
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="card-body">
                                                <Orders />
                                            </div>
                                        </div>
                                    </div> 
                                    {/* <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link admin-accordion-title-bt collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    CUSTOMER SERVICE
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                            <div class="card-body">
                                                <CustomerService />
                                            </div>
                                        </div>
                                    </div> */}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        )
        
    }
}
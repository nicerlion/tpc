import React, { Component } from 'react';
import { Redirect, Link } from 'react-router-dom';
import './index.css';
import './media.css';

import FormRegister from './../../components/forms/register';
import Loader from './../../components/common/loader';
import ServiceAPI from './../../api/service';


export default class Register extends Component {

    constructor(props) {
        super(props);

        this.state = {
            loading: false
        }

        this.formInit = this.formInit.bind(this);
        this.registerUser = this.registerUser.bind(this);
        this.keyPress = this.keyPress.bind(this);

        let quizColor = sessionStorage.getItem('purseColor');
        let quizSize = sessionStorage.getItem('purseSize');
        let quizType = sessionStorage.getItem('purseType');

        let redirect = this.props.redirectIfUserIsNotLogged(false);
        if (!redirect) {
            this.props.history.push({
                pathname: '/shop',
                replace: true
            });
        } else if (!quizColor || !quizSize || !quizType) {
            window.location.href = '/take-style-quiz';
        }

    }

    formInit(child) {
        this.setState({
            form: { callback: child.validateAll, getData: child.getData }
        });
    }

    keyPress(event) {
        if (event.charCode === 13) {
            this.registerUser(event);
        }
    }

    registerUser(event) {
        this.setState({ loading: true });
        this.state.form.callback().then(result => {
            if (!result.error) {
                let serviceAPI = new ServiceAPI();
                let dataForm = this.state.form.getData();
                let data = {
                    name: dataForm.find(elem => elem.name === 'name').value,
                    email: dataForm.find(elem => elem.name === 'email').value,
                    password: dataForm.find(elem => elem.name === 'password').value,
                    type: sessionStorage.getItem('purseType'),
                    color: sessionStorage.getItem('purseColor'),
                    size: sessionStorage.getItem('purseSize')
                }
                serviceAPI.registerUser(data).then(response => {
                    this.setState({ loading: false });
                    if (response.id) {
                        sessionStorage.removeItem('purseColor');
                        sessionStorage.removeItem('purseSize');
                        sessionStorage.removeItem('purseType');
                    }
                    window.location.reload();
                }, response => {
                    this.setState({ loading: false });
                });
            } else {
                this.setState({ loading: false });
            }
        });
    }

    render() {
        return (
            <div>
                <div class="page-wrapper">
                    <section class="login-header">
                        <div class="container">
                            <div class="row">
                                <h1>THIS IS IT</h1>
                                <h2>You're moment's away from shopping the season's hottest handbag styles</h2>
                            </div>
                        </div>
                    </section>
                    <section class="login-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <FormRegister onInit={ this.formInit } onKeyPress={this.keyPress} />
                                    <div class="loggin-continue-btn">
                                        <div class="login-checkout-button">
                                            <button onClick={ this.registerUser }>COMPLETE</button>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 login-privacy-terms">
                                        <a class="check-link-terms" href="#" data-toggle="modal" data-target="#privacyModal">Terms of Service</a> &amp; <a class="check-link-terms" href="#" data-toggle="modal" data-target="#termsModal">Privacy Policy</a>.
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <img src="https://www.thepurseclub.com/wp-content/uploads/2018/02/verisign.jpg" alt="" class="verisign" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 login-img-container login-privacy-terms">
                                    <img src="https://www.thepurseclub.com/wp-content/uploads/2018/02/new-vip-membership.jpg" alt="" />
                                </div>
                            </div>
                        </div>
                    </section>
                    <Loader loading={ this.state.loading } id="register-loading" />
                </div>
            </div>
        )
    }
}
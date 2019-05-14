import React, { Component } from 'react';
import './index.css';

import FormComponent from './../../common/form/';
import { TextField, PasswordField, EmailField } from './../../common/form/fields';
import { TPCLoginPasswordValidator } from './validators';
import { TPCEmailValidator } from './../checkout/validators';


export default class FormRegiter extends FormComponent(Component) {

    constructor(props) {
        super(props);

        this.state = {
            'name': new TextField('name', { required: true, label: 'FIRST NAME:', placeholder: 'First Name' }),
            'email': new EmailField('email', {
                required: true, label: 'EMAIL:',
                placeholder: 'Email', validators: [TPCEmailValidator]
            }),
            'password': new PasswordField('password', {
                required: true, label: 'PASSWORD: (6 CHARACTERS MINIMUM)',
                placeholder: 'Password', validators: [TPCLoginPasswordValidator]
            }),
        }

        this.wrapField = this.wrapField.bind(this);
    }

    wrapField(field, renderedField) {
        return (
            <div class="login-info-data">
                <label>{(field.required ? '*' : '') + field.getLabel()}</label>
                <div class={'login-input '.concat(Boolean(field.error) ? 'has-error' : '')}>
                    { renderedField }
                </div>
            </div>
        );
    }

    render() {
        return (
            <div>
                <form class="login-data" autocomplete="off" onKeyPress={(event) => { this.props.onKeyPress && this.props.onKeyPress(event)} }>
                    {Object.keys(this.state).map(key => {
                        return this.wrapField(this.state[key], this.generateField(key));
                    })}
                </form>
            </div>
        );
    }

}
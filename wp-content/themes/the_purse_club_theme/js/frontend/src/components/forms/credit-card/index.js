import React, { Component } from 'react';

import FormComponent from './../../common/form';
import { TextField, SelectField, NumberField } from './../../common/form/fields';
import { TPCCCNumberValidator, TPCCVVValidator, TPCCCExpiresValirator } from './validators';


export default class FormCreditCard extends FormComponent(Component) {

    constructor(props) {
        super(props);

        // this.prefix = prefix = props.paymentData ? `${props.paymentData.payment_method}-card-`: 'card-';
        this.state = {
            'card-type': new SelectField('card-type', {
                required: true, fetch: this.fetchTypes.bind(this),
                onChange: this.typeOnChange.bind(this),
                placeholder: 'Type', label: 'Card Type'
            }),
            'card-number': new TextField('card-number', {
                required: true, validators: [TPCCCNumberValidator],
                placeholder: 'XXXX XXXX XXXX XXXX', label: 'Credit Card Number'
            }),
            'card-expiry': new TextField('card-expiry', {
                required: true, validators: [TPCCCExpiresValirator],
                placeholder: 'MM / YY', label: 'Expiry Date'
            }),
            'card-cvc': new NumberField('card-cvc', {
                required: true, validators: [TPCCVVValidator],
                placeholder: 'XXX', label: 'CVV'
            })
        }

        this.wrapField = this.wrapField.bind(this);
    }

    typeOnChange() {
        this.validate(this.state['card-number']);
    }

    fetchTypes() {
        let options = [
            {value: '', text: 'Choose an option'},
            {value: 'visa', text: 'Visa'},
            {value: 'discover', text: 'Discover'},
            {value: 'amex', text: 'AMEX'},
            {value: 'master', text: 'Master Card'},
        ];
        this.setState({
            'card-type': Object.assign(this.state['card-type'], {
                options
            })
        })
    }

    wrapField(field, renderField) {
        if (field._isField) {
            return (
                <div class="cc-card-mini-box clearfix">
                    <label>{(field.required ? '*' : '') + field.getLabel()}</label>
                    <div class={'cc-card-form '.concat(Boolean(field.error) ? 'has-error' : '')}>
                        {renderField}
                    </div>
                </div>
            );
        }
        return null;
    }

    render() {
        return (
            <div>
                <form class="cc-form-content">
                    {Object.keys(this.state).map((key) => {
                        return this.wrapField(this.state[key], this.generateField(key));
                    })}
                </form>
            </div>
        );
    }
}
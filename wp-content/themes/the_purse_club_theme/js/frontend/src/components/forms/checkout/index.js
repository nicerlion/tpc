import React, { Component } from 'react';
import './index.css';
import './media.css';

import FormComponent from './../../common/form/';
import { TPCEmailValidator, TPCPostCodeValidator, TPCTelephoneValidator } from './validators';
import { TextField, SelectField, EmailField, PasswordField, NumberField } from './../../common/form/fields';


export default class FormCheckout extends FormComponent(Component) {

    constructor(props) {
        super(props);

        let formatType = this.formatType = props.type.toLowerCase();

        this.state = {
            [`${formatType}_first_name`]: new TextField('first_name', {
                prefix: formatType, required: true
            }),
            [`${formatType}_last_name`]: new TextField('last_name', {
                prefix: formatType, required: true
            }),
            [`${formatType}_address_1`]: new TextField('address_1', {
                prefix: formatType, required: true
            }),
            [`${formatType}_address_2`]: new TextField('address_2', {
                prefix: formatType, placeholder: 'Apartment/Suite/Unit/etc.'
            }),
            [`${formatType}_country`]: new SelectField('country', {
                prefix: formatType, required: true,
                fetch: this.fetchCountries.bind(this),
                onChange: this.onChangeCountry.bind(this),
                value: 'US'
            }),
            [`${formatType}_city`]: new TextField('city', {
                prefix: formatType, required: true
            }),
            [`${formatType}_state`]: new SelectField('state', {
                prefix: formatType, required: true,
                fetch: this.fetchStates.bind(this)
            }),
            [`${formatType}_postcode`]: new NumberField('postcode', {
                prefix: formatType, required: true,
                validators: [TPCPostCodeValidator], label: 'Zip Code',
                placeholder: 'XXXXX'
            }),
            [`${formatType}_phone`]: new TextField('phone', {
                prefix: formatType, required: true,
                validators: [TPCTelephoneValidator],
                placeholder: '(XXX) XXX-XXXX'
            })
            // [`${formatType}_password`]: new PasswordField('password', {
            //     prefix: formatType, required: true, helpText: 'Create a password for your account'
            // })
            // [`${formatType}_email`]: new EmailField('email', {
            //     prefix: formatType, validators: [TPCEmailValidator],
            //     required: true
            // }),
        }

        if (props.edit) {
            // this.state = Object.assign(this.state, {
            //     [`${formatType}_email`]: {}
            // });
        }
        if (formatType === 'shipping') {
            this.state = Object.assign(this.state, {
                // [`${formatType}_email`]: {},
                // [`${formatType}_password`]: {},
                [`${formatType}_phone`]: {}
            });
        }

        this.wrapField = this.wrapField.bind(this);
    }

    componentDidMount() {
        super.componentDidMount();
        // this.formatType === 'billing' && this.api.getUser().then(data => {
        //     this.setState({
        //         user: data
        //     });
        //     if (data) {
        //         this.setState({
        //             [`${this.formatType}_password`]: {},
        //         });
        //     }
        // });

        if (this.props.userData) {
            for (let field in this.props.userData) {
                let fieldName = `${this.formatType}_${field}`;
                if (fieldName in this.state && !this.state[fieldName].value) {
                    this.setState({
                        [fieldName]: Object.assign(this.state[fieldName], {
                            value: this.props.userData[field]
                        })
                    });
                    this.state[fieldName].onChange && this.state[fieldName].onChange(
                        this.state[fieldName].value, this.state[fieldName]
                    );
                }
            }
        }

    }

    componentDidUpdate(prevProps) {
        if(this.props.userData != prevProps.userData) {
            for (let field in this.props.userData) {
                let fieldName = `${this.formatType}_${field}`;
                if (fieldName in this.state && !this.state[fieldName].value) {
                    this.setState({
                        [fieldName]: Object.assign(this.state[fieldName], {
                            value: this.props.userData[field]
                        })
                    });
                    this.state[fieldName].onChange && this.state[fieldName].onChange(
                        this.state[fieldName].value, this.state[fieldName]
                    );
                }
            }
        }
    }

    fetchCountries() {
        let countries = this.api.getCountries();
        this.setState({
            [`${this.formatType}_country`]: Object.assign(this.state[`${this.formatType}_country`], {
                options: countries
            })
        });
    }

    fetchStates() {
        let countryCode = this.state[`${this.formatType}_country`].value;
        if (countryCode) {
            this.api.getStates(countryCode).then((states) => {
                this.setState({
                    [`${this.formatType}_state`]: Object.assign(this.state[`${this.formatType}_state`], {
                        options: states
                    })
                })
            });
        } else {
            let selectObject = new SelectField('', {});
            this.setState({
                [`${this.formatType}_state`]: Object.assign(this.state[`${this.formatType}_state`], {
                    options: selectObject.options
                })
            })
        }
    }

    onChangeCountry(value) {
        this.fetchStates();
        let postCodeField = this.state[`${this.formatType}_postcode`];
        this.setState({
            [`${this.formatType}_postcode`]: Object.assign(postCodeField, {
                type: value === 'US' ? 'number': 'text'
            })
        });
        (postCodeField.onChange && postCodeField.value) && postCodeField.onChange(
            postCodeField.value, postCodeField
        );
        postCodeField.value && this.validate(postCodeField);
    }

    wrapField(field, renderField) {
        if (field._isField) {
            return (
                <div class="sab-info-data">
                    <label>{(field.required ? '*': '') + field.getLabel()}</label>
                    <div class={'sab-input '.concat(Boolean(field.error) ? 'has-error' : '')}>
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
                <form class="sab-data" autocomplete="off">
                    {Object.keys(this.state).map((key) => {
                        return this.wrapField(this.state[key], this.generateField(key));
                    })}
                </form>
            </div>
        );
    }
}
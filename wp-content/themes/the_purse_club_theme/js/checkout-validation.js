/**
 * Vue Validation of Checkout Page
 * 
 * v1.0
 */

(function () {
    'use strict';
    const $ = jQuery;
    // let errors = {};
    new Vue({
        el: 'form',
        delimiters: ['{{', '}}'],
        data: {
            fields: {
                'billing': {
                    'first_name': '',
                    'last_name': '',
                    'company': '',
                    'address_1': '',
                    'address_2': '',
                    'city': '',
                    'postcode': '',
                    'country': '',
                    'state': '',
                    'email': '',
                    'phone': ''
                },
                'shipping': {
                    'first_name': '',
                    'last_name': '',
                    'company': '',
                    'address_1': '',
                    'address_2': '',
                    'city': '',
                    'postcode': '',
                    'country': '',
                    'state': ''
                },
                'account': {
                    'username': '',
                    'password': '',
                    'password-2': ''
                },
                'limelight-': {
                    'card-number': '',
                    'card-expiry': '',
                    'card-cvc': '',
                    'card-type': ''
                }
            },
            errors: {}
        },
        watch: {},
        computed: {},
        mounted: function () {
            // this.flushLocalStorage();
            setTimeout(this.initFields, 1000);
        },
        methods: {
            initFields: function (bases = undefined) {
                let fields = bases || this.getFields();
                for (let base in fields) {
                    for (let field of fields[base]) {
                        // let verbose = base.concat('_') + field;
                        let verbose = this.getVerboseName(base, field);
                        // let self = this;

                        let value = window.localStorage.getItem(verbose) || $(`#${verbose}`).val() || '';
                        $(`#${verbose}`).live('change.tpc keyup.tpc', this.getFunctionHandler(verbose, base)).val(value);

                        if ($(`#${verbose}`).prop('tagName') == 'SELECT') {
                            try {
                                $(`#${verbose}`).selectWoo();
                            } catch (error) {

                            }
                        }
                        $(`#${verbose}`).trigger('keyup');
                        $(`#${verbose}`).trigger('change');
                    }
                }

                let self = this;
                $('form[name="checkout"]').on('change keyup', function (event) {
                    let errors = self.hasErrors();

                    if ($('#terms').is(':checked')) {
                        if (errors) {
                            $(this).find('#place_order').attr('disabled', true);
                            $('.upsell-submit').removeAttr('href');
                            $('.upsell-submit').removeAttr('data-toggle');
                            $('#validation-box-submit').removeAttr('href');
                        } else {
                            $(this).find('#place_order').attr('disabled', false);
                            $('.upsell-submit').attr('href', '');
                            $('.upsell-submit').attr('data-toggle', 'modal');
                            $('#validation-box-submit').attr('href', '');
                        }
                    } else {
                        $(this).find('#place_order').attr('disabled', true);
                        $('.upsell-submit').removeAttr('href');
                        $('.upsell-submit').removeAttr('data-toggle');
                        $('#validation-box-submit').removeAttr('href');
                    }
                });

                $('.upsell-submit, #validation-box-submit').live('click', function ($event) {
                    if (!$(this)[0].hasAttribute('href')) {
                        let fieldError = self.getFirstError();
                        let uri = window.location.href.split('#')[0];
                        window.location.href = `${uri}#${fieldError}`;
                    }
                });

                $('#ship-to-different-address-checkbox').live('change', function (event) {
                    for (let base in fields) {
                        for (let field of fields[base]) {
                            let verbose = self.getVerboseName(base, field);
                            $(`#${verbose}`).trigger('change');
                        }
                    }
                });
            },
            getFields: function () {
                return {
                    'billing': [
                        'first_name', 'last_name', 'company', 'address_1', 'address_2', 'city',
                        'postcode', 'country', 'state', 'email', 'phone'
                    ],
                    'shipping': [
                        'first_name', 'last_name', 'company', 'address_1', 'address_2', 'city',
                        'postcode', 'country', 'state'
                    ],
                    'account': [
                        'username', 'password', 'password-2'
                    ],
                    'limelight-': [
                        'card-number', 'card-expiry', 'card-type', 'card-cvc'
                    ]
                }
            },
            addError: function ($$, evaluated) {
                let parent = $$.parent();
                let verbose = $$.selector.replace('#', '').replace('.', '');

                if  (!verbose) {
                    verbose = $$[0].id.replace('#', '').replace('.', '');
                }

                let requiredError = (this.isRequired($$) && !Boolean($$.val().trim().length));
                let customError = typeof evaluated == 'string' ? true: !evaluated;
                let error = !requiredError ? customError : true;

                if (!$('#ship-to-different-address-checkbox').is(':checked')) {
                    if (verbose.startsWith('shipping') && requiredError) {
                        error = false;
                    }
                }

                this.errors[verbose] = error;

                if (error) {
                    if (!parent.hasClass('woocommerce-invalid')) {
                        parent.addClass('woocommerce-invalid');
                    }
                    let message = typeof evaluated == 'string' ? evaluated : 'Required value';
                    if (!parent.find(`#${verbose}-alert`)[0]) {
                        parent.append(`<div id="${verbose}-alert" class="alert billing-validation-alert"><p>${message}</p><div>`);
                    } else {
                        parent.find(`#${verbose}-alert`).detach();
                        parent.append(`<div id="${verbose}-alert" class="alert billing-validation-alert"><p>${message}</p><div>`);
                    }
                } else {
                    if (parent.hasClass('woocommerce-invalid')) {
                        parent.removeClass('woocommerce-invalid');
                    }
                    parent.find(`#${verbose}-alert`).detach();
                }
            },
            getFunctionHandler: function (verbose, base) {
                let self = this;
                return function (event) {
                    let parent = $(this).parent();

                    // FALSE: Not errors
                    // TRUE: Errors
                    let evaluated = `validate_${verbose}` in self ? self[`validate_${verbose}`]($(this), event) : true;

                    if (['boolean', 'string'].indexOf(typeof evaluated) + 1) {
                        self.addError($(this), evaluated);
                    }
                    if ($(this).val() || $(this).val() == '') {
                        if (!verbose.startsWith('limelight') && !verbose.endsWith('password')) {  // avoid save data of credit card and passwords
                            window.localStorage.setItem(verbose, $(this).val());
                        }
                    }
                }
            },
            isRequired: function ($$) {
                return Boolean($$.siblings().find('.required').length);
            },
            validate_billing_postcode: function ($$) {
                let condition = false;
                let message = 'Available for US and Canada';

                if ($('#billing_country').val() == 'US') {
                    condition = $$.val().toString().length == 5;
                    message = 'Type 5 digits';
                } else if ($('#billing_country').val() == 'CA') {
                    condition = $$.val().toString().length >= 3 && $$.val().toString().length <= 5;
                    message = 'At least 3 digits';
                }
                return condition ? true : message;
            },
            validate_shipping_postcode: function ($$) {
                let condition = false;
                let message = 'Available for US and Canada';

                if ($('#shipping_country').val() == 'US') {
                    condition = $$.val().toString().length == 5;
                    message = 'Type 5 digits';
                } else if ($('#shipping_country').val() == 'CA') {
                    condition = $$.val().toString().length >= 3 && $$.val().toString().length <= 5;
                    message = 'At least 3 digits';
                }
                return condition ? true : message;
            },
            validate_email: function ($$, event) {
                let regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

                if (!regex.test($$.val().toString())) {
                    return 'Wrong email format';
                }

                if (event.type == 'change') {
                    let url = window.location.href.replace('billing-information/', '').split('#')[0];
                    let promise = $.ajax({
                        url: `${url}wp-json/myplugin/v1/user/email`,
                        data: {
                            email: $$.val()
                        },
                        method: 'GET',
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
                        },
                        success: (response) => {
                            let result = response.exists ? 'Email exists. <a href="/my-account/">Login</a>' : true;
                            this.addError($$, result);
                        },
                        error: (response) => {
                            this.addError($$, true);
                        }
                    });
                    return promise
                }
                return true;
            },
            validate_billing_email: function ($$, event) {
                return this.validate_email($$, event);
            },
            validate_shipping_email: function ($$, event) {
                return this.validate_email($$, event);
            },
            validate_billing_country: function ($$, event) {
                $('#billing_postcode').trigger('change');
                $('#billing_postcode').trigger('keyup');
                return true;
            },
            validate_shipping_country: function ($$, event) {
                $('#shipping_postcode').trigger('change');
                $('#shipping_postcode').trigger('keyup');
                return true;
            },
            'validate_limelight-card-number': function ($$) {
                if (!window.debug) {
                    let type = $('#limelight-card-type').val();
                    let message = false;
                    let regex = '';
    
                    if (type == 'amex') {
                        regex = /^(?:3[47][0-9]{13})$/;
                    } else if (type == 'visa') {
                        regex = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
                    } else if (type == 'master') {
                        regex = /^(?:5[1-5][0-9]{14})$/;
                    } else if (type == 'discover') {
                        regex = /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/;
                    } else {
                        message = 'There\'s not support for this card type';
                    }
    
                    if (!message) {
                        let value = $$.val().toString().trim().split(' ').join('');
                        if (!regex.test(value)) {
                            message = 'Invalid card number';
                        } else {
                            return true;
                        }
                    }
                    return message;
                } else {
                    return true;
                }
            },
            'validate_limelight-card-type': function ($$) {
                $('#limelight-card-number').trigger('change');
                $('#limelight-card-number').trigger('keyup');
                return true;
            },
            'validate_limelight-card-cvc': function ($$) {
                if ($$.val()) {
                    return $$.val().toString().length >= 3 && $$.val().toString().length <= 4 ? true: 'Invalid CVC';
                }
                return true;
            },
            'validate_limelight-card-expiry': function ($$) {
                if ($$.val()) {
                    return $$.val().toString().length == 4 + 3 ? true: 'Invalid Format';
                }
                return true;
            },
            hasErrors: function() {
                let errors = this.errors;
                let array = Object.keys(errors).map(function (key) { return errors[key]; });
                return array.reduce(function (a, b) { return a || b });;
            },
            flushLocalStorage: function () {
                let fields = this.getFields();
                for (let base in fields) {
                    for (let field of fields[base]) {
                        window.localStorage.removeItem(`${base}_${field}`);
                    }
                }
            },
            getVerboseName: function (base, field) {
                return base.endsWith('-') ? base.concat(field): `${base}_${field}`;
            },
            getFirstError: function () {
                let errors = this.errors;
                let first = undefined;
                for (let field in errors) {
                    if (errors[field]) {
                        first = field;
                        break
                    }
                }
                return first;
            }
        }
    });
})();

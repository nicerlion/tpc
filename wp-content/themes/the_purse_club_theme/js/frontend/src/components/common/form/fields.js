const React = require('react');
const validators = require('./validators');  // avoid import


class Field {
    
    static default_validators = [];

    constructor (name, options) {
        this.name = name;
        this._isField = true;
        this.value = '';
        this.prefix = '';
        this.validators = [];
        this.placeholder = '';
        this.label = '';
        this.helpText = '';
        this.required = false;

        this.type = {};
        this.onChange = undefined;
        this.fetch = undefined;
        this.options = false;
        this.error = false;

        for (let option in options) {
            this[option] = options[option];
        }

        this.name = Boolean(this.prefix) ? `${this.prefix}_${this.name}`: this.name;
        if (this.type === 'select') {
            this.options = [{value: '', text: 'Choose an option'}];
        }

        this.setValidators.bind(this)();
        this.getPlaceholder = this.getPlaceholder.bind(this);
    }

    setValidators() {
        this.validators = [...this.constructor.default_validators, ...this.validators];

        if (this.required) {
            this.validators = [validators.RequiredValidator, ...this.validators];
        }
    }

    getPlaceholder() {
        if (this.placeholder) {
            return this.placeholder;
        }
        return this.name.replace(this.prefix, '')
            .replace(/_/g, ' ')
            .replace(/\-/g, '')
            .replace(/\w\S*/g, function (txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
    }

    getLabel() {
        if (this.label) {
            return this.label;
        }
        return this.name.replace(this.prefix, '')
            .replace(/_/g, ' ')
            .replace(/\-/g, '')
            .replace(/\w\S*/g, function (txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
    }

    getHelpText() {
        return this.helpText && (
            <div class="help help-block">
                <span>{this.helpText}</span>
            </div>
        );
    }

}


class TextField extends Field {

    constructor (name, options = {}) {
        options = Object.assign(options, {type: 'text'});
        super(name, options);
    }

}


class SelectField extends Field {

    constructor(name, options = {}) {
        options = Object.assign(options, { type: 'select' });
        super(name, options);
    }

}


class EmailField extends Field {

    static default_validators = [validators.EmailValidator];

    constructor(name, options = {}) {
        options = Object.assign(options, {type: 'email'});
        super(name, options);
    }

}


class PasswordField extends Field {

    constructor(name, options = {}) {
        options = Object.assign(options, {type: 'password'});
        super(name, options);
    }

}


class NumberField extends Field {

    constructor(name, options = {}) {
        options = Object.assign(options, {type: 'number'});
        super(name, options);
    }

}

module.exports = {
    TextField,
    SelectField,
    EmailField,
    PasswordField,
    NumberField
}

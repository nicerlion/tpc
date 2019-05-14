const React = require('react');
const Validator = require('./../../common/form/validators').Validator;  // avoid imports
const ServiceApi = require('./../../../api/service').default;


class TPCEmailValidator extends Validator {

    static code = 'tpc-email';

    validate () {
        let api = new ServiceApi();
        return api.getEmailRegistered(this.value).then(data => {
            return data.exists ? (<div>Email exists <a href="/my-account/">Login</a></div>): true;
        });
    }
}


class TPCTelephoneValidator extends Validator {
    
    static code = 'tpc-telephone';

    check() {
        let baseValue = '(xxx) xxx-xxxx';
        let value = this.value.replace(/\(?\)?\s?\-?/g, '').substring(0, 15);

        for (let i = 0; i < value.length; i++) {
            baseValue = baseValue.replace('x', value[i]);
        }

        let index = baseValue.indexOf('x');
        let newValue = baseValue.substring(0, index + 1 ? index: baseValue.length);

        this.child.setState(
            {
                [`${this.child.formatType}_phone`]: Object.assign(this.state[`${this.child.formatType}_phone`], {
                    value: newValue
                })
            }
        )
        this.value = newValue;
    }

    validate() {
        this.check();
        let regex = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/

        if (!regex.test(this.value)) {
            return 'Wrong telephone number';
        }
        return true;
    }
}


class TPCPostCodeValidator extends Validator {

    static code = 'tpc-postcode';

    check() {
        let value = this.value.substring(0, 5);
        this.child.setState(
            {
                [`${this.child.formatType}_postcode`]: Object.assign(this.state[`${this.child.formatType}_postcode`], {
                    value
                })
            }
        );
        this.value = value;
    }

    validate () {
        this.check();
        let condition = false;
        let message = 'Available for US and Canada';
        let country = this.state[`${this.child.formatType}_country`].value;

        if (country === 'US') {
            condition = this.value.toString().length === 5;
            message = 'Type 5 digits';
        } else if (country === 'CA') {
            condition = this.value.toString().length >= 3 && this.value.toString().length <= 5;
            message = 'At least 3 digits';
        }
        return condition ? true: message;
    }

}

module.exports = {
    TPCEmailValidator,
    TPCPostCodeValidator,
    TPCTelephoneValidator
}

// const React = require('react');
const Validator = require('./../../common/form/validators').Validator;  // avoid imports


class TPCCCNumberValidator extends Validator {

    static code = 'tpc-cc-validator';

    check() {
        const INCREMENT = 4;
        let value = this.value.split(' ').join('').substring(0, 16);  // .toString().substring(0, 16);
        if (!(/^[0-9]*$/.test(value))) {  // .replace(/\s+/g, '')
            value = value.substring(0, value.length - 1);
        }

        for (let i = 0; i < value.length; i++) {
            if (!(i % (INCREMENT + 1))) {
                value = value.substring(0, i) + ' ' + value.substring(i);
            }
        }
        value = value.substring(1);
        this.child.setState(
            {
                'card-number': Object.assign(this.state['card-number'], {
                    value: value
                })
            }
        );
        this.value = value;
    }

    validate() {
        const TYPES = {
            amex: /^(?:3[47][0-9]{13})$/,
            visa: /^(?:4[0-9]{12}(?:[0-9]{3})?)$/,
            master: /^(?:5[1-5][0-9]{14})$/,
            discover: /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/
        }
        if (!window._debug) {
            let type = this.state['card-type'].value;
    
            let regex = TYPES[type];
            this.check();
    
            if (!regex) {
                return 'There\'s not support for this card type';
            } else if (!regex.test(this.value.replace(/\s+/g, ''))) {
                return 'Invalid card number';
            }
        }
        return true;
    }

}


class TPCCCExpiresValirator extends Validator {

    static code = 'tpc-cc-expires-validator';

    check() {
        let value = this.value.split('/').join('').substring(0, 4);  // .toString().substring(0, 16);
        if (!(/^[0-9]*$/.test(value))) {  // .replace(/\s+?\/\s+/g, '')
            value = value.substring(0, value.length - 1);
        }
        for (let i = 0; i < value.length; i++) {
            if (!(i % (2 + 1))) {
                value = value.substring(0, i) + '/' + value.substring(i);
            }
        }
        value = value.substring(1);
        this.child.setState(
            {
                'card-expiry': Object.assign(this.state['card-expiry'], {
                    value: value
                })
            }
        );
        this.value = value;
        // if (!(/^[0-9]*$/.test(this.value.replace(/\s+/g, '')))) {

        // }
    }

    validate() {
        this.check();
        return true;
    }
}


class TPCCVVValidator extends Validator {

    static code = 'tpc-cc-cvv-validator';

    check() {
        this.child.setState(
            {
                'card-cvc': Object.assign(this.state['card-cvc'], {
                    value: this.value.toString().substring(0, 4)
                })
            }
        );
        this.value = this.state['card-cvc'].value;
    }

    validate() {
        this.check();
        if (this.value.trim()) {
            return this.value.toString().length >= 3 && this.value.toString().length <= 4 ? true : 'Invalid CVC';
        }
        return true;
    }
}

module.exports = {
    TPCCCNumberValidator,
    TPCCVVValidator,
    TPCCCExpiresValirator
}

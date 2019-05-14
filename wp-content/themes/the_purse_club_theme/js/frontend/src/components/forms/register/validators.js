// const React = require('react');
const Validator = require('./../../common/form/validators').Validator;  // avoid imports


class TPCLoginPasswordValidator extends Validator {

    static code = 'tpc-register-password-validator';

    validate() {
        return this.value.length >= 6 ? true: '6 Character Minimun';
    }

}


module.exports = {
    TPCLoginPasswordValidator
}

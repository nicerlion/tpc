
class Validator {

    static code = 'validator';

    constructor(string, state, child) {
        this.value = string;
        this.state = state;
        this.child = child;
    }

    /**
     * Validate the value
     * 
     * @returns true if not errors, else, false or string with error message.
     */
    validate() {
        throw new Error('Validator class may be used as class parent, not directly');
    }

}


class RequiredValidator extends Validator {

    static code = 'required';

    validate() {
        return Boolean(this.value.toString().trim()) ? true : 'Field is required';
    }

}


class EmailValidator extends Validator {

    static code = 'email';

    validate() {
        let regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

        if (!regex.test(this.value)) {
            return 'Wrong email format';
        }
        return true;
    }

}

module.exports = {
    Validator,
    RequiredValidator,
    EmailValidator
}

import React from 'react';
import ServiceApi from './../../../api/service';
import TPCStorage from './../storage';

export default (SuperClass) => class extends SuperClass {  // TODO: correction confusions between name field and name in state

    constructor(props) {
        super(props);
        this.allowUseLocalStorage = this.props.useStorage;

        this.validateAll = this.validateAll.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this);
        this.validate = this.validate.bind(this);
        this.flushLocalStorage = this.flushLocalStorage.bind(this);
        this.getData = this.getData.bind(this);

        this.props.onInit && this.props.onInit(this);
        this.storage = new TPCStorage();
    }

    componentDidMount() {
        this.api = this.props.httpClient || new ServiceApi();

        for (let field in this.state) {
            if (this.allowUseLocalStorage) {
                this.setState({
                    [field]: Object.assign(this.state[field], {
                        value: this.storage.getItem(field) || ''
                    })
                });
                this.state[field].value.trim() && this.validate(this.state[field]);
            }
            this.state[field].fetch && this.state[field].fetch();
        }
    }

    componentWillUnmount() {
        this.props.onDeteach && this.props.onDeteach(this);
        // if (this.allowUseLocalStorage) {
        //     this.flushLocalStorage()
        // }
    }

    getData() {
        return Object.keys(this.state).filter(elem => {
            return this.state[elem]._isField;
        }).map(elem => {
            return this.state[elem];
        });
    }

    makeFormPromise(promise) {
        let isPending = true, isRejected = false, isFulfilled = false;

        var result = promise.then(
            function(result) {
                isFulfilled = true;
                isPending = false;
                return result;
            }, function(error) {
                isRejected = true;
                isPending = false;
                return error;
            }
        );

        result.isFulfilled = function() { return isFulfilled; };
        result.isPending = function() { return isPending; };
        result.isRejected = function() { return isRejected; };
        return result;
    }

    validateAll() {
        let hasError = false;
        let __promises = [];

        let formPromise = new Promise((resolve, reject) => {
            for (let field in this.state) {
                let validation = this.validate(this.state[field]);

                if (validation) {
                    __promises.push(
                        validation.then(valid => {
                            if (!hasError) {
                                hasError = Boolean(this.state[field].error);
                            }
                            return hasError;
                        })
                    );
                } else {
                    hasError = Boolean(this.state[field].error);
                }
                if (hasError) break;
            }

            Promise.all(__promises).then((results) => {
                resolve({ error: hasError, type: this.props.type });  // TODO: removes type property, is not form property
            });
        });

        return this.makeFormPromise.bind(this)(formPromise);
    }

    handleInputChange(event) {
        const target = event.target;

        this.setState({
            [target.name]: Object.assign(this.state[target.name], {
                value: target.type === 'checkbox' ? target.checked : target.value
            })
        })
        this.validate(this.state[target.name]);

        if (this.allowUseLocalStorage) {
            if (this.state[target.name].value) {
                this.storage.setItem(target.name, this.state[target.name].value.trim());
            } else {
                this.storage.removeItem(target.name);
            }
        }

        this.state[target.name].onChange && this.state[target.name].onChange(this.state[target.name].value, this.state[target.name]);
    }

    _internal_validation(validation, field) {
        let hasError = typeof validation === 'boolean' ? !validation : validation;
        let blockError = null;

        if (hasError) {
            if (validation['$$typeof']) {  // react object html (jsx)
                blockError = validation;
            } else {
                blockError = (
                    <div>
                        <span>{typeof validation === 'string' ? validation : 'This field has error'}</span>
                    </div>
                );
            }
        } else {
            blockError = null;
        }

        this.setState({
            [field.name]: Object.assign(this.state[field.name], {
                error: blockError
            })
        });
        return hasError;
    }

    validate(field) {  // TODO, make reactive values to validator and instanciate it once time
        if (field.validators) {
            for (let Validator of field.validators) {
                let validation = new Validator(field.value, this.state, this).validate();
                if (['boolean', 'string'].indexOf(typeof validation) + 1) {
                    let hasError = this._internal_validation.bind(this)(validation, field);
                    if (hasError) break;
                } else {
                    return validation.then((valid) => {
                        return this._internal_validation.bind(this)(valid, field);
                    });
                }
            }
        }
    }

    generateField(name) {  // TODO: add support for checkboxes and radioButtons
        if (this.state[name]._isField) {
            let field = this.state[name];
            if (field.type === 'select') {
                return (
                    <div>
                        <select name={field.name}
                            value={field.value}
                            onChange={this.handleInputChange}>
                            {field.options.map((key, i) => {
                                return <option key={i} value={key.value} selected={field.value === key.value}>{key.text}</option>
                            })}
                        </select>
                        {field.getHelpText()}
                        {field.error}
                    </div>
                )
            } else {
                return (
                    <div>
                        <input name={field.name}
                            type={field.type}
                            value={field.value}
                            onChange={this.handleInputChange}
                            autocomplete={`new-password`}
                            placeholder={field.getPlaceholder()} />
                        {field.getHelpText()}
                        {field.error}
                    </div>
                )
            }
        }
    }

    flushLocalStorage() {
        for (let field in this.state) {
            this.storage.removeItem(field);
        }
    }
}

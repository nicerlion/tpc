import React, { Component } from 'react';

/**
 * Function to combine props to an component
 * @param {Component} WrappedComponent Component to be wrapped to
 * @param {Object} defaultProps props given by parent
 */
export function addDefaultProps(WrappedComponent, defaultProps) {

    defaultProps = Object.assign({ /* Put here globals */ }, defaultProps);

    class Wrapper extends Component {
        render() {
            let props = Object.assign({}, this.props, defaultProps);
            return <WrappedComponent {...props} />
        }
    }

    return Wrapper;
}


/**
 * Function to combine Objects if has values
 * @param {Object} origin Object origin to coping to
 */
export function copySafe(origin) {

    for (let argument of arguments) {
        Object.keys(argument).forEach(key => {
            if (argument[key]) origin[key] = argument[key];
        });
    }
    return origin;
}

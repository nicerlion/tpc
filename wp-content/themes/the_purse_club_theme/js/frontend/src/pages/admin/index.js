import React, { Component } from 'react';
import {
    Redirect, Route, Link,
} from 'react-router-dom';

import { addDefaultProps } from './../../utils/functions';
import ServiceApi from './../../api/service';
import Dashboard from './dashboard/';
import Store from './store/';
import ThankYou from './thank-you/';


class Admin extends Component {

    constructor(props) {
        super(props);
        this.state = {};
    }

    componentDidMount() {
        let api = new ServiceApi();
        (async () => {
            /**
             * This function verify if body has class logged-in.
             * `logged-in` class, is a class which wordpress offer to
             * know if user is logged or not.
             */
            if (!Boolean([...document.body.classList.values()].indexOf('logged-in') + 1)) {
                await api.getUser().then(data => {
                    this.setState({ user: data ? data: {} });
                }).catch(data => {
                    this.setState({ user: {} });
                });
            } else {
                this.setState({ user: {id: 1} });
            }
        })();
    }

    render() {
        if (this.state.user && this.state.user.id) {
            return (
                <div>
                    <Route path={`${this.props.match.url}/dashboard`} component={addDefaultProps(Dashboard, this.props)} />
                    <Route path={`${this.props.match.url}/pick-your-bag`} component={addDefaultProps(Store, this.props)} />
                    <Route path={`${this.props.match.url}/thank-you`} component={addDefaultProps(ThankYou, this.props)} />
                </div>
            );
        } else if (this.state.user) {
            window.location.href = '/my-account';
            return <Redirect to={{ pathname: '/' }} replace />
        }
        return null;
    }
}

export default Admin;

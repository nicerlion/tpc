import React, { Component } from 'react';
import './App.css';
import {
    HashRouter as Router,
    Route
} from 'react-router-dom';

// Components
import ScrollToTop from './components/common/scroll-router/';

// Functional
import { addDefaultProps as _addDefaultProps } from './utils/functions';

// Pages
import BillingShipping from './pages/billing-shipping/';
import CreditCard from './pages/credit-card/';
import Membership from './pages/membership/';
import Receipt from './pages/receipt/';
import Upsells from './pages/upsells/';
import Admin from './pages/admin/';
import Product from './pages/product/';
import Register from './pages/register/';
import Shop from './pages/shop/';
import ProductDetails from './pages/product-details/';
import OrderSummary from './pages/order-summary/';


class App extends Component {
    
    constructor() {
        super();

        this.state = {};
        this.defaultProps = {
            MEMBERSHIP_KEY: 'membership',
            UPSELL_KEY: 'upsells',
            ORDER_KEY: 'order',
            COUPON_KEY: 'coupon',
            UPSELLS_OPENED_KEY: '_upsellsOpened',
            PIXEL_ID_1: '559415867727666',
            PIXEL_ID_2: '333244033862295',
            TIMER_KEY: '_timerCountDown',
            CART_KEY: '_cartKey',
            redirectIfUserIsNotLogged: this.redirectIfUserIsNotLogged,
            getSignUpDiscount: this.getSignUpDiscount
        }

        this.addDefaultProps = this.addDefaultProps.bind(this);
    }

    /**
     * This function verify if body has class logged-in.
     * `logged-in` class, is a class which wordpress offer to
     * know if user is logged or not.
     */
    redirectIfUserIsNotLogged(redirect=true) {
        if (!Boolean([...document.body.classList.values()].indexOf('logged-in') + 1)) {
            if (redirect) {
                window.location.href = '/my-account';
            }
            return true;
        }
        return false;
    }

    getSignUpDiscount() {
        return !window.wpReactSettings.isMember;
    }

    addDefaultProps(WrappedComponent) {
        let props = Object.assign({}, this.props, this.defaultProps);
        return _addDefaultProps(WrappedComponent, props);
    }

    render() {
        return (
            <Router>
                <ScrollToTop {...this.defaultProps}>
                    <Route exact path="/billing/" component={ this.addDefaultProps(BillingShipping) } />
                    <Route exact path="/checkout/" component={ this.addDefaultProps(CreditCard) } />
                    <Route exact path="/membership/" component={ this.addDefaultProps(Membership) } />
                    <Route exact path="/receipt/" component={ this.addDefaultProps(Receipt) } />
                    <Route path="/upsells/" component={ this.addDefaultProps(Upsells) } />
                    <Route path="/admin/" component={ this.addDefaultProps(Admin) } />
                    <Route path="/product/:id" component={ this.addDefaultProps(Product) } />
                    <Route exact path="/register/" component={ this.addDefaultProps(Register) } />
                    <Route exact path="/shop/" component={ this.addDefaultProps(Shop) } />
                    <Route exact path="/shop/product/:id" component={ this.addDefaultProps(ProductDetails) } />
                    <Route exact path="/shop/summary/" component={ this.addDefaultProps(OrderSummary) } />
                </ScrollToTop>
            </Router>
        );
    }
}

export default App;

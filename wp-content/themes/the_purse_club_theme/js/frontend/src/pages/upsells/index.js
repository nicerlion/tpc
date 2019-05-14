import React, { Component } from 'react';
import {
    Redirect, Route, Link,
} from 'react-router-dom';

import ServiceApi from './../../api/service';
import UpSellV1 from './purse-charm';
import UpSellV2 from './cosmetic';
import SelectYourPlan from './select-your-plan/';
import TPCStorage from './../../components/common/storage';


const PREFIX = 'Upsell:';
const ROUTES = [
    // { path: 'select-your-plan', component: SelectYourPlan, prefix: PREFIX },
    { path: 'v2', component: UpSellV2, prefix: PREFIX },
    { path: 'v1', component: UpSellV1, prefix: PREFIX }
];


const UpsellComponent = (Klass) => class extends Klass {
    constructor(props) {
        super(props);
        this.getUpsellOpened = this.getUpsellOpened.bind(this);
        this._getActualUpsell = this._getActualUpsell.bind(this);
        this._getNextUpsell = this._getNextUpsell.bind(this);
        this.handleButton = this.handleButton.bind(this);
        this.handleButtonThanks = this.handleButtonThanks.bind(this);
        this.handleLastStep = this.handleLastStep.bind(this);
        this.isOpened = this.getUpsellOpened();
        this.__lastUrl = '/checkout';
        this.storage = new TPCStorage();
    }

    _getActualUpsell() {
        if (this.state.actualUpsell) {
            return this.state.actualUpsell;
        }
        let actualUpsell = this.props.getActualUpsell();
        this.setState({ actualUpsell });
        return actualUpsell;
    }

    _getNextUpsell() {
        let nextUpsell = this.props.getNextUpsell();
        if (nextUpsell) {
            return this.props.match.path + nextUpsell.path;
        }
        return this.__lastUrl;
    }

    getUpsellOpened() {
        let actualUpsell = this._getActualUpsell();
        return this.storage.getItem(`${actualUpsell.prefix}${actualUpsell.path}`);
    }

    handleLastStep(event) {
        if (this._getNextUpsell() === this.__lastUrl) {
            let api = new ServiceApi();
            this.setState({ loading: true });
            if (!event.defaultPrevented) {
                event.preventDefault();
            }
            api.createOrder({ ...this.props }).then(data => {
                this.setState({ loading: false });
                if ('result' in data) {
                    this.storage.setItem(this.props.UPSELLS_OPENED_KEY, 'true');
                    this.props.history.replace(
                        { pathname: '/checkout', state: { rejected: true, response: data } }
                    );
                } else {
                    this.props.history.replace(
                        { pathname: '/receipt', state: { order: data } }
                    );
                }
            });
        }
    }

    handleButton(event) {
        let actualUpsell = this._getActualUpsell();
        this.storage.setItem(`${actualUpsell.prefix}${actualUpsell.path}`, 'true');
        super.handleButton && super.handleButton(event);

        this.handleLastStep(event);
    }

    handleButtonThanks(event) {
        let actualUpsell = this._getActualUpsell();
        this.storage.setItem(`${actualUpsell.prefix}${actualUpsell.path}`, 'true');
        super.handleButtonThanks && super.handleButtonThanks(event);

        this.handleLastStep(event);
    }

    render() {
        if (this.isOpened) {
            return <Redirect to={{ pathname: this._getNextUpsell(), state: { rejected: true } }} />
        }
        return super.render();
    }
}


function addDefaultProps(WrappedComponent, defaultProps) {
    let getActualRoute = () => {
        return ROUTES.find(elem => {
            return defaultProps.location.pathname.endsWith(elem.path);
        });
    }
    let getNextRoute = () => {
        let storage = new TPCStorage();
        let actual = getActualRoute();
        let next = ROUTES[ROUTES.indexOf(actual) + 1];
        while (true) {
            if (next) {
                if (storage.getItem(`${next.prefix}${next.path}`)) {
                    next = ROUTES[ROUTES.indexOf(next) + 1];
                } else {
                    break;
                }
            } else {
                break;
            }
        }
        return next;
    }

    defaultProps = Object.assign({
        Routes: ROUTES,
        getActualUpsell: getActualRoute,
        getNextUpsell: getNextRoute
    }, defaultProps);

    class Wrapper extends Component {
        render() {
            let KlassComponent = UpsellComponent(WrappedComponent);
            let props = Object.assign({}, this.props, defaultProps);
            return <KlassComponent {...props} />
        }
    }

    return Wrapper;
}


const Upsells = (props) => (
    <div>
        {/* <Link to={`/upsells/v1`}>Upsell 1</Link>
        <Link to={`/upsells/v2`}>Upsell 2</Link> */}
        {ROUTES.map(upsell => {
            return <Route path={`${props.match.url}/${upsell.path}`} component={addDefaultProps(upsell.component, props)} />
        })}
    </div>
);

export default Upsells;

import React, { Component } from 'react';
import { Redirect, Link } from 'react-router-dom';
import './index.css';
import './media.css';

import ServiceApi from './../../../api/service';
import Loader from './../../../components/common/loader';
import TPCStorage from './../../../components/common/storage';


export default class UpSellV2 extends Component {

    constructor(props) {
        super(props);
        this.MEMBERSHIP_KEY = props.MEMBERSHIP_KEY;
        
        this.state = {
            response: {},
            loading: false
        }
        this.getProductsInStorage = this.getProductsInStorage.bind(this);
        this.storage = new TPCStorage();
    }

    componentDidMount() {
        this.api = new ServiceApi();
        this.setState({ loading: true });
        this.api.getUpsellTwoData().then(data => {
            this.setState({
                response: data,
                loading: false
            });
        });
    }

    handleButton() {
        let upsells = this.storage.getItem(this.props.UPSELL_KEY).replace(/^\,?/g, '').split(',');
        let upsellId = this.state.response.id.toString();
        if (!upsells.includes(upsellId)) {
            upsells.push(upsellId);
        }
        this.storage.setItem(this.props.UPSELL_KEY, upsells.join(','));
    }

    getProductsInStorage() {
        return this.storage.getItem(this.props.CART_KEY, false, true);
    }

    render () {
        return !(this.getProductsInStorage()) ? <Redirect to={'/shop'} />: (
            <div>
                <div class="page-wrapper">
                    <section class="ups-page-container ups-popup">
                        <div class="popup-ups-container upsell2-main-container" style={{'backgroundImage': `url(${this.state.response.image})`}}>
                            <p class="title-with-shadow">{this.state.response.subtitle}</p>
                            <div class="ups-colum-right">
                                <p class="vuluePricie upsell2-price"><span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">{ this.state.response.id && '$' }</span>{this.state.response.price}</span></p>
                                <div class="upTypography upsell2-deluxe">
                                    <h2>{this.state.response.title}</h2>
                                    <div dangerouslySetInnerHTML={{ __html: this.state.response.body }}></div>
                                </div>
                            </div>
                            <div class="ups-colum-right-bt upTypography">
                                <input class="hidden_upsellv2" name="hidden_upsellv2" value="yes" type="hidden" />
                                <input name="id_hidden_upsellv2" value="12600" type="hidden" />
                                <div class="v2 yes-upsell upsell2-order upsell2-order-button" id="upsell2OrderButton">
                                    { this.state.response.id && <Link to={this._getNextUpsell()} onClick={this.handleButton} replace>ADD TO MY ORDER</Link> }
                                </div>
                                <div class="v2 no-upsell upsell2-decline upsell2-decline-button" id="upsell2DeclineButton">
                                    { this.state.response.id && <Link to={this._getNextUpsell()} onClick={this.handleButtonThanks} replace>No Thanks. I decline</Link> }
                                </div>
                            </div>
                        </div> 
                    </section>
                    <Loader id="upsell-v2" loading={this.state.loading} />
                </div>
            </div>
        )
    }
}
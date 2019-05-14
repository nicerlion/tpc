import React, { Component } from 'react';
import { Redirect, Link } from 'react-router-dom';
import './index.css';

import ServiceApi from './../../../api/service';
import Loader from './../../../components/common/loader';
import TPCStorage from './../../../components/common/storage';


export default class UpSellV1 extends Component {
    
    constructor(props) {
        super(props);
        this.MEMBERSHIP_KEY = props.MEMBERSHIP_KEY;
        
        this.state = {
            response: {
                circle_image: {}
            },
            loading: false
        }
        this.getProductsInStorage = this.getProductsInStorage.bind(this);
        this.storage = new TPCStorage();
    }

    componentDidMount() {
        this.api = new ServiceApi();
        this.setState({ loading: true });
        this.api.getUpsellOneData().then(data => {
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
                        <div class="popup-ups-container" style={{'backgroundImage': `url(${this.state.response.body_image})`}}>
                            <div class="upsell-right">
                                <div class="tpc-session-right tpc-session-1">
                                    { this.state.response.id && <h2>{this.state.response.title}</h2> }
                                    <h3>{this.state.response.subtitle}</h3>
                                    <h4>{this.state.response.subtitle_2}</h4>
                                </div>
                                <div class="tpc-session-right tpc-session-2">
                                    <div class="tpc-column-1">
                                        <img src={this.state.response.circle_image.url} alt={this.state.response.circle_image.alt} />
                                    </div>
                                    <div class="tpc-column-2" dangerouslySetInnerHTML={{ __html: this.state.response.body }}></div>
                                </div>
                                {this.state.response.id && 
                                    <div class="tpc-session-right tpc-session-3">
                                        <div class="tpc-column-right" dangerouslySetInnerHTML={{ __html: this.state.response.feature_list }}></div>
                                    </div> }
                                <div class="tpc-session-right tpc-session-4">
                                    {this.state.response.id && <p>FOR JUST <span><sup>$</sup><sub id="tpc-price-value">{this.state.response.price}</sub></span> <strong>/ MONTHLY</strong></p> }
                                </div>
                                <div class="tpc-session-right tpc-session-5">
                                    <input id="hidden_upsell" name="hidden_upsell" value="no" type="hidden" />
                                    <input name="upsell_product" value="297" type="hidden" />
                                    <div id="yes-upsell yes-upsell-button" id="yesUpsellButton">
                                        {this.state.response.id && <Link id='place_order' to={this._getNextUpsell()} onClick={this.handleButton} replace>Add To My Order</Link> }
                                    </div>
                                    <div id="no-upsell no-upsell-button" id="noUpsellButton">
                                        {this.state.response.id && <Link id='place_order' to={this._getNextUpsell()} onClick={this.handleButtonThanks} replace>No Thank you. Continue with my order</Link> }
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </section>
                    <Loader id="upsell-v1" loading={this.state.loading} />
                </div>               
            </div>
        )
    }

}
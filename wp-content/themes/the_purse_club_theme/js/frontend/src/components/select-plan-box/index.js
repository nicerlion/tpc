import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import TPCStorage from './../common/storage';

export default class SelectPlanBox extends Component {

    constructor(props) {
        super(props);

        this.MEMBERSHIP_KEY = props.MEMBERSHIP_KEY;
        this.state = {
            plan: props.plan
        }
        this.handleButton = this.handleButton.bind(this);
        this.storage = new TPCStorage();
    }

    handleButton(event) {
        this.storage.setItem(this.MEMBERSHIP_KEY, this.state.plan.id);
        this.props.handleButton(event);
    }

    render() {
        return (
            <div>
                { this.state.plan.best_value ? <img class="item-select-img" src={this.state.plan.best_value.url} alt={this.state.plan.best_value.alt} /> : null }
                <div class="psypnewd-mini-item">
                    <div class="psypnewd-month-title">
                        <h2><span>{this.state.plan.name}</span></h2>
                    </div>
                    <div class="inside-box-psypnewd">
                        <p class="pice-detail"></p>
                        <img src={this.state.plan.images[0].src} alt={this.state.plan.images[0].alt}/>
                    </div>
                    <div class="psypnewd-text-box">
                        <p>{this.state.plan.short_description}</p>
                    </div>
                    <div class="psypnewd-value">
                        <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>{this.state.plan.price}</span>
                        <span class="subscription-details">{this.state.plan.price}</span>
                    </div>
                    <div class="psypnewd-black-button" id={ `plan-${this.state.plan.id}` }>
                        <Link onClick={this.handleButton} to={this.props.nextUrl} replace>SELECT PLAN</Link>
                        <div class="sp-clear"></div>
                    </div>
                </div>
            </div>
        );
    }
}
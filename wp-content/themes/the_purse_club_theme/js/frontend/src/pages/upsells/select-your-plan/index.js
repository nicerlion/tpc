import React, { Component } from 'react';
import ReactPixel from 'react-facebook-pixel';
import { Redirect, Link } from 'react-router-dom';
import './index.css';

import SelectPlanBox from '../../../components/select-plan-box';
import ServiceApi from './../../../api/service';
import Loader from './../../../components/common/loader';
import TPCStorage from './../../../components/common/storage';


// IMPORTANT: This page does not work propertly with new flow
/**
 * @deprecated
*/
export default class SelectYourPlan extends Component {

    constructor(props) {
        super(props);
        this.MEMBERSHIP_KEY = props.MEMBERSHIP_KEY;

        this.state = {
            response: {
                header: {},
                body_image: {}
            },
            loading: false
        }
        this.getPlansInLocalStorage = this.getPlansInLocalStorage.bind(this);
        this.storage = new TPCStorage();
    }

    componentDidMount() {
        this.api = new ServiceApi();
        this.setState({ loading: true });
        let membershipKey = this.getPlansInLocalStorage();
        this.api.getPlansData(membershipKey).then(data => {
            this.setState({
                response: data,
                loading: false
            });
        });
    }

    getPlansInLocalStorage() {
        return this.storage.getItem(this.MEMBERSHIP_KEY);
    }

    render() {
        return !(this.getPlansInLocalStorage()) ? <Redirect to={'/membership'} />:(
            <div>
                <div class="page-wrapper">
                    <section class="tpc-page-header psypnewd-header-img" style={
                        {'backgroundImage': `url(${this.state.response.header.image})`,
                        backgroundRepeat: this.state.response.header.repeat,
                        backgroundPosition: this.state.response.header.position,
                        backgroundSize: this.state.response.header.size}}>
                        <div class="container">
                            <div class="row">
                                <h2 class="title-page-header">{this.state.response.header.title}</h2>
                            </div>
                        </div>
                    </section>
                    <div class="container">
                        <div class="row">
                            <p class="psypnewd-first-text" dangerouslySetInnerHTML={{ __html: this.state.response.promotion_text }}></p>
                        </div>
                    </div>
                    <section class="popup-select-content psypnewd-popup-main-box" style={{'backgroundImage': `url(${this.state.response.body_image.image})`, backgroundRepeat: this.state.response.body_image.repeat, backgroundPosition: this.state.response.body_image.position, backgroundSize: this.state.response.body_image.size}}>
                        <div class="container">
                            <div class="row">
                                {this.state.response.plans && Object.keys(this.state.response.plans).map((key) => {
                                    return (
                                        <div class="psypnewd-item-select">
                                            <SelectPlanBox handleButton={this.handleButton} nextUrl={this._getNextUpsell()} plan={this.state.response.plans[key]} {...this.props} />
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                    </section>
                    <div class="container">
                        <div class="row">
                        <p class="psypnewd-last-text select-plan-no-thanks-button" id="selectPlanNoThanksButton">
                            {this.state.response.plans ? <Link to={this._getNextUpsell()} onClick={this.handleButtonThanks} replace>No thanks. I'll keep it monthly</Link> : null }
                        </p>
                        </div>
                    </div>
                    <Loader id="select-your-plan" loading={this.state.loading} />
                </div>
            </div>
        );
    }

}

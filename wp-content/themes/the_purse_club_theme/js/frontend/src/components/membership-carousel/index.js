import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import ReactPixel from 'react-facebook-pixel';
import TPCStorage from './../common/storage';

import './index.css';


export default class MembershipCarousel extends Component {

    constructor(props) {
        super(props);
        this.id = `carousel-${props.id}`;
        this.MEMBERSHIP_KEY = props.MEMBERSHIP_KEY;

        this.state = {
            membership: props.membership,
        }
        this.handleButton = this.handleButton.bind(this);
        this.storage = new TPCStorage();
    }

    handleButton(event) {
        this.storage.setItem(this.MEMBERSHIP_KEY, this.state.membership.product.id);
        const UPSELL_PREFIX = 'Upsell';
        ReactPixel.track('Lead',{ value: this.state.membership.product.id });
        this.storage.hasItem(UPSELL_PREFIX)

        let storage = !window.wpReactSettings.userEmail ? window.sessionStorage: window.localStorage;
        Object.keys(storage).map(key => {
            let prefix = UPSELL_PREFIX;
            if (window.wpReactSettings.userEmail) {
                prefix = this.storage.getEncode(prefix);
            }
            key.startsWith(prefix) && this.storage.removeItem(key);
        });
    } 

    render() {
        return this.state.membership.product.id && (
            <div>
                <div class="tpc-left-offer">
                    <div class="tpc-header-offer">
                        <h2>{this.state.membership.title}</h2>
                    </div>
                    <div class="tpc-container-offer">
                        <h3><span>{this.state.membership.subtitle}</span></h3>
                        <div class="tpc-info-offer">
                            <div class="tpc-info-offer-container">
                                <p class="tpc-price-info">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">$</span>
                                        <sub>{this.state.membership.product.price}</sub>
                                    </span>
                                </p>
                                <p dangerouslySetInnerHTML={{ __html: this.state.membership.description }}></p>
                                <div class="tpc-message">	
                                    <p class="suggestion-message">{this.state.membership.message}</p>
                                    <div id="suggestion-message"></div>
                                </div>
                                <div id={this.id} class="carousel slide tpc-carousel" data-ride="carousel">
                                    <div class="carousel-inner tpc-carousel-slider" role="listbox">
                                        {this.state.membership.thumbnails.map((image, index) => {
                                            return (
                                                <div class={'item ' + (index === 0 ? 'active': '')}>
                                                    <img src={image.url} alt={image.alt} style={{width: '100%'}} class={'d-block w-100'}/>
                                                </div>
                                            );
                                        })}
                                    </div>
                                    <a class="left carousel-control" href={`#${this.id}`} data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href={`#${this.id}`} data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                    <ol class="carousel-indicators">
                                        {this.state.membership.thumbnails.map((image, index) => {
                                            return (
                                                <li class={(index === 0 ? 'active': '')} data-target={`#${this.id}`} data-slide-to={index} style={{backgroundImage: `url(https://www.thepurseclub.com/wp-content/themes/the_purse_club_theme/img/transparent-white.png), url(${image.url})`}}>
                                                    <img alt="transparent" src="https://www.thepurseclub.com/wp-content/themes/the_purse_club_theme/img/transparent.png" />
                                                </li>
                                            )
                                        })}
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="hint-container">
                            <div class="tpc-details">
                                <p>
                                    <span class="tpc-ico-question" data-popup-open="popup-1">{this.state.membership.see_details}</span>
                                </p>
                                <div class="hover-popup">
                                    <div class="hover-popup-content" dangerouslySetInnerHTML={{ __html: this.state.membership.popup_detail}}></div>
                                    <img src="https://www.thepurseclub.com/wp-content/themes/the_purse_club_theme/img/hint-arrow.png" alt="selector"/>
                                </div>
                            </div>
                            <div class="tpc-membership-button">
                                <div id="tpc-disabled-1"></div>
                                <Link onClick={this.handleButton} to={{
                                    pathname: '/billing'
                                }}>{this.state.membership.button_text.toUpperCase()}</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}
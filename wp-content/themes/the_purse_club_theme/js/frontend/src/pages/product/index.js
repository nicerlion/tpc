import React, { Component } from 'react';
import { Redirect, Link } from 'react-router-dom';
import './index.css';
import './media.css';

import DefaultProduct from './../../components/product/';
import Loader from './../../components/common/loader/';
import Alert from './../../components/common/alert/';


export default class Product extends DefaultProduct {

    constructor(props) {
        super(props);
        this.handleSelect = this.handleSelect.bind(this);
    }

    /**
     * Method to handle when a purse is confirmed like a next month purse,
     * if everything is ok, then redirect to Thank-You page, with data. Else
     * An alert is raised, with server message provided
     * 
     * @param {Event} event Is the event fired by button
     * 
     * @returns {null}
     */
    handleSelect(event) {
        this.setState({ loading: true });
        this.api.setNewPurse(this.state.variation).then(data => {
            if (data.status && data.status == 400) {
                this.setState({
                    loading: false,
                    alert: Object.assign(this.state.alert, {
                        visible: true, message: data.message,
                        type: 'error'
                    })
                });
            } else {
                this.props.history.push({ pathname: '/admin/thank-you', state: { purse: data } });
                this.setState({
                    loading: false,
                    alert: Object.assign(this.state.alert, {
                        visible: true, message: `Setted ${data.name} for next billing period`,
                        type: 'success'
                    })
                });
            }
        }, data => {
            this.setState({
                loading: false,
                alert: Object.assign(this.state.alert, {
                    visible: true, message: data.message,
                    type: 'error'
                })
            })
        });
    }

    render() {
        if (this.state.redirect) {
            return <Redirect to={{ pathname: '/admin/pick-your-bag', state: { _products: this.historyState ? this.historyState._products : null, _cachePaginator: this.historyState ? this.historyState._cachePaginator: null } }} replace />;
        }
        let alert = this.state.alert.visible ? <Alert {...this.state.alert} onHide={this.hideAlert.bind(this)} /> : null;
        return (
            <div>
                <div class="page-wrapper">
                    <section>
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 apdp-main-container">
                                    <p class="back-selection">
                                        <Link to={
                                            {
                                                pathname: '/admin/pick-your-bag', state: {
                                                    _products: this.historyState ? this.historyState._products : null,
                                                    _cacheProduct: 'id' in this.state.data ? this.state.data : null,
                                                    _cachePaginator: this.historyState ? this.historyState._cachePaginator: null
                                                }
                                            }
                                        }>Back to selection</Link>
                                    </p>
                                    {this.state.data.id && <div class="apdp-big-container clearfix">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div id="carousel-gold" class={`carousel slide tpc-carousel ${this.imagesVariations.length < 4 ? 'apdp-fixed-indicators' : ''}`} data-ride="carousel">
                                                <div class="carousel-inner tpc-carousel-slider apdp-corousel-inner" role="listbox">
                                                    {this.imagesVariations.map((image, index, array) => {
                                                        if (array.length > 3 && (index - (array.length - 3)) >= 0 ) {
                                                            return null; 
                                                        }
                                                        return (
                                                            <div class={`item ${0 === index ? 'active' : ''}`} key={index}>
                                                                <img src={image.src} alt={image.alt} class="d-block w-100" style={{ 'width': '100%;' }} />
                                                            </div>
                                                        );
                                                    })}
                                                </div>
                                                <a class="carousel-control-prev left carousel-control" href="#carousel-gold" data-slide="prev" role="button">
                                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>

                                                <a class="carousel-control-next right carousel-control" href="#carousel-gold" data-slide="next" role="button">
                                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>

                                                <ol class="carousel-indicators">
                                                    {this.imagesVariations.map((image, index, array) => {
                                                        return (
                                                            <li class={`${0 === index ? 'active' : ''}`} key={index} data-target="#carousel-gold" data-slide-to={array.length > 3 && (index - (array.length - 3)) >= 0 ? index - (array.length - 3) : index } style={{ 'background-image': `url(https://www.thepurseclub.com/wp-content/themes/the_purse_club_theme/img/transparent-white.png), url(${image.src})` }}>
                                                                <img src="https://www.thepurseclub.com/wp-content/themes/the_purse_club_theme/img/transparent.png" alt="transparent" />
                                                            </li>
                                                        );
                                                    })}
                                                </ol>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="apdp-product-title">
                                                <h2>{this.state.data.name.toUpperCase()}</h2>
                                            </div>
                                            <p class="apdp-info-text clearfix" dangerouslySetInnerHTML={{ __html: this.state.data.short_description }}></p>
                                            <div class="apdp-dimension-section clearfix">
                                                <span>DIMENSIONS</span>
                                                <div class="apdp-mini-dimension">
                                                    <span>Height: {0 in this.state.data.variations ? this.state.data.variations[0].height : '-'}"</span>
                                                    <span>Width: {0 in this.state.data.variations ? this.state.data.variations[0].width : '-'}"</span>
                                                    <span>Lenght: {0 in this.state.data.variations ? this.state.data.variations[0].length : '-'}"</span>
                                                </div>
                                            </div>
                                            <div class="apdp-color-section clearfix apdp-hover">
                                                {0 in this.state.data.variations && this.state.data.variations.map(variation => {
                                                    return variation.attributes.color in this.constructor.BUCKET ? <img alt="transparent" key={variation.id} src="https://www.thepurseclub.com/wp-content/themes/the_purse_club_theme/img/transparent.png " style={{ 'background-color': `${this.constructor.BUCKET[variation.attributes.color]}`, }} onClick={() => this.onSelectColor(variation.id)} class={(this._variation && this._variation.id === variation.id) ? 'apdp-active' : ''} /> : null;
                                                })}
                                            </div>
                                            <div class="apdp-add-button">
                                                <button disabled={!this.state.variation} type="button" class="btn btn-primary" data-toggle="modal" data-target="#pickBagConfirm">Select Purse</button>
                                            </div>
                                        </div>
                                    </div>}
                                </div>
                                {this.state.data.id && <div class="modal fade" id="pickBagConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            {Boolean(this.state.variation) && <div class="modal-body">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-image">
                                                    <img src={this._variation.images[0].src} alt="prev" />
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mb-text">
                                                    <h4 class="pyb-modal-title">{this._variation.name.split(' - ')[0]}</h4>
                                                    <h5 class="pyb-modal-color">Color: <span>{this._variation.attributes.color.toUpperCase()}</span></h5>
                                                    <p class="pyb-modal-text">Added to Membership</p>
                                                </div>
                                            </div>}
                                            <div class="modal-footer">
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal" onClick={this.handleSelect}>CONFIRM</button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO THANKS</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>}
                                {alert}
                            </div>
                        </div>
                    </section>
                    <Loader loading={this.state.loading} />
                </div>
            </div>
        )
    }
}
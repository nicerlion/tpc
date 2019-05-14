import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import './index.css';
import './media.css';

import ProductDefault from './../../components/product';
import Counter from './../../components/counter';
import Loader from './../../components/common/loader';


export default class ProductDetails extends ProductDefault {

    constructor(props) {
        super(props);

        this.state = Object.assign(this.state, {  });
    }

    componentDidMount() {
        super.componentDidMount();
        this.api.getSubscriptionProductByCategory(this.props.match.params.id).then(membership => {
            this.setState({ membership });
        }, data => {
            console.error(data);
        });
    }

    getAddToCartDisabled() {
        if (this.state.variation) {
            if (!this._productInCart && this._variation.stock_quantity > 2) {
                return true;
            }
        }
        return false;
    }

    addToCart() {
        super.addToCart();
        this.props.history.push({ pathname: '/shop/summary' });
    }

    hasProductsInCart() {
        return Boolean(this.storage.getItem(this.props.CART_KEY, '', true).replace(/^\,?/g, ''));
    }

    get priceWithDiscount() {
        return this.state.membership ? (parseFloat(this.state.membership.price) / 2).toFixed(2): 0;
    }

    get imagesVariations() {
        let images = super.imagesVariations;
        return images.length > 3 ? images.slice(0, images.length - 3): images;
    }

    render() {
        return (
            <div>
                <div class="page-wrapper pd-wrapper">
                    <section class="shop-counter">
                        <div class="container">
                            <div class="row">
                                <Counter {...this.props} />
                            </div>
                        </div>
                    </section>
                    { this.state.data.id && <section class="pd-main-container">
                        <div class="container">
                            <div class="row">
                                <div class="pd-links-container">
                                    <p class="back-selection">
                                        <Link to={
                                            {
                                                pathname: '/shop/', state: {
                                                    _products: this.historyState ? this.historyState._products : null,
                                                    _cacheProduct: 'id' in this.state.data ? this.state.data : null,
                                                    // _cachePaginator: this.historyState ? this.historyState._cachePaginator : null
                                                }
                                            }
                                        }>Back to selection</Link>
                                    </p>
                                    { this.hasProductsInCart() && <p class="go-checkout">
                                        <Link to={ { pathname: '/shop/summary'} }>Go to Checkout</Link>
                                    </p> }
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div id="shopCarousel" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">
                                            {this.imagesVariations.map((image, index, array) => {
                                                return (
                                                    <div class={`item ${0 === index ? 'active' : ''}`} key={index}>
                                                        <img class="d-block img-fluid" src={image.src} alt={image.alt} />
                                                    </div>
                                                );
                                            })}
                                        </div>
                                        <a class="carousel-control-prev left carousel-control" href="#shopCarousel" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next right carousel-control" href="#shopCarousel" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                        <ol class="carousel-indicators">
                                            {this.imagesVariations.map((image, index, array) => {
                                                return (
                                                    <li class={`${0 === index ? 'active' : ''}`} key={index} data-target="#shopCarousel" data-slide-to={index} style={{ 'background-image': `url(${image.src}),url(https://www.thepurseclub.com/wp-content/themes/the_purse_club_theme/img/transparent.png)` }}>
                                                        <img src="https://www.thepurseclub.com/wp-content/themes/the_purse_club_theme/img/transparent.png" alt="transparent" />
                                                    </li>
                                                );
                                            })}
                                        </ol>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pd-container">
                                    <div class="pd-info">
                                        <h1>{this.state.data.name.toUpperCase()}</h1>
                                        <p style={{ 'text-decoration': 'line-through' }}>REG<span class="pd-price">${this.state.data.price}</span></p>
                                        <p style={this.props.getSignUpDiscount() ? { 'text-decoration': 'line-through' }: {}}>VIP<span class="pd-price">${this.state.membership ? this.state.membership.price : 0}</span></p>
                                        { this.props.getSignUpDiscount() && <div>
                                            <p class="pd-offer-price">With 50% off: ${this.priceWithDiscount}</p>
                                            <p class="pd-vip-offer"><span class="nvme">50% Off First Order</span></p>
                                        </div> }
                                    </div>
                                    <div class="pd-color">
                                        <p>{this.state.variation && 'COLOR'} <span>{this.state.variation && this._variation.attributes.color.toUpperCase()}</span></p>
                                        <div class="pd-color-container">
                                            {0 in this.state.data.variations && this.state.data.variations.map(variation => {
                                                return variation.attributes.color in this.constructor.BUCKET ? <img alt="transparent" key={variation.id} src="https://www.thepurseclub.com/wp-content/themes/the_purse_club_theme/img/transparent.png " style={{ 'background-color': `${this.constructor.BUCKET[variation.attributes.color]}`, }} onClick={() => this.onSelectColor(variation.id)} class={(this._variation && this._variation.id === variation.id) ? 'apdp-active' : ''} /> : null;
                                            })}
                                        </div>
                                    </div>
                                    {this.getAddToCartDisabled() && <div class="pd-addtocart">
                                        <button onClick={this.addToCart}> ADD TO CART</button>
                                        <a>Shop with Confidence</a>
                                    </div>}
                                    <div class="pd-description">
                                        <h3>Description</h3>
                                        <p dangerouslySetInnerHTML={{ __html: this.state.data.short_description }}></p>
                                        <div class="apdp-mini-dimension">
                                            <span>Height: {0 in this.state.data.variations ? this.state.data.variations[0].height : '-'}"</span>
                                            <span>Width: {0 in this.state.data.variations ? this.state.data.variations[0].width : '-'}"</span>
                                            <span>Lenght: {0 in this.state.data.variations ? this.state.data.variations[0].length : '-'}"</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <img src="https://www.thepurseclub.com/wp-content/uploads/2018/02/banner-1.jpg" alt="banner" banner/>
                            </div>
                        </div>
                    </section> }
                    <Loader loading={this.state.loading} />
                </div>
            </div>
        )
    }
}
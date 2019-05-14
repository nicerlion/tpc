import React, { Component } from 'react';

import ServiceApi from './../../api/service';
import TPCStorage from './../common/storage';


export default class Product extends Component {

    static BUCKET = {
        brown: '#653827',
        'brown-bucket': '#653827',
        red: '#d80000',
        gray: '#aaa',
        grey: '#aaa',
        beige: '#f5ecdc',
        black: '#000',
        white: '#fff'
    }

    constructor(props) {
        super(props);

        this.state = {
            loading: true,
            data: {},
            variation: '',
            alert: {
                visible: false,
                message: ''
            }
        }

        this.storage = new TPCStorage();
        this.getProduct = this.getProduct.bind(this);
        // this.handleSelect = this.handleSelect.bind(this);
        this.onSelectColor = this.onSelectColor.bind(this);
        this.addToCart = this.addToCart.bind(this);
        this.historyState = props.history.location.state;
    }

    componentDidMount() {
        this.api = new ServiceApi();
        this.props.redirectIfUserIsNotLogged(true);
        this.getProduct(this.props.match.params.id);
    }

    componentDidUpdate(prevProps) {
        if (prevProps.match.params.id !== this.props.match.params.id) {
            this.setState({ variation: '' });
            this.getProduct(this.props.match.params.id);
        }
    }

    addToCart() {
        let products = this.storage.getItem(this.props.CART_KEY, '', true).split(',');
        if (!this._productInCart) {
            products.push(this._variation.id);
            this.storage.setItem(this.props.CART_KEY, products.join(','), true);
        }
    }

    get _productInCart() {
        if (!this._variation) {
            return false;
        }
        return Boolean(
            (this.storage.getItem(this.props.CART_KEY, '', true))
            .indexOf(this._variation.id.toString()) + 1);
    }

    /**
     * Method to get Product information. This method first verifies if some data
     * comes from another page, if there's case, load product from their data. If can't
     * get data from history, then, make an request to server and get it.
     * 
     * @param {Number} id ID of product to request.
     * 
     * @return {null}
     */
    getProduct(id) {
        this.setState({ loading: true });
        if (this.historyState && this.historyState._cacheProduct) {
            this.setState({ data: this.historyState._cacheProduct, loading: false });
        } else {
            this.api.getProducts(id).then(data => {
                if (0 in data) {
                    this.setState({
                        data: data[0],
                        loading: false
                    });
                } else {
                    this.setState({
                        loading: false,
                        redirect: true
                    });
                }
            }, data => {
                this.setState({
                    loading: false,
                    redirect: true
                });
            });
        }
    }

    /**
     * Method to set state variation. Set variation when user click on color
     * @param {Number} variation Variation ID
     */
    onSelectColor(variation) {
        let future = this.state.data.variations.find(el => {
            return parseInt(el.id) === parseInt(variation);
        });
        if (parseInt(future.stock_quantity) > 2) {
            this.setState({ variation });
        }
    }

    /**
     * Property to return a list of images sources to display in carousel
     * product. This just return available images and not return images
     * for 'Multi' product variations.
     * 
     * @returns {Array} with images sources.
     */
    get imagesVariations() {
        let images = [...this.state.data.images];
        this.state.data.variations.map(elem => {
            if (elem.attributes.color !== 'multi' && !elem.images[0].src.endsWith('placeholder.png')) {
                images.push(elem.images[0]);
            }
            return null;
        });
        if (images.length > 3) {
            images = [...images, ...images.slice(0, 3)];
        }
        return images;
    }

    /**
     * Property to return the variation object found when variation state
     * is setted to a available value. This object is found in variation
     * data state value.
     * 
     * @returns {Object} Variation Object
     */
    get _variation() {
        return this.state.data.variations.find(el => {
            return parseInt(el.id) === parseInt(this.state.variation);
        });
    }

    hideAlert() {
        this.setState({
            alert: Object.assign(this.state.alert, {
                visible: false
            })
        })
    }

}
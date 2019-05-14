import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import './index.css';
import './media.css';

import ServiceApi from './../../../api/service';
import Loader from './../../../components/common/loader/';


class PurseBox extends Component {

    render () {
        return (
            <div>
                <div class="as-product-content">
                    <div class="as-product-box">
                        <div class="as-product-image">
                            <img src={0 in this.props.data.images ? this.props.data.images[0].src : "/wp-content/plugins/woocommerce/assets/images/placeholder.png"} alt="product" />
                        </div>
                        <Link to={{ pathname: `/product/${this.props.data.id}`, state: { _products: this.props.toState, _cacheProduct: this.props.data, _cachePaginator: this.props.pagination } }}>
                            <div class="as-button">
                                <p>DETAILS</p>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        );
    }

}


export default class AdminStore extends Component {

    constructor(props) {
        super(props);

        this.state = {
            purses: [],
            actualPurse: { images: [] },
            loading: false,
            paginator: {
                page: 1,
                limit: 10,
                data: null
            }
        }

        this.getMore = this.getMore.bind(this);
    }

    componentDidMount() {
        let service = this.service = new ServiceApi();
        let historyState = this.props.history.location.state;

        this.setState({ loading: true });
        service.getActualPurse().then(data => {
            if (data.status && [403, 405].indexOf(data.status) + 1) {
                this.setState({
                    purses: [],
                    loading: false
                });
                this.props.history.push({ pathname: '/admin/dashboard' });
            } else if (data.status && data.status == 400) {
                this.setState({ actualPurse: { name: 'No order to edit', images: [] } });
            } else {
                this.setState({actualPurse: data});
            }
        }, data => {
            this.setState({ actualPurse: { name: 'No order to edit', images: [] } });
        });
        if (historyState && historyState._products) {
            this.setState({
                purses: historyState._products,
                loading: false,
                paginator: historyState._cachePaginator || this.state.paginator
            });
        } else {
            service.getProductsPicYourBag({limit: this.state.paginator.limit}).then(data => {
                if ([403, 405].indexOf(data.status) + 1) {
                    this.setState({
                        purses: [],
                        loading: false
                    });
                    this.props.history.push({ pathname: '/admin/dashboard' });
                } else {
                    this.setState({
                        purses: data.products,
                        loading: false,
                        paginator: Object.assign(this.state.paginator, {
                            data: data.pagination
                        })
                    });
                }
            });
        }
    }

    getMore() {
        if (this.state.paginator.data.next) {
            let page = this.state.paginator.page + 1;
            this.setState({ loading: true });
            this.service.getProductsPicYourBag({ limit: this.state.paginator.limit, page }).then(data => {
                this.setState({
                    purses: [...this.state.purses, ...data.products],
                    loading: false,
                    paginator: Object.assign(this.state.paginator, {
                        page,
                        data: data.pagination
                    })
                })
            });
        }
    }

    render () {
        return (
            <div>
                <div class="page-wrapper">
                    <section class="pyb-hero">
                        <div class="container">
                            <div class="row">
                                <div class="as-main-title">
                                    <h1>STYLES YOU MIGHT LIKE</h1>
                                    <p>Take a look at some of our styles based on your style quiz results</p>
                                </div>
                                <div class="as-main-back">
                                    <img class="as-banner-hidden-up" src="https://www.thepurseclub.com/wp-content/uploads/2018/02/relaxorchoose-1.jpg" />
                                    <img class="as-banner-hidden-down" src="https://www.thepurseclub.com/wp-content/uploads/2018/02/relaxorchoose.jpg" />
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="pyb-products">
                        <div class="container">
                            <div class="row">
                                <div class="as-content-box">
                                    <div class="col-xs-12 col-sm-12 col-md-6 as-selected-product">
                                        <div class="selected-product-container">
                                            <img alt="selected" src={0 in this.state.actualPurse.images ? this.state.actualPurse.images[0].src : '/wp-content/plugins/woocommerce/assets/images/placeholder.png'} />
                                            <p class="as-name">{ Boolean(this.state.actualPurse.id) && this.state.actualPurse.name.split(' - ')[0] }</p>
                                            <div class="as-line"></div>
                                            <p class="as-select-purse">Selected for you...</p>
                                        </div>
                                    </div>
                                    {
                                        Boolean(this.state.purses.length) && this.state.purses.map((purse, index) => {
                                            if (purse.variations.some(elem => { return elem.stock_quantity > 0; })) {
                                                return (
                                                    <div class="col-xs-6 col-sm-6 col-md-3 as-col-content" key={index}>
                                                        <PurseBox data={purse} toState={this.state.purses} pagination={this.state.paginator} />
                                                    </div>
                                                );
                                            }
                                            return null;
                                        })
                                    }
                                </div>
                                <div class="as-clear"></div>
                                {(this.state.paginator.data && this.state.paginator.data.next) && <button class="as-button as-button-view" onClick={this.getMore}>VIEW MORE</button> }
                            </div>
                        </div>
                    </section>
                    <Loader loading={ this.state.loading } />
                </div>
            </div>
        )
    }

}
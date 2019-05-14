import React, { Component } from 'react';
import './index.css';

import ServiceApi from './../../../api/service';
import Loader from './../../../components/common/loader';


export default class Orders extends Component {

    constructor(props) {
        super(props);

        this.state = {
            orders: [],
            loading: false
        }
    }

    componentDidMount() {

        this.api = new ServiceApi();
        this.setState({
            loading: true
        })

        this.api.getCustomerOrders().then(data => {
            this.setState({
                orders: data.orders,
                loading: false
            });
        });
        
    }

    render () {
        return (
            <div>
                <div class="page-wrapper">
                    <section>
                        <div class="woocommerce">
                            <div class="woocommerce-MyAccount-content billing-address">
                                <div class="my-account-container">
                                    <h3>PENDING ORDERS</h3>
                                    <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
                                        <thead>
                                            <tr>
                                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number">
                                                    <span class="nobr">Order</span>
                                                </th>
                                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number">
                                                    <span class="nobr">Date</span>
                                                </th>
                                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number">
                                                    <span class="nobr">Status</span>
                                                </th>
                                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number">
                                                    <span class="nobr">Total</span>
                                                </th>
                                            </tr>   
                                        </thead>
                                        <tbody>
                                            {
                                                Boolean(this.state.orders.length) ? this.state.orders.map((order, index) => {
                                                    return (
                                                        <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-processing order">
                                                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number">
                                                                { order.id }
                                                            </td>
                                                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="date">
                                                                <time>{ order.date }</time>
                                                            </td>
                                                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status" data-title="Status">
                                                                { order.status }
                                                            </td>
                                                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total" data-title="Total">
                                                                <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>{ order.total }</span>
                                                            </td>
                                                        </tr>
                                                    )
                                                }): <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-processing order">
                                                    <td colspan="4">Not orders found</td>
                                                </tr>
                                            }
                                        </tbody>    
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                    <Loader loading={ this.state.loading } />
                </div>
            </div>
        )
    }

}
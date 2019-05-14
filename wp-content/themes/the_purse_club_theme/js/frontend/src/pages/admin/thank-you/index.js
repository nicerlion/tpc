import React, { Component } from 'react';
import { Redirect, Link } from 'react-router-dom';

import './index.css';
import './media.css';


export default class ThankYou extends Component {

    constructor(props) {
        super(props);

        this.historyState = props.history.location.state;
    }

    render () {
        return this.historyState && 'purse' in this.historyState ? (
            <div>
                <section>
                    <div class="container">
                        <div class="thankp-container">
                            <div class="thankp-first-box">
                                <p>You have changed your selection to this bag:</p>
                            </div>    
                            <div class="thankp-second-box">
                                <img src={this.historyState.purse.images[0].src} />
                            </div>
                            <div class="thankp-third-box">
                                <p>{ this.historyState.purse.name.split(' - ')[0] }</p>
                            </div>
                            <div class="thankp-out-box">
                                <p>If you would like to select a different purse, click <Link to={ {pathname: '/admin/pick-your-bag'} }> here</Link>.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        ) : <Redirect to={ {pathname: '/admin/pick-your-bag'} } />
    }

} 
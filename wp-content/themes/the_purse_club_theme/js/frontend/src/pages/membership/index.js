import React, { Component } from 'react';
import './index.css';
import './media.css';

import Loader from './../../components/common/loader';
import MembershipCarousel from '../../components/membership-carousel';
import ServiceApi from './../../api/service';


export default class Membership extends Component {

    constructor(props) {
        super(props);
        this.state = {
            response: {
                header: {}
            },
            loading: false
        }
    }

    componentDidMount() {
        this.api = new ServiceApi();
        this.setState({ loading: true });
        this.api.getMembershipData().then(data => {
            this.setState({
                response: data,
                loading: false
            });
        });
    }

    render() {
        return (
            <div>
                <div class="page-wrapper">
                    <section class="tpc-page-header" style={
                        {backgroundImage: `url(${this.state.response.header.image ? this.state.response.header.image: ''})`,
                        backgroundRepeat: this.state.response.header.repeat,
                        backgroundPosition: this.state.response.header.position,
                        backgroundSize: this.state.response.header.size}}>
                        <div class="container">
                            <div class="row">
                                <h1 class="title-page-header">{this.state.response.header.title}</h1>
                                { this.state.response.memberships && <div class="tpc-header-p"><p></p></div> }
                            </div>
                        </div>
                    </section>
                    <section class="tpc-page-container tpc-page-membership">
                        <div class="container">
                            <div class="row">
                                {this.state.response.memberships && Object.keys(this.state.response.memberships).map((key) => {
                                    return (
                                        <div class="tpc-marg-b-57 col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <MembershipCarousel membership={this.state.response.memberships[key]} id={key} {...this.props} />
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                    </section>
                    <Loader id="membership" loading={this.state.loading} />
                </div>
            </div>
        );
    }
}
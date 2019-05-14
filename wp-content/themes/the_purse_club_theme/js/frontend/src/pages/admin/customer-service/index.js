import React, { Component } from 'react';
import './index.css';
import './media.css';


export default class CustomerService extends Component {

    render () {
        return (
            <div>
                <section>
                    <div class="woocommerce-MyAccount-content">
                        <div class="container customer-service-main-box">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 cs-contact-first">
                                        <div class="cs-contact-sec">
                                            <h2>CONTACT US!</h2>
                                            <div class="underline-customer"></div>
                                            <div class="cs-icons-box clearfix">
                                                <ul>
                                                    <li><img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/email-customer.png" /><p>EMAIL US</p></li>
                                                    <li><img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/call-customer.png"  /><p>GIVE US A CALL</p></li>
                                                    <li><img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/chat-customer.png" /><p>CHAT WITH US</p></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 cs-contact-second">
                                        <div class="cs-contact-second-sec">
                                            <h3>LET'S GET</h3>
                                            <h2>SOCIAL!</h2>
                                            <div class="underline-customer-second"></div>
                                            <div class="cs-social-box">
                                                <img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/customer-facebook-logo.png" />
                                                <img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/customer-instagram-logo.png" />
                                                <img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/customer-pinterest-logo.png" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        )
    }

}
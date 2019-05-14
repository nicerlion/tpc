import React,  { Component } from 'react';
import { Link, Redirect } from 'react-router-dom';
import ReactPixel from 'react-facebook-pixel';

import './index.css';
import './media.css';

import TPCStorage from './../../components/common/storage';


export default class Receipt extends Component {

    constructor(props) {
        super(props);

        this.flushLocalStorage = this.flushLocalStorage.bind(this);
        this.storage = new TPCStorage();
    }

    componentDidMount() {
        const scriptTaboola = document.createElement("script");
        scriptTaboola.src = "//cdn.taboola.com/libtrc/vader-sc-sc/tfa.js";
        scriptTaboola.async = true;
        document.body.appendChild(scriptTaboola);
        
        const scriptTaboolaPixel = document.createElement('script');
        scriptTaboolaPixel.type = 'text/javascript';
        scriptTaboolaPixel.innerHTML = "window._tfa = window._tfa || []; _tfa.push({ notify: 'action',name: 'Conversion' });";
        document.body.appendChild(scriptTaboolaPixel);
        
        const outbrainConversionPixel = document.createElement('script');
        outbrainConversionPixel.type = 'text/javascript';
        outbrainConversionPixel.innerHTML = "!function(_window, _document) {var OB_ADV_ID='00b5a9b1dadfa04dd7ff405d1b456a9f8b'; if (_window.obApi) {var toArray = function(object) {return Object.prototype.toString.call(object) === '[object Array]' ? object : [object];};_window.obApi.marketerId = toArray(_window.obApi.marketerId).concat(toArray(OB_ADV_ID));return;} var api = _window.obApi = function() {api.dispatch ? api.dispatch.apply(api, arguments) : api.queue.push(arguments);};api.version = '1.1';api.loaded = true;api.marketerId = OB_ADV_ID;api.queue = [];var tag = _document.createElement('script');tag.async = true;tag.src = '//amplify.outbrain.com/cp/obtp.js';tag.type = 'text/javascript';var script = _document.getElementsByTagName('script')[0];script.parentNode.insertBefore(tag, script);}(window, document); obApi('track', 'PAGE_VIEW');";
        document.body.appendChild(outbrainConversionPixel);
        
        const stackadaptConversionPixel = document.createElement('script');
        stackadaptConversionPixel.type = 'text/javascript';
        stackadaptConversionPixel.innerHTML = "!function(s,a,e,v,n,t,z){if(s.saq)return;n=s.saq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!s._saq)s._saq=n;n.push=n;n.loaded=!0;n.version='1.0';n.queue=[];t=a.createElement(e);t.async=0;t.src=v;z=a.getElementsByTagName(e)[0];z.parentNode.insertBefore(t,z)}(window,document,'script','https://tags.srv.stackadapt.com/events.js');saq('conv','Ef9XveXNVxwqxOFLKMKL9A');";
        document.body.appendChild(stackadaptConversionPixel);

        const stackadaptConversionPixelImage = document.createElement('noscript');
        stackadaptConversionPixelImage.innerHTML = "<img src='https://srv.stackadapt.com/conv?cid=Ef9XveXNVxwqxOFLKMKL9A' width='1' height='1'/>";
        document.body.appendChild(stackadaptConversionPixelImage);

        const stackadaptRetargetingExclusionPixel = document.createElement('script');
        stackadaptRetargetingExclusionPixel.type = 'text/javascript';
        stackadaptRetargetingExclusionPixel.innerHTML = "!function(s,a,e,v,n,t,z){if(s.saq)return;n=s.saq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!s._saq)s._saq=n;n.push=n;n.loaded=!0;n.version='1.0';n.queue=[];t=a.createElement(e);t.async=0;t.src=v;z=a.getElementsByTagName(e)[0];z.parentNode.insertBefore(t,z)}(window,document,'script','https://tags.srv.stackadapt.com/events.js');saq('rt', 'CgqCW1JkfKNE3Qw-jSaTpA');";
        document.body.appendChild(stackadaptRetargetingExclusionPixel);

        const stackadaptRetargetingExclusionPixelImage = document.createElement('noscript');
        stackadaptRetargetingExclusionPixelImage.innerHTML = "<img src='https://srv.stackadapt.com/rt?sid=CgqCW1JkfKNE3Qw-jSaTpA' width='1' height='1'/>";
        document.body.appendChild(stackadaptRetargetingExclusionPixelImage);

        if (document.getElementById("tpc-style-content")) {
            var style = document.getElementById("tpc-style-content");
            style.innerHTML += '<style>' +
                '.tpc-logged-visible{display: block !important;}' +
                'li.tpc-logged-visible{display: inline-block !important;}' +
                '.tpc-logged-hidden, li.tpc-logged-hidden{display: none !important;}' +
            '</style>';
        }
    }

    flushLocalStorage() {
        let prefixes = [
            this.props.MEMBERSHIP_KEY, this.props.UPSELL_KEY, this.props.ORDER_KEY,
            this.props.UPSELLS_OPENED_KEY, 'billing', 'shipping', 'Upsell',
            'card', 'payment', 'purse', 'coupon', 'PSRID'
        ]

        Object.keys(window.localStorage).concat(Object.keys(window.sessionStorage)).map((key) => {
            prefixes.map(prefix => {
                let wouldDecode = key.startsWith(this.storage.getEncode('') || '0');
                if (wouldDecode) {
                    prefix = this.storage.getEncode(prefix);
                }
                if (key.startsWith(prefix)) {
                    window.localStorage.removeItem(key);
                    window.sessionStorage.removeItem(key);
                };
            });
        });

        this.storage.removeItem(this.props.CART_KEY, true);
    }

    getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    render () {
        let historyState = this.props.history.location.state;
        let refererClickID = this.getCookie.bind(this)('refererClickID');
        if (historyState && historyState.order) {
            ReactPixel.track('Purchase', { value: historyState.order.total, currency: 'USD' });
            window.obApi && window.obApi('track', 'purse club');
            this.flushLocalStorage();
        }

        if (!(historyState && historyState.order)) {
            window.location.href = '/my-account';
        }

        let has_membership = historyState.order.meta_data.find(el => { return el.key === 'tpc_membership_product_front' });

        return (historyState && historyState.order) ? (
            <div>
                <div class="page-wrapper">
                    <section class="receipt-page-header">
                        <div class="receipt-banner-container">
                            <div class="receipt-banner-content">
                                <div class="receipt-banner-border">
                                    <p>pick your purse</p>
                                    <p class="small-yellow">or see</p>
                                    <p>the bag we selected </p>
                                </div>
                                {/* <a href="/admin/#/admin/pick-your-bag">VIEW NOW  <sup class="arrow-btn">&#9658;</sup></a> */}
                            </div> 
                        </div> 
                    </section>
                    <section class="receipt-page-container receipt-page">
                        <div class="container-fluid">
                            <div class="container">
                                <div class="row">
                                    <div class="receipt-big-box">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">    
                                            <div class="receipt-big-section">
                                                <div class="receipt-info-section">
                                                    <div class="receipt-first-text">
                                                        <h2>SHIPPING DETAILS</h2>
                                                        {/* <div class="receipt-button">
                                                            <a href="">EDIT</a> 
                                                        </div>   */}
                                                        <div class="underline-receipt"></div>
                                                            <p>{historyState.order.billing.first_name} {historyState.order.billing.last_name}</p>
                                                            <p>{historyState.order.shipping.address_1 ? historyState.order.shipping.address_1 : historyState.order.billing.address_1 }, {historyState.order.shipping.address_2 ? historyState.order.shipping.address_2 : historyState.order.billing.address_2}</p>
                                                            <p>{historyState.order.shipping.city ? historyState.order.shipping.city : historyState.order.billing.city}, {historyState.order.shipping.state ? historyState.order.shipping.state : historyState.order.billing.state}, {historyState.order.shipping.postcode ? historyState.order.shipping.postcode : historyState.order.billing.postcode}</p>
                                                            <p>{historyState.order.billing.country}</p>
                                                    </div>
                                                </div>
                                                <div class="receipt-info-section">
                                                    <div class="receipt-second-text">
                                                        <h2>PAYMENT DETAILS</h2>
                                                        {/* <div class="receipt-button">
                                                            <a href="">EDIT</a> 
                                                        </div> */}
                                                        <div class="underline-receipt"></div>
                                                        <p>Card Holder Name: {historyState.order.billing.first_name} {historyState.order.billing.last_name}</p>
                                                        <p>Payment Method: {historyState.order.payment_method_title}</p>
                                                        <p>Order Number: {historyState.order.number}</p>
                                                        <p>Order Date: {window.moment(historyState.order.date_created).format('MM-DD-YYYY')}</p>
                                                    </div>{/* ends receipt-second-text */}
                                                </div>{/* ends receipt-info-section*/}
                                            </div> 
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="receipt-big-section">
                                                <div class="receipt-info-section">
                                                    <div class="receipt-third-text">
                                                        <h2>ORDER DETAILS</h2>
                                                        {/* <div class="receipt-button">
                                                            <a href="">EDIT</a> 
                                                        </div> */}
                                                        <div class="underline-receipt"></div>
                                                        <div class="receipt-inside-third">
                                                            {historyState.order.products.map(item => {
                                                                if (has_membership && parseInt(item.product_id) === parseInt(has_membership.value)) {
                                                                    return (
                                                                        <div>
                                                                            <h3>{item.name}</h3>
                                                                            <h4>$ <sub>{item.total}</sub> / MONTH</h4>
                                                                        </div>
                                                                    );
                                                                }
                                                                return (
                                                                    <ul>
                                                                        <li><span>{item.name}:</span><span> $</span>{item.total}</li>
                                                                    </ul>
                                                                )
                                                            })}
                                                            <h3 class="total-order">ORDER TOTAL:<span> $</span>{historyState.order.total}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {/* <div style={{ 'text-align': 'center', 'font-size': '16px' }}>
                                        <p>Click <a href="/admin/#/admin/pick-your-bag">HERE</a> to see the purse we've selected based on your style results or pick your own</p>
                                    </div> */}
                                    <div class="receipt-go-button">
                                        <a href="/my-account">GO TO ADMIN</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                { Boolean(refererClickID) && <iframe
                    src={ `https://cliktrk.com/p.ashx?o=44&e=2&t=${historyState.order.id}&r=${refererClickID}` }
                    height="1" width="1"
                    frameborder="0"></iframe> }
            </div>
        ): <Redirect to={ {pathname: '/'} } replace />;
    }
}
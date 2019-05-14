import { Component } from 'react';
import { withRouter } from 'react-router'
import ReactGA from 'react-ga';
import ReactPixel from 'react-facebook-pixel';

ReactGA.initialize('UA-101624739-1');


class ScrollToTop extends Component {

    componentDidMount() {
        ReactPixel.init(this.props.PIXEL_ID_1);
        ReactPixel.init(this.props.PIXEL_ID_2);
        ReactPixel.pageView();

        const gTMContainer = document.createElement('script');
        gTMContainer.type = 'text/javascript';
        gTMContainer.innerHTML = "(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-MWL42CX');";
        document.body.appendChild(gTMContainer);

        const outBrainCPixel = document.createElement('script');
        outBrainCPixel['data-obct'] = true;
        outBrainCPixel.type = 'text/javascript';
        outBrainCPixel.innerHTML = "!function(_window, _document) {var OB_ADV_ID='00c11d980fa1f019092650c9cbcc8e3f61'; if (_window.obApi) {var toArray = function(object) {return Object.prototype.toString.call(object) === '[object Array]' ? object : [object];};_window.obApi.marketerId = toArray(_window.obApi.marketerId).concat(toArray(OB_ADV_ID));return;} var api = _window.obApi = function() {api.dispatch ? api.dispatch.apply(api, arguments) : api.queue.push(arguments);};api.version = '1.1';api.loaded = true;api.marketerId = OB_ADV_ID;api.queue = [];var tag = _document.createElement('script');tag.async = true;tag.src = '//amplify.outbrain.com/cp/obtp.js';tag.type = 'text/javascript';var script = _document.getElementsByTagName('script')[0];script.parentNode.insertBefore(tag, script);}(window, document); obApi('track', 'PAGE_VIEW');";
        document.body.appendChild(outBrainCPixel);
    }

    componentDidUpdate(prevProps) {
        if (this.props.location !== prevProps.location) {
            window.scrollTo(0, 0);
            // analytics
            ReactGA.pageview(window.location.hash);
            
            // FB Pixel
            ReactPixel.pageView();
        }
    }

    render() {
        return this.props.children;
    }
}

export default withRouter(ScrollToTop);

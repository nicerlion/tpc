/**
 * APIClient for ajax calls
 * 
 * v1.0.0
 */

export default class ApiClient {
    constructor (url = '') {
        this._uri = url;
        this.fetch = window.fetch.bind(window);
        if (!window.wpApiSettings) {
            console.warn('wpApiSettings of wordpress api script, is not available, api maybe not work property.');
        }
    }

    getHeaders(headers = {}) {
        let defaultHeaders = {};
        if (window.wpApiSettings) {
            defaultHeaders['X-WP-Nonce'] = window.wpApiSettings.nonce;
        }
        return Object.assign(headers, defaultHeaders);
    }

    getUrl(url) {
        if (!this._uri && window.wpApiSettings) {
            this._uri = window.wpApiSettings.root;
        }
        if (url.startsWith('/')) {
            if (this._uri) {
                return this._uri.concat(url.substring(1, url.length));
            }
            return url;
        } else if (url.startsWith('http')) {
            return url;
        }
        if (this._uri) {
            return this._uri;
        }
        console.error('Not url provided to make request');
    }

    buildRequest(url, headers = {}, method = 'GET', body = {}) {
        let uri = this.getUrl(url);

        if (['POST', 'PUT'].indexOf(method) + 1) {
            headers = Object.assign(headers, { 'Content-Type': 'application/json' });
            body = JSON.stringify(body);
        }

        return this.fetch(uri, {
            headers: this.getHeaders(headers),
            method: method,
            body: body,
            credentials: 'include'
        });
    }

    post(url, body, headers) {
        return this.buildRequest(url, headers, 'POST', body);
    }

    get(url, body = {}, headers = {}) {
        body = Object.keys(body).map(function (key) {
            return key + "=" + encodeURIComponent(body[key]); 
        }).join("&");
        // solved issue https://github.com/github/fetch/issues/402
        return this.buildRequest(`${url}?${body}`, headers, 'GET', null);
    }

    put(url, body, headers) {
        return this.buildRequest(url, headers, 'PUT', body);
    }

}

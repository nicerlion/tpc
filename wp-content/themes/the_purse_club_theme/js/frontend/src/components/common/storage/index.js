/**
*
*  Base64 encode / decode
*  http://www.webtoolkit.info/
*
**/

const _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";


class Base64 {

    // public method for encoding
    static encode (input) {
        let output = "";
        let chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        let i = 0;

        input = Base64._utf8_encode(input);

        while (i < input.length) {

            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output = output +
                _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
                _keyStr.charAt(enc3) + _keyStr.charAt(enc4);

        }

        return output;
    }

    // public method for decoding
    static decode (input) {
        let output = "";
        let chr1, chr2, chr3;
        let enc1, enc2, enc3, enc4;
        let i = 0;

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {

            enc1 = _keyStr.indexOf(input.charAt(i++));
            enc2 = _keyStr.indexOf(input.charAt(i++));
            enc3 = _keyStr.indexOf(input.charAt(i++));
            enc4 = _keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output = output + String.fromCharCode(chr1);

            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }

        }

        output = Base64._utf8_decode(output);

        return output;

    }

    // private method for UTF-8 encoding
    static _utf8_encode (string) {
        string = string.replace(/\r\n/g, "\n");
        let utftext = "";

        for (let n = 0; n < string.length; n++) {

            let c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if ((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    }

    // private method for UTF-8 decoding
    static _utf8_decode (utftext) {
        let string = "";
        let i = 0;
        let { c, c1, c2 } = 0;

        while (i < utftext.length) {

            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if ((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i + 1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i + 1);
                let c3 = utftext.charCodeAt(i + 2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }

        return string;
    }

}


export default class TPCStorage {

    *[Symbol.iterator]() {
        for (let field of Object.keys(this._getStorage(false))) {
            let value = !field.startsWith(window.wpReactSettings.userEmail) ? field: this.getDecode(field);
            if (!value) continue;
            yield value;
        }
    }

    _getStorage(_forceSession) {
        if (!window.wpReactSettings.userEmail || _forceSession) {
            return window.sessionStorage;
        }
        return window.localStorage;
    }

    getEncode(key) {
        // return Base64.encode(window.wpReactSettings.userEmail.concat(`:${key}`));
        return window.wpReactSettings.userEmail.concat(`:${key}`);
    }

    getDecode(key) {
        // return key ? Base64.decode(key).split(':')[1]: undefined;
        return key ? key.split(':')[1]: undefined;
    }

    setItem(key, value, _forceSession=false) {
        let storage = this._getStorage(_forceSession);
        if (!window.wpReactSettings.userEmail) {
            storage.setItem(key, value);
        } else {
            storage.setItem(this.getEncode(key), this.getEncode(value));
        }
    }

    getItem(key, _default='', _forceSession=false) {
        let storage = this._getStorage(_forceSession);
        if (!window.wpReactSettings.userEmail) {
            return storage.getItem(key) || _default;
        } else if (_forceSession) {
            return this.getDecode(storage.getItem(this.getEncode(key))) || _default;
        }
        return this.getDecode(storage.getItem(this.getEncode(key))) || _default;
    }

    removeItem(key, _forceSession=false) {
        let storage = this._getStorage(_forceSession);
        if (!window.wpReactSettings.userEmail) {
            storage.removeItem(key);
        } else {
            storage.removeItem(this.getEncode(key));
        }
    }

    hasItem(key, _forceSession=false) {
        let storage = this._getStorage(_forceSession);
        if (!window.wpReactSettings.userEmail) {
            return key in storage;
        }
        return this.getEncode(key) in storage;
    }
}
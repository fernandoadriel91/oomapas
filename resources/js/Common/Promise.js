"use strict;"

var _tPromise = function(_Util){

    function _isPromise(value) {
        if (value === undefined || (typeof value === 'object' && typeof value.then !== "function")) {
            return false;
        }
        var promiseThenSrc = String($.Deferred().then);
        var valueThenSrc = String(value.then);
        return promiseThenSrc === valueThenSrc;
    }

    /**
     * Creates a $.post promise with the given parameters
     * 
     * @param {string} url Url of the backend webservice
     * @param {Object|boolean} params Parameters of the request or 
     * @param {Function} callback callback to be called when the request resolves
     * @returns {Promise}
     */
    function _promise(url, params, callback) {
        if ($.type(params) === "function" || (params === undefined && callback === undefined))
            return $.get(url, params);
        else if (typeof params === "object")
            return $.post(url, params, callback);
        else
            console.warning("Invalid Arguments");
    }
    /**
     * Takes promises as arguments and returns a promise that resolves
     * when every request in the arguments is resolved
     * 
     * @param {Promise} args 
     * @returns {Promise}
     */
    function _synchronize() {
        var args = Array.prototype.slice.call(arguments);
        return $.when.apply(undefined, args);
    }


    _Util.isPromise = _isPromise;
    _Util.promise = _promise;
    _Util.sync = _synchronize;

    return _Util;

}(_tUtil || {});
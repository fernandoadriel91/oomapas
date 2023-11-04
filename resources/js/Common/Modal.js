"use strict;"

var _tModal = function(_Validation) {
    /**
     * Creates and shows a modal, 
     * returns a promise as response
     * 
     * @param {Object} el The element where the modal will be appended
     * @param {string} url The view url
     * @param {Object|null} options Mustache parameters
     * @returns {function} 
     */
    function modal(el, url) {
        _Validation.blockPage();
        el.off();
        return $.get(url).then(function(view) {
            el.html(view);
            _Validation.unBlockPage();
            el.modal();
            el.on('hidden.bs.modal', function() {
                el.html('');
            });
        });
    }
    _Validation.modal = modal;
    return _Validation;
}(_tValidate || {});
"use strict;"

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.fn.extend({
    animateCss: function(animationName, callback) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
            if (callback) {
                callback();
            }
        });
        return this;
    }
});
$.validator.addMethod("equals", function(value, element, string) {
    if(!value)
        return true;
    return $.inArray(value, string) !== -1;
    
}, $.validator.format("Please enter '{0}'"));
jQuery.extend(jQuery.validator.messages, {
    required: "Este campo es requerido.",
    email: "Por favor ingrese un correo valido.",
    url: "Por favor ingrese un URL valido.",
    date: "Por favor ingrese una fecha valida.",
    number: "Por favor ingrese un numero valido.",
    digits: "Solo se permiten numeros en este campo.",
    equalTo: "Los valores ingresados no coinciden.",
    maxlength: jQuery.validator.format("Por favor ingrese menos de {0} caracteres."),
    minlength: jQuery.validator.format("Por favor ingrese al menos {0} caracteres."),
    rangelength: jQuery.validator.format("Por favor ingrese un valor de entre {0} y {1} caracteres."),
    range: jQuery.validator.format("Por favor ingrese un valor entre {0} y {1}."),
    max: jQuery.validator.format("Por favor ingrese un valor igual o menos a {0}."),
    min: jQuery.validator.format("Por favor ingrese un valor igual o mayor a {0}."),
    pwspecial: "Validación de contraseña, debe incluir al menos un caracter especial de los siguientes =!\-@._#",
    pwlowercase: "Validación de contraseña, debe incluir al menos un carácter en minuscula",
    pwuppercase: "Validación de contraseña, debe incluir al menos un carácter en mayúscula",
    pwdigit: "Validación de contraseña, debe incluir al menos un numero"
});
$.validator.addMethod("pwspecial", function(value) {
    return /^[A-Za-z0-9\d=!\-@._#*]*$/.test(value) // consists of only these
        && /[=!\-@._#]/.test(value) // has a special character
 });
 
 $.validator.addMethod("pwlowercase", function(value) {
    return /^[A-Za-z0-9\d=!\-@._#*]*$/.test(value) // consists of only these
        && /[a-z]/.test(value) // has a lowercase letter
 });
 $.validator.addMethod("pwuppercase", function(value) {
    return /^[A-Za-z0-9\d=!\-@._#*]*$/.test(value) // consists of only these
        && /[A-Z]/.test(value) // has a uppercase letter
 });
 $.validator.addMethod("pwdigit", function(value) {
    return /^[A-Za-z0-9\d=!\-@._#*]*$/.test(value) // consists of only these
        && /\d/.test(value) // has a digit
 });

var _tValidate = function(_Promise) {
    /**
     * Creates a Jquery.validate element with the given rules
     * 
     * @param {Object} form Form element
     * @param {Object} rules Json object with the Jquery.validate rules https://jqueryvalidation.org/rules/
     * @param {Function} valid a function that MUST return a promise, will be called  on submit
     * @param {function} reset a function that will be called after the valid function
     * @param {Object} customMessages Json object with required custom messages for the fields
     */
    function _Validator(form, config, reset) {
        var f = form.validate({
            rules: config.rules != undefined ? config.rules : {},
            messages: config.customMessages != undefined ? config.customMessages : {},
            submitHandler: function(f) {
                f = $(f);
                _Promise.blockElement('#' + f.attr('id') + ' [type="submit"]');
                f.find('[type="submit"]').prop('disabled', true);

                var p = f.ajaxSubmit({
                    url: typeof config.url === "function" ? config.url() : config.url,
                    method: config.method != undefined ? config.method : 'POST',
                    data: config.method,
                    success: config.success,
                    error: config.error
                }).data('jqxhr');
                p.always(function() {
                    _Promise.unblockElement('#' + form.attr('id') + ' [type="submit"]');
                    form.find('[type="submit"]').prop('disabled', false);
                    if (reset != false) {
                        form[0].reset();
                        form.find(".select2-hidden-accessible").each(function(e, v) {
                            $(v).val('').trigger('change');
                        });
                    }
                    if (reset != false && reset != undefined)
                        reset();
                });
            },
            errorElement: "div",
            errorClass: "form-control-feedback",
            errorPlacement: function(error, element) {
                var cont = $(element).parents('.m-radio-inline, .m-select2, .r-pill, .input-group');
                if (cont.length > 0) {
                    cont.after(error);
                } else {
                    element.after(error);
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-danger');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-danger');
            },
            success: function(element) {
                element.closest('.form-group').removeClass('has-danger');
                element.remove();
            }
        });

        form.find('button[type="reset"]').on('click', function() {
            form[0].reset();
            form.validate().resetForm();
            form.find(".select2-hidden-accessible").each(function(e, v) {
                $(v).val('').trigger('change');
            });
            if (reset != undefined)
                reset();
        });
        return f;
    }

    /**
     * Creates a Jquery.validate element with the given rules
     * 
     * @param {Object} form Form element
     * @param {Object} rules Json object with the Jquery.validate rules https://jqueryvalidation.org/rules/
     * @param {Function} valid a function that MUST return a promise, will be called  on submit
     * @param {function} reset a function that will be called after the valid function
     * @param {Object} customMessages Json object with required custom messages for the fields
     */
    function _ValidatorCaptcha(form, config, reset) {
        var f = form.validate({
            rules: config.rules != undefined ? config.rules : {},
            messages: config.customMessages != undefined ? config.customMessages : {},
            submitHandler: function(f) {
                f = $(f);
                _Promise.blockElement('#' + f.attr('id') + ' [type="submit"]');
                f.find('[type="submit"]').prop('disabled', true);

                
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LeypRkiAAAAAFFC2ZZaltcvXE-G2rQTBlJKHk53', {action: 'login'}).then(function(token) {
                        if(token) {
                            $('[name="recaptcha"]').val(token);
                        }
                        var p = f.ajaxSubmit({
                            url: typeof config.url === "function" ? config.url() : config.url,
                            method: config.method != undefined ? config.method : 'POST',
                            data: config.method,
                            success: config.success,
                            error: config.error
                        }).data('jqxhr');

                        p.always(function() {
                            _Promise.unblockElement('#' + form.attr('id') + ' [type="submit"]');
                            form.find('[type="submit"]').prop('disabled', false);
                            if (reset != false) {
                                form[0].reset();
                                form.find(".select2-hidden-accessible").each(function(e, v) {
                                    $(v).val('').trigger('change');
                                });
                            }
                            if (reset != false && reset != undefined)
                                reset();
                        });
                    });
                });
                
            },
            errorElement: "div",
            errorClass: "form-control-feedback",
            errorPlacement: function(error, element) {
                var cont = $(element).parents('.m-radio-inline, .m-select2, .r-pill, .input-group');
                if (cont.length > 0) {
                    cont.after(error);
                } else {
                    element.after(error);
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-danger');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-danger');
            },
            success: function(element) {
                element.closest('.form-group').removeClass('has-danger');
                element.remove();
            }
        });

        form.find('button[type="reset"]').on('click', function() {
            form[0].reset();
            form.validate().resetForm();
            form.find(".select2-hidden-accessible").each(function(e, v) {
                $(v).val('').trigger('change');
            });
            if (reset != undefined)
                reset();
        });
        return f;
    }

    _Promise.validator = _Validator;
    _Promise.validatorCaptcha = _ValidatorCaptcha;
    return _Promise;
}(_tPromise || {});
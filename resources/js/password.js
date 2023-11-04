var Password = function() {

    function setupForm() {
        var conf = {
            url: 'renew',
            success: passwordChanged,
            error: function(e){
                Common.error('Error!', e.responseJSON.Error, true);
            },
            rules: {
                password: {
                    required: true,
                    pwlowercase: true,
                    pwuppercase: true,
                    pwspecial: true,
                    pwdigit: true,
                    minlength: 8
                },
                confirm: {
                    equalTo: "#password_input"
                }
            }
        };
        Common.validator($("#submitForm"), conf);
    }

    function passwordChanged() {
        window.location.replace('/admin/');
    }

    return {
        init: function() {
            setupForm();
        }
    }
}();

$(document).ready(function() {
    Password.init();
});
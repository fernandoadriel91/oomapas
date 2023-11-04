var Login = function() {

    function setupLogin() {
        var config = {
            url: 'login',
            success: LoginSuccess,
            error: LoginFail,
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                }
            }
        };
        Common.validator($("#loginForm"), config);
    }

    function LoginSuccess() {
        window.location.replace('/admin/');
    }

    function LoginFail(response) {
        Common.error("Error!", response.responseJSON.msg);
    }

    return {
        init: function() {
            $("[app-name]").text('Iniciar Sesión');
            setupLogin();
        }
    }
}();

$(document).ready(function() {
    Login.init();
});
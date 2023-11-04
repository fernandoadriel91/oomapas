<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>
        {{env('APP_NAME')}}
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Titillium Web:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link href="assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/theme/base/style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="assets/theme/media/img/logo/favicon.ico" />
</head>
<!-- end::Head -->
<!-- end::Body -->

<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile 		m-login m-login--1 m-login--signin" id="m_login">
            <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
                <div class="m-stack m-stack--hor m-stack--desktop">
                    <div class="m-stack__item m-stack__item--fluid">
                        <div class="m-login__wrapper">
                            <div class="m-login__logo">
                                <a href="#">
                                    <img width="100" src="/assets/app/media/img//logos/logo-2.png">
                                </a>
                            </div>
                            <div class="m-login__signin">
                                <div class="m-login__head">
                                    <h3 class="m-login__title">
                                        Inicia Sesión
                                    </h3>
                                </div>
                                <form class="m-login__form m-form" id="login-form" action="POST">
                                    @csrf
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input" type="text" placeholder="Correo" name="email" autocomplete="off">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Contraseña" name="password">
                                    </div>
                                    <div class="row m-login__form-sub">
                                        <div class="col m--align-right">
                                            <a href="javascript:;" id="m_login_forget_password" class="m-link">
													¿Olvidaste tu contraseña?
												</a>
                                        </div>
                                    </div>
                                    <div class="m-login__form-action">
                                        <button type="submit" id="m_login_signin_submit" class="btn btn-outline-brand m-btn m-btn--pill m-btn--custom m-btn--air">
												Ingresar
											</button>
                                    </div>
                                </form>
                            </div>
                            <div class="m-login__forget-password">
                                <div class="m-login__head">
                                    <h3 class="m-login__title">
                                        Recuperación de Contraseña
                                    </h3>
                                    <div class="m-login__desc">
                                        Ingresa tu correo para iniciar la recuperación:
                                    </div>
                                </div>
                                <form class="m-login__form m-form" id="pswRecovery">
                                    @csrf
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input" type="text" placeholder="Correo" name="email" id="m_email" autocomplete="off">
                                    </div>
                                    <div class="m-login__form-action">
                                        <button type="submit" id="m_login_forget_password_submit" class="btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--air">
												Recuperar
											</button>
                                        <button id="m_login_forget_password_cancel" class="btn btn-outline-danger m-btn m-btn--pill m-btn--custom">
												Cancelar
											</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content" style="background-image: url(/assets/app/media/img//bg/bg-4.jpg)">
                <div class="m-grid__item m-grid__item--middle">
                    <h3 class="m-login__welcome">
                        Lorem Ipsum
                    </h3>
                    <p class="m-login__msg">
                        Dolor
                        <br> elit sed diam nonummy et nibh euismod
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="assets/theme/base/scripts.bundle.js" type="text/javascript"></script>
    <script src="assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/router.js" type="text/javascript"></script>
    <script src="/js/controllers.js" type="text/javascript"></script>
    <script src="/js/app.js" type="text/javascript"></script>
</body>
<!-- end::Body -->

</html>
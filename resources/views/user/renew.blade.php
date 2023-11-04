<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <title>Cambio de Contraseña</title>
    <style>
        html {
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .m-footer--push.m-aside-left--enabled:not(.m-footer--fixed) .m-footer {
            margin-left: 0 !important;
        }

    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
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
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link href="/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/theme/base/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
    <link href="/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ mix('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="/assets/theme/media/img/logo/favicon.ico" />
    
    <!-- Custom Runtime CSS -->
    <link id="plugins_before">
    <link id="plugins_after">
</head>

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    <div class="m-grid m-grid--hor m-grid--root m-page">
        @include('layout.header')
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                <div class="m-subheader breadcrumbs">
                </div>
                <div class="m-content">
                    @component('components.portlet', ['form'=>'submitForm', 'open'=>true, 'toggle'=>false, 'size' =>
                    'col-sm-6 offset-sm-3', 'icon' => 'la la-lock' ])
                        @slot('title')
                        Cambiar contraseña
                        @endslot
                        <h2 class="m--margin-bottom-30">{{ $message }}</h2>
                        @method('PUT')
                        @include('user.password')
                        @slot('buttons')
                        <button type="submit" id="save" class="btn btn-brand pull-right " style="margin-left: 15px; ">
                            Guardar
                        </button>
                        @endslot
                    @endcomponent
                </div>
            </div>
        </div>
        <footer class="m-grid__item		m-footer ">
            <div class="m-container m-container--fluid m-container--full-height m-page__container">
                <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                    <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                        <span class="m-footer__copyright">
                            <span class="year">{{ env('APP_YEAR') }}</span> &copy; <span class="app-name">{{ env('APP_NAME') }}</span> por
                            <a href="" class="m-link author" target="_blank">
                                {{ env('APP_AUTHOR') }}
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <script src="/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="/assets/theme/base/scripts.bundle.js" type="text/javascript"></script>
    <script src="/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    <script src="{{ mix('/js/dependencies.js') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/common.js') }}" type="text/javascript"></script>
    <script src="/js/password.js" type="text/javascript"></script>
</body>

</html>

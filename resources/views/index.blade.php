<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <title app-name></title>
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

<body class="hide m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    <div class="m-grid m-grid--hor m-grid--root m-page">
        @include('layout.header')
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
            @include('layout.menu')
            @include('layout.content')
        </div>
        @include('layout.footer')
    </div>
    
    <div id="m_scroll_top" class="m-scroll-top">
        <i class="la la-arrow-up"></i>
    </div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
    </div>
    <script src="/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="/assets/theme/base/scripts.bundle.js" type="text/javascript"></script>
    <script src="/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    <script src="{{ mix('/js/dependencies.js') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/common.js') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/router.js') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/app.js') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/controllers.js') }}" type="text/javascript"></script>
</body>

</html>

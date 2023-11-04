const mix = require('laravel-mix');
mix
    .copyDirectory('resources/css/views/', 'public/css/')
    .styles([
        'node_modules/politespace/dist/politespace.css',
        'node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css'
    ], 'public/css/all.css')
    .scripts([
        'node_modules/jquery-ui/ui/jquery-1-7.js',
        'node_modules/jquery-ui/ui/data.js',
        'node_modules/jquery-ui/ui/scroll-parent.js',
        'node_modules/jquery-ui/ui/widget.js',
        'node_modules/jquery-ui/ui/widgets/mouse.js',
        'node_modules/jquery-ui/ui/widgets/sortable.js',
        'node_modules/nestedSortable/jquery.mjs.nestedSortable.js',
        'node_modules/politespace/dist/politespace.js',
        'resources/js/Common/serializeObject/serializeObject.js',
        'node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js'
    ], 'public/js/dependencies.js')
    .scripts([
        'resources/js/Common/palette.js',
        'resources/js/Common/Util.js',
        'resources/js/Common/Promise.js',
        'resources/js/Common/Validation.js',
        'resources/js/Common/Modal.js',
        'resources/js/Common/Datatable.js',
        'resources/js/Common/Common.js'
    ], 'public/js/common.js')
    // Router Files
    .scripts([
        'node_modules/rsvp/dist/rsvp.min.js',
        'node_modules/signals/dist/signals.min.js',
        'node_modules/route-recognizer/dist/route-recognizer.js',
        'node_modules/router_js/dist/router.min.js',
        'node_modules/hasher/dist/js/hasher.min.js',
        'resources/js/Router/AppRouter.js',
        'resources/js/Router/Config.js'
    ], 'public/js/router.js')
    .scripts('resources/js/Controllers', 'public/js/controllers.js');
"use strict;"

$(document).ready(function() {
    AppRouter
        .setApp({
            name: "OOMAPAS",
            author: "Gobierno Municipal de Nogales",
            url: "https://heroicanogales.gob.mx",
            year: "2021-2024"
        })
        .state('valve', {
            url: '/Valvulas',
            title: 'Valvulas',
            viewUrl: '/admin/valve',
            Controller: 'Valve'
        })
        .state('leak', {
            url: '/Fugas',
            title: 'Fugas',
            viewUrl: '/admin/leak',
            Controller: 'Leak'
        })
        .state('pipe', {
            url: '/Pipas',
            title: 'Pipas',
            viewUrl: '/admin/pipe',
            Controller: 'Pipe'
        })
        .state('capture', {
            url: '/Capturar',
            title: 'Capturar',
            viewUrl: '/admin/capture',
            Controller: 'Capture'
        });


    // INITIALIZE APP
    $.get('/admin/defaultState')
        .then(function(r) {
            AppRouter.setDefaultState(r);
            Common.init();
            AppRouter.init();
        });

    $("#change_password").on('click', function() {
        Users.changePassword();
    });
});
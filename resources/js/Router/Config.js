"use strict;"
$(document).ready(function() {
    AppRouter
        .setDefaultOptions({
            dependencies: {
                options: {
                    insertAfter: "#plugins_after",
                    insertBefore: "#plugins_before"
                }
            }
        })
        .setHandleViewError(function() {
            $.get('/admin/checksession')
                .done(function(e) {
                    if(!e.auth)
                        window.location = '/';
                })
                .fail(function() {
                    window.location = '/';
                });
        })
        .setNotFound({
            viewUrl: '/admin/notfound'
        })
        .setBeforeChange(function() {
            Common.blockPage();
            var d1 = $.Deferred();
            Common.destroyPortlets();
            $("body").removeClass('hide');
            d1.resolve(true);
            return d1;
        })
        .setAfterChange(function(hash){
            Common.handleChanges(hash);
            Common.activeMenu();
            Common.unBlockPage();
        })
        .setOnChange(function() {
            Common.initPortlets();
        })
        .state('permission', {
            url: '/Permisos',
            title: 'Permisos',
            viewUrl: '/admin/permission',
            Controller: 'Permisos',
            dependencies: {
                css: [
                    "/css/permisos.css"
                ]
            }
        })
        .state('role', {
            url: '/Roles',
            title: 'Roles',
            viewUrl: '/admin/role',
            Controller: 'Roles',
            dependencies: {
                css: [
                    "/css/roles.css"
                ]
            }
        })
        .state('users', {
            url: '/Usuarios',
            title: 'Usuarios',
            viewUrl: '/admin/user',
            Controller: 'Users'
        })
        .state('dependency', {
            url: '/Dependencias',
            title: 'Dependencias',
            viewUrl: '/admin/dependency',
            Controller: 'Dependencies'
        })
        .state('department', {
            url: '/Departamentos',
            title: 'Departamentos',
            viewUrl: '/admin/department',
            Controller: 'Departments'
        });
});
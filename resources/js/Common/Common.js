"use strict;"

var Common = function(_Datatable) {

    function _initLayout() {
        Common.initPortlets();
        var appdata = AppRouter.getApp();
        $(".m-footer__copyright .year").html(appdata.year);
        $(".m-footer__copyright .app-name").html(appdata.name);
        $(".m-footer__copyright .author").html(appdata.author);
        $(".m-footer__copyright .author").attr('href', appdata.url);
        moment.locale('es');
    }

    function getBreadcrumbs(item) {
        var breadcrumbs = [];
        var item = $(item);
        var link = item.children('.m-menu__link');

        breadcrumbs.push({
            text: link.find('.m-menu__link-text').html(),
            title: link.attr('title'),
            href: link.attr('href')
        });

        item.parents('.m-menu__item--submenu').each(function() {
            var submenuLink = $(this).children('.m-menu__link');
            breadcrumbs.push({
                text: submenuLink.find('.m-menu__link-text').html(),
                title: submenuLink.attr('title'),
                href: submenuLink.attr('href')
            });
        });

        return breadcrumbs.reverse();
    }

    function handleChanges(hash) {
        var state_params = AppRouter.getStateParams();
        if(state_params != undefined && state_params.params != undefined && state_params.params.baseUrl != undefined)
            hash = state_params.params.baseUrl;
        var filtered = $("li.m-menu__item a").filter(function() {
            var href = $(this).attr('href').toLowerCase();
            return href.indexOf(hash.toLowerCase()) > -1 && href.length - hash.length < 3;
        });
        var raw = getBreadcrumbs(filtered.parent());
        var breadcrumbs = { title: AppRouter.getStateParams().title, breadcrumbs: [] };
        $.each(raw, function(i, v) {
            if (v.text != undefined)
                breadcrumbs.breadcrumbs.push({ breadcrumb: v.text.trim() })
        });
        $.post('/admin/breadcrumbs', { data: breadcrumbs }).then(function(template) {
            renderBreadCrumbs(breadcrumbs.title, template);
        });
    }

    function renderBreadCrumbs(title, template) {
        $(".m-subheader.breadcrumbs").html(template);
        $("[app-name]").text(AppRouter.getApp().name + ' | ' + title);
    }
    _Datatable.handleChanges = handleChanges;
    _Datatable.init = _initLayout;
    return _Datatable;
}(_tDatatable || {});
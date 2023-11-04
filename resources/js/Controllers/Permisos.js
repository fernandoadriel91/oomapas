"use strict;"

var Permisos = function() {
    var ol;

    function editar(form) {
        Common.success('Aviso', 'Registro actualizado Satisfactoriamente');
        prepareMenuBuilder();
    }

    function deletePermission() {
        Common
            .confirm({
                title: "¿Seguro que deseas eliminar este registro?",
                text: "No habrá manera de revertir esta acción",
                confirmText: "Si, Elimínalo",
                confirm: permissionDeleted,
                extras: $(this).data('id')
            });
    }

    function permissionDeleted(id) {
        $.ajax({
            url: '/admin/permission/' + id,
            method: 'POST',
            data: { _token: $("[name='_token']").val(), _method: 'DELETE' },
            dataType: 'json',
            success: function(e) {
                Common.success('Aviso', 'Registro Eliminado Satisfactoriamente');
                prepareMenuBuilder();
            },
            error: Common.eHandler
        });
    }

    function editPermission(e) {
        var target = $(e.delegateTarget).parent().siblings('form');
        $("[name*='editForm_']").not("[name*='" + target.attr('name') + "']").slideUp(300);
        $("[name*='editForm_']").not("[name*='" + target.attr('name') + "']").data('validator', null);
        $("[name*='editForm_']").not("[name*='" + target.attr('name') + "']").unbind('validate');
        target.slideToggle(300);
        $("[name*='editForm_'] [name*='icon_']").each(function() {
            if ($(this).hasClass("select2-hidden-accessible"))
                $(this).select2('destroy');
        });
        var id = target.find('[name="id_menu"]').val();
        setupEvents($(target), editar, '/admin/permission/' + id);
    }

    function menuChange() {
        vid = $(this).data('id');
        $.ajax({
            url: '/admin/permission/priority',
            dataType: 'json',
            method: 'POST',
            data: { _method: 'PUT', _token: $("[name='_token']").val(), _method: 'PUT', menu: ol.nestedSortable('toHierarchy') },
            success: function(e) {
                prepareMenuBuilder();
            },
            error: Common.eHandler
        });
    }

    function prepareMenuBuilder() {
        $.get('/admin/permission/menu_builder')
            .then(function(e) {
                $('#menu_builder').html(e);
            })
            .then(initMenuBuilder);
    }

    function initMenuBuilder() {
        ol = $('ol.sortable').nestedSortable({
            forcePlaceholderSize: true,
            handle: 'div.handle',
            helper: 'clone',
            items: 'li.item',
            opacity: .6,
            isTree: true,
            errorClass: 'placeholder-error',
            placeholder: 'placeholder',
            tabSize: 15,
            tolerance: 'pointer',
            toleranceElement: '> div',
            maxLevels: 3,
            excludeRoot: true,
            expandOnHover: 700,
            startCollapsed: false,
            isAllowed: function(item, parent, sorted) {
                if (sorted.attr("data-type") != 0) {
                    if (sorted.attr("data-type") == 3 && parent != undefined)
                        return false;
                    if (parent != undefined && parent.attr("data-type") == 0)
                        return false;
                    return true;
                } else if (sorted.attr("data-type") == 0 && parent == undefined)
                    return true;
                return false;
            },
            relocate: menuChange
        });
        $('.m-portlet__head-tools').on('click', '.disclose', function() {
            $(this).parent().parent().parent().closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
            $(this).children('i').toggleClass('la-angle-down').toggleClass('la-angle-up');
        });
        $('.m-portlet__head-tools').on('click', '.delete', deletePermission);
        $('.m-portlet__head-tools').on('click', '.edit', editPermission);
    }

    function setupEvents(form, handler, url) {
        form.find("[name='icon']").select2({
            minimumInputLength: 2,
            language: "es",
            ajax: {
                url: "/admin/permission/icons",
                dataType: "json",
                delay: 250,
                type: "GET",
                data: function(params) {
                    var queryParameters = {
                        query: params.term
                    }
                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            },
            templateResult: format,
            templateSelection: format
        });

        var config = {
            url: url,
            success: handler,
            error: Common.eHander,
            rules: {
                menu: {
                    required: true,
                    range: [0, 3]
                },
                title: {
                    required: true
                },
                route: {
                    required: '#type_menu:checked'
                },
                icon: {
                    required: '#type_menu:checked'
                }
            }
        };
        Common.validator(form, config);
    }

    function createSuccess() {
        Common.success('Aviso', 'Registro Exitoso');
        prepareMenuBuilder();
    }

    function format(item) {
        return $('<div><i style="margin-right: 12px; " class=" ' + item.id + ' "></i>' + item.text + '</div>');
    }

    return {
        init: function() {
            prepareMenuBuilder();
            setupEvents($("#submitForm"), createSuccess, '/admin/permission');
        }
    }
}();
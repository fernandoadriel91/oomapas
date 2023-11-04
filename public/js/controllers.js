"use strict;"

var Departments = function() {
    var table;

    function get() {
        var coldefs = [{
                data: 'id',
                title: '#'
            }, {
                data: 'name',
                title: 'Departamento'
            }, {
                data: 'dependency.name',
                title: 'Dependencia'
            }, {
                data: 'created_at',
                title: 'Creado',
                render: Common.dateFormat
            }, {
                data: 'updated_at',
                title: 'Actualizado',
                render: Common.dateFormat
            },
            {
                data: 'p',
                title: 'Acciones',
                render: Common.tableActions
            }
        ];
        table = Common.remoteTable($('#table'), '/admin/department/datatable', coldefs);
        table.on('click', '[data-action="edit"]', edit);
        table.on('click', '[data-action="delete"]', destroy);
        var porlet = new mPortlet('portlet_1');
        porlet.on('reload', function(){
            table.ajax.reload();
        });
    }

    function created() {
        Common.success("Departamento registrado con exito.");
        $('#table').find('a').tooltip('dispose');
        table.ajax.reload();
    }

    function edit() {
        var id = $(this).data('id');
        Common.modal($("#modal"), '/admin/department/' + id + '/edit')
            .then(function() {
                var config = {
                    url: '/admin/department/' + id,
                    success: updated,
                    error: Common.eHandler,
                    rules: {
                        name: {
                            required: true
                        },
                        dependency_id: {
                            required: true
                        }
                    }
                };
                getDependencies($("#modal form"));
                $("#modal").on('hidden.bs.modal', function(){
                    getDependencies($("#submitForm"));
                });
                Common.validator($("#modal form"), config);
            });
    }

    function updated() {
        Common.success("Departamento actualizado con exito.");
        $('#modal').modal('hide');
        $('#table').find('a').tooltip('dispose');
        table.ajax.reload();
    }

    function destroy() {
        Common.confirm({
            title: "¿Seguro que deseas eliminar este registro?",
            text: "No habrá manera de revertir esta acción",
            confirmText: "Si, Elimínalo",
            confirm: deleted,
            extras: $(this).data('id')
        });
    }

    function deleted(id) {
        $.ajax({
            url: '/admin/department/' + id,
            method: 'POST',
            data: {
                _token: $("[name='_token']").val(),
                _method: 'DELETE'
            },
            dataType: 'json',
            success: function(e) {
                Common.success('Aviso', 'Registro Eliminado Satisfactoriamente');
                table.ajax.reload();
            },
            error: Common.eHandler
        });
    }

    function getDependencies(el) {
        return $.get('/admin/department/dependencies', function(e) {
            if (e.data || !e.error) {
                el.find("#dependency_id_input").select2({
                    language: "es",
                    width: '100%',
                    allowClear: true,
                    placeholder: 'Seleccione una dependencia',
                    data: $.map(e.data, function(e) {
                        e.text = e.name;
                        return e;
                    })
                });
            } else if (e.error) {
                Common.error("Error!", e.r);
            }
        });
    }

    return {
        init: function() {
            var config = {
                url: '/admin/department',
                success: created,
                error: Common.eHandler,
                rules: {
                    name: {
                        required: true
                    },
                    attendant: {
                        required: true
                    },
                    dependency_id: {
                        required: true
                    }
                }
            };
            Common.validator($("#submitForm"), config);
            get();
            getDependencies($("#submitForm"));
        }
    };
}();
"use strict;"

var Dependencies = function() {
    var table;

    function get() {
        var coldefs = [{
                data: 'id',
                title: '#'
            }, {
                data: 'name',
                title: 'Dependencia'
            }, {
                data: 'created_at',
                title: 'Creado',
                render: Common.dateFormat
            }, {
                data: 'updated_at',
                title: 'Actualizado',
                render: Common.dateFormat
            },
            {
                data: 'p',
                title: 'Acciones',
                render: Common.tableActions
            }
        ];
        table = Common.remoteTable($('#table'), '/admin/dependency/datatable', coldefs);
        table.on('click', '[data-action="edit"]', edit);
        table.on('click', '[data-action="delete"]', destroy);
        var porlet = new mPortlet('portlet_1');
        porlet.on('reload', function(){
            table.ajax.reload();
        });
    }

    function created() {
        Common.success("Dependencia registrado con exito.");
        $('#table').find('a').tooltip('dispose');
        table.ajax.reload();
    }

    function edit() {
        var id = $(this).data('id');
        Common.modal($("#modal"), '/admin/dependency/' + id + '/edit')
            .then(function() {
                var config = {
                    url: '/admin/dependency/' + id,
                    success: updated,
                    error: Common.eHandler,
                    rules: {
                        name: {
                            required: true
                        },
                        attendant: {
                            required: true
                        }
                    }
                };
                Common.validator($("#modal form"), config);
            });
    }

    function updated() {
        Common.success("Dependencia actualizado con exito.");
        $('#modal').modal('hide');
        $('#table').find('a').tooltip('dispose');
        table.ajax.reload();
    }

    function destroy() {
        Common.confirm({
            title: "¿Seguro que deseas eliminar este registro?",
            text: "No habrá manera de revertir esta acción",
            confirmText: "Si, Elimínalo",
            confirm: deleted,
            extras: $(this).data('id')
        });
    }

    function deleted(id) {
        $.ajax({
            url: '/admin/dependency/' + id,
            method: 'POST',
            data: {
                _token: $("[name='_token']").val(),
                _method: 'DELETE'
            },
            dataType: 'json',
            success: function(e) {
                Common.success('Aviso', 'Registro Eliminado Satisfactoriamente');
                table.ajax.reload();
            },
            error: Common.eHandler
        });
    }

    return {
        init: function() {
            var config = {
                url: '/admin/dependency',
                success: created,
                error: Common.eHandler,
                rules: {
                    name: {
                        required: true
                    },
                    attendant: {
                        required: true
                    }
                }
            };
            Common.validator($("#submitForm"), config);
            get();
        }
    };
}();
"use strict;"

var Leak = function(){
    var table;
    var config = {
        url: '/admin/leak',
        success: newLeak,
        error: Common.eHandler,
        rules: {
            address: {
                required: true
            }
        }
    };

    function newLeak()
    {
        Common.success('Aviso', 'Registro Actualizado Satisfactoriamente');
        table.ajax.reload();
    }

    function getLeaks()
    {
        var coldefs = [{
                data: 'id',
                title: '#'
            },
            {
                data: 'address',
                title: 'Lugar'
            },
            {
                data: 'street',
                title: 'Entre calles'
            },
            {
                data: 'comment',
                title: 'Comentarios'
            },
            {
                data: 'photo',
                title: 'Foto',
                render: function(data, t, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + data;
                    return '<a id="copy' + row.id + '" href="/' + data + '">' + 'Ver foto' +'</a>';
                }
            },
            {
                data: 'active',
                title: 'Estado',
                render: Common.tableActive
            },
            {
                data: 'p',
                title: 'Acciones',
                render: Common.tableActions
            }
        ];
        table = Common.remoteTable($('#table'), '/admin/leak/datatable', coldefs);
        table.on('click', '[data-action="toggle"]', toggleUser);
        table.on('click', '[data-action="edit"]', editLeak);
        table.on('click', '[data-action="delete"]', deleteLeak);
    }

    function toggleUser() {
        $.ajax({
            url: '/admin/leak/' + $(this).data('id') + '/active',
            method: 'POST',
            data: {
                _token: $("[name='_token']").val(),
                _method: 'PUT'
            },
            dataType: 'json',
            success: function(e) {
                Common.success('Aviso', 'Registro Actualizado Satisfactoriamente');
                $('#table').find('a').tooltip('dispose');
                table.ajax.reload();
            },
            error: Common.eHandler
        });
    }

    function editLeak()
    {
        var id = $(this).data('id');
        Common.modal($("#modal"), '/admin/leak/' + id + '/edit')
            .then(function() {
                config.url = '/admin/leak/' + id;
                config.success = updatedLeak;
                Common.validator($("#modal form"), config);
            });
    }

    function updatedLeak()
    {
        Common.success("Aviso!", "Registro actualizado");
        $('#modal').modal('hide');
        $('#table').find('a').tooltip('dispose');
        table.ajax.reload();
    }

    function deleteLeak()
    {
        Common.confirm({
            title: "¿Seguro que deseas eliminar este registro?",
            text: "No habrá manera de revertir esta acción",
            confirmText: "Si, Elimínalo",
            confirm: leakDeleted,
            extras: $(this).data('id')
        });
    }

    function leakDeleted(id)
    {
        $.ajax({
            url: '/admin/leak/' + id,
            method: 'POST',
            data: {
                _token: $("[name='_token']").val(),
                _method: 'DELETE'
            },
            dataType: 'json',
            success: function(e) {
                Common.success('Aviso', 'Registro Eliminado Satisfactoriamente');
                table.ajax.reload();
            },
            error: Common.eHandler
        });
    }
    return {
        init: function(){
            Common.validator($("#submitForm"), config);
            getLeaks();
            var porlet = new mPortlet('portlet_1');
            porlet.on('reload', function(){
                table.ajax.reload();
            });
        }
    };
}();
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
"use strict;"

var Pipe = function(){
    var table;
    var config = {
        url: '/admin/pipe',
        success: newPipe,
        error: Common.eHandler,
        rules: {
            name: {
                required: true
            },
            address: {
                required: true
            }
        }
    };

    function newPipe()
    {
        Common.success('Aviso', 'Registro Actualizado Satisfactoriamente');
        table.ajax.reload();
    }

    function getPipes()
    {
        var coldefs = [{
                data: 'id',
                title: '#'
            },
            {
                data: 'name',
                title: 'Nombre'
            },
            {
                data: 'telephone',
                title: 'Celular'
            },
            {
                data: 'address',
                title: 'Dirección'
            },
            {
                data: 'contract',
                title: '# Contrato'
            },
            {
                data: 'photo',
                title: 'Recibo',
                render: function(data, t, row) {
                    var getUrl = window.location;
                    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + data;
                    return '<a id="copy' + row.id + '" href="/' + data + '">' + 'Ver recibo' +'</a>';
                }
            },
            {
                data: 'folio',
                title: '# Folio Pipa'
            },
            {
                data: 'comment',
                title: 'Comentarios'
            },
            {
                data: 'active',
                title: 'Estado',
                render: Common.tableActive
            },
            {
                data: 'p',
                title: 'Acciones',
                render: Common.tableActions
            }
        ];
        table = Common.remoteTable($('#table'), '/admin/pipe/datatable', coldefs);
        table.on('click', '[data-action="toggle"]', toggleUser);
        table.on('click', '[data-action="edit"]', editPipe);
        table.on('click', '[data-action="delete"]', deletePipe);
    }

    function formInit() {
        $("#telephone_input").inputmask("mask", {
            mask: "(999) 999-9999",
            placeholder: ""
        });
    }

    function toggleUser() {
        $.ajax({
            url: '/admin/pipe/' + $(this).data('id') + '/active',
            method: 'POST',
            data: {
                _token: $("[name='_token']").val(),
                _method: 'PUT'
            },
            dataType: 'json',
            success: function(e) {
                Common.success('Aviso', 'Registro Actualizado Satisfactoriamente');
                $('#table').find('a').tooltip('dispose');
                table.ajax.reload();
            },
            error: Common.eHandler
        });
    }

    function editPipe()
    {
        var id = $(this).data('id');
        Common.modal($("#modal"), '/admin/pipe/' + id + '/edit')
            .then(function() {
                
                config.url = '/admin/pipe/' + id;
                formInit();
                config.success = updatedPipe;
                Common.validator($("#modal form"), config);
            });
    }

    function updatedPipe()
    {
        Common.success("Aviso!", "Registro actualizado");
        $('#modal').modal('hide');
        $('#table').find('a').tooltip('dispose');
        table.ajax.reload();
    }

    function deletePipe()
    {
        Common.confirm({
            title: "¿Seguro que deseas eliminar este registro?",
            text: "No habrá manera de revertir esta acción",
            confirmText: "Si, Elimínalo",
            confirm: pipeDeleted,
            extras: $(this).data('id')
        });
    }

    function pipeDeleted(id)
    {
        $.ajax({
            url: '/admin/pipe/' + id,
            method: 'POST',
            data: {
                _token: $("[name='_token']").val(),
                _method: 'DELETE'
            },
            dataType: 'json',
            success: function(e) {
                Common.success('Aviso', 'Registro Eliminado Satisfactoriamente');
                table.ajax.reload();
            },
            error: Common.eHandler
        });
    }
    return {
        init: function(){
            Common.validator($("#submitForm"), config);
            getPipes();
            formInit();
            var porlet = new mPortlet('portlet_1');
            porlet.on('reload', function(){
                table.ajax.reload();
            });
        }
    };
}();
"use strict;"
var Roles = function() {
    var table;

    function setEvents(el) {
        el.find('form').find("input[type='checkbox']").on('change', function() {
            var checked = $(this).prop('checked');
            $(this).parent().siblings('div').find("input[type='checkbox']").prop('checked', checked);
            el.find('form').find('.access-panel [name*="permisos["]').each(updatePermisosUI);
        });
        el.find(".access-panel i").tooltip();
        el.find('form').find(".access-panel").popover({
            title: "Permisos",
            html: true,
            content: $("#role_permission").html()
        });
        el.find('form').find(".access-panel").on('show.bs.popover', function() {
            el.find('form').find(".access-panel").popover('hide');
        });
        el.find('form').find(".access-panel").on('shown.bs.popover', function() {
            var popover = $(this);
            var id_pop = popover.attr('aria-describedby');
            popoverPermisos(popover, $("#" + id_pop), el);
        });
        var porlet = new mPortlet('portlet_1');
        porlet.on('reload', function() {
            table.ajax.reload();
        });

    }

    function popoverPermisos(that, pop, el) {
        pop.on('click', '.cancel', function() {
            that.popover('hide');
        });
        pop.on('click', '#all', function() {
            pop.find('[type="checkbox"]').prop('checked', true);
        });
        pop.on('click', '#none', function() {
            pop.find('[type="checkbox"]').prop('checked', false);
        });
        that.find("input[type='hidden']").each(function(key, value) {
            pop.find("[name='menu[" + $(value).attr("id") + "]']").prop('checked', $(value).val() === "true");
        });
        pop.on('click', '.confirm', function() {
            var permisos = pop.find('form').serializeObject();
            that.find("input[type='hidden']").val(false);
            that.siblings('.m-checkbox-parent').each(function() {
                $(this).find('.access-panel').each(function() {
                    var child = $(this).siblings('label').children('input[type="checkbox"]');
                    if (child.prop('checked') || child.prop('indeterminate'))
                        $(this).find("input[type='hidden']").val(false);
                });
            });
            for (key in permisos.menu) {
                that.siblings('.m-checkbox-parent').each(function() {
                    $(this).find('.access-panel').each(function() {
                        var child = $(this).siblings('label').children('input[type="checkbox"]');
                        if (child.prop('checked') || child.prop('indeterminate'))
                            $(this).find("[permission='" + key + "']").val(permisos.menu[key]);
                    });
                });
                that.find("[permission='" + key + "']").val(permisos.menu[key]);
            }
            el.find('form').find('.access-panel [name*="permisos["]').each(updatePermisosUI);
            that.popover('hide');
        });
    }

    function updatePermisosUI() {
        var that = $(this);
        var id = that.attr("permission");
        var val = that.val() === "true" ? true : false;
        var checkbox = that.closest('.access-panel').siblings('.m-checkbox').children('[type="checkbox"]');
        var siblings = that.closest('.access-panel').siblings('.m-checkbox-parent');
        var children = siblings.find("[permission='" + id + "']").length;
        var checked = siblings.find("[permission='" + id + "']" + '[value="true"]').length;

        if (!checkbox.prop('checked') && !checkbox.prop('indeterminate')) {
            that.siblings("[data-for]").removeClass('display');
            that.val(false);
            return;
        }

        if (children > 0 && checked === 0) {
            that.val(false);
            val = false;
        }

        if (val) {
            that.siblings("[data-for='NaN']").removeClass('display');
            that.siblings("[data-for='" + id + "']").addClass('display');
            if (children > 0 && checked != children)
                that.siblings("[data-for='" + id + "']").addClass('partial');
            else
                that.siblings("[data-for='" + id + "']").removeClass('partial');
        } else {
            that.siblings("[data-for='" + id + "']").removeClass('display');
            if (that.siblings("[data-for].display").not("[data-for='NaN']").length === 0)
                that.siblings("[data-for='NaN']").addClass('display');
        }
    }

    function resetPemisos() {
        $(".access-panel .la").removeClass('display');
        $(".access-panel .la").not('.la-lock').removeClass('partial');
        $(".access-panel [type='hidden']").val(false);
    }

    function getRoles() {
        var coldefs = [{
                data: 'id',
                title: '#'
            }, {
                data: 'name',
                title: 'Rol'
            }, {
                data: 'description',
                title: 'Descripcion'
            }, {
                data: 'created_at',
                title: 'Creado',
                className: 'none',
                render: Common.dateFormat
            }, {
                data: 'permissions',
                title: 'Permisos',
                render: function(r) {
                    var render = "";
                    $.each(r, function(i, v) {
                        if (i != 0)
                            render += " - ";
                        title = "";
                        for (var key in v.pivot) {
                            switch (key) {
                                case "C":
                                    if (v.pivot[key] === "1")
                                        title += "<i class='la la-plus'></i>";
                                    break;
                                case "R":
                                    if (v.pivot[key] === "1")
                                        title += "<i class='la la-eye'></i>";
                                    break;
                                case "U":
                                    if (v.pivot[key] === "1")
                                        title += "<i class='la la-edit'></i>";
                                    break;
                                case "D":
                                    if (v.pivot[key] === "1")
                                        title += "<i class='la la-times'></i>";
                                    break;
                                case "admin":
                                    if (v.pivot[key] === "1")
                                        title += "<i class='la la-user-plus'></i>";
                                    break;
                                default:
                                    break;
                            }
                        }
                        render += "<a href='javascript:void(0);' data-html='true' class='m-link' title=\"" + title + "\">" + v.title + "</a>";
                    });
                    return render;
                }
            }, {
                data: 'updated_at',
                title: 'Actualizado',
                render: Common.dateFormat
            },
            {
                data: 'active',
                title: 'Estado',
                render: Common.tableActive
            },
            {
                data: 'p',
                title: 'Acciones',
                className: 'all',
                render: Common.tableActions
            }
        ];
        table = Common.remoteTable($('#table'), '/admin/role/datatable', coldefs);
        table.on('click', '[data-action="toggle"]', toggleRole);
        table.on('click', '[data-action="edit"]', editRole);
        table.on('click', '[data-action="delete"]', deleteRole);
    }

    function newRole() {
        Common.success("Rol registrado con exito.");
        $('#table').find('a').tooltip('dispose');
        table.ajax.reload();
    }

    function toggleRole() {
        $.ajax({
            url: '/admin/role/' + $(this).data('id') + '/active',
            method: 'POST',
            data: {
                _token: $("[name='_token']").val(),
                _method: 'PUT'
            },
            dataType: 'json',
            success: function(e) {
                Common.success('Aviso', 'Registro Actualizado Satisfactoriamente');
                $('#table').find('a').tooltip('dispose');
                table.ajax.reload();
            },
            error: Common.eHandler
        });
    }

    function editRole() {
        var id = $(this).data('id');
        Common.modal($("#modal"), '/admin/role/' + id + '/edit')
            .then(function() {
                setEvents($('#modal'));
                $('#modal .access-panel [name*="permisos["]').each(updatePermisosUI);
                var config = {
                    url: '/admin/role/' + id,
                    success: updatedRole,
                    error: Common.eHandler,
                    rules: {
                        name: {
                            required: true
                        },
                        state: {
                            required: true
                        }
                    }
                };
                Common.validator($("#modal form"), config);
            });
    }

    function updatedRole() {
        Common.success("Rol actualizado con exito.");
        $('#modal').modal('hide');
        $('#table').find('a').tooltip('dispose');
        table.ajax.reload();
    }

    function deleteRole() {
        Common.confirm({
            title: "¿Seguro que deseas eliminar este registro?",
            text: "No habrá manera de revertir esta acción",
            confirmText: "Si, Elimínalo",
            confirm: roleDeleted,
            extras: $(this).data('id')
        });
    }

    function roleDeleted(id) {
        $.ajax({
            url: '/admin/role/' + id,
            method: 'POST',
            data: {
                _token: $("[name='_token']").val(),
                _method: 'DELETE'
            },
            dataType: 'json',
            success: function(e) {
                Common.success('Aviso', 'Registro Eliminado Satisfactoriamente');
                table.ajax.reload();
            },
            error: Common.eHandler
        });
    }

    return {
        init: function() {
            var config = {
                url: '/admin/role',
                success: newRole,
                error: Common.eHandler,
                rules: {
                    name: {
                        required: true
                    },
                    state: {
                        required: true
                    }
                }
            };
            Common.validator($("#submitForm"), config, resetPemisos);
            setEvents($('.m-content'));
            getRoles();
        }
    };
}();
"use strict;"

var Users = function() {
    var table;
    var config = {
        error: Common.eHandler,
        rules: {
            username: {
                required: true,
                remote:{
                    url: "/admin/user/userexists",
                    type: "get",
                    data: {
                      username: function() {
                        return $("#username_input").val();
                      },
                      company: function() {
                        return $("#company_input").val();
                      }
                    }
                  }
            },
            password: {
                required: true
            },
            confirm: {
                equalTo: "#password_input"
            },
            name: {
                required: true
            },
            email: {
                email: true
            },
            role_id: {
                required: true
            },
            dependency_id: {
                required: true
            },
            department_id: {
                required: true
            }
        },
        customMessages: {
            username: {
                remote: "Nombre de usuario ya registrado."
            }
        }
    };

    function setEvents() {
        config.url = '/admin/user';
        config.success = newUsuario;
        Common.validator($("#submitForm"), config);
        var porlet = new mPortlet('portlet_1');
        porlet.on('reload', function() {
            table.ajax.reload();
        });
    }

    function getUsers() {
        var coldefs = [
            {
                data: 'username',
                title: 'Usuario'
            }, {
                data: 'name',
                title: 'Nombre'
            }, {
                data: 'email',
                title: 'Correo'
            }, {
                data: 'dependency.name',
                title: 'Dependencia'
            }, {
                data: 'department.name',
                title: 'Departamento'
            }, {
                data: 'created_at',
                title: 'Creado',
                className: 'none',
                render: Common.dateFormat
            }, {
                data: 'updated_at',
                title: 'Actualizado',
                render: Common.dateFormat
            }, {
                data: 'role',
                title: 'Rol',
                render: function(r) {
                    return r.name;
                }
            },
            {
                data: 'active',
                title: 'Estado',
                render: Common.tableActive
            },
            {
                data: 'p',
                title: 'Acciones',
                className: 'all',
                render: Common.tableActions
            }
        ];
        table = Common.remoteTable($('#table'), '/admin/user/datatable', coldefs);
        table.on('click', '[data-action="toggle"]', toggleUser);
        table.on('click', '[data-action="edit"]', editUser);
        table.on('click', '[data-action="delete"]', deleteUser);
    }

    function getRoles(el) {
        return $.get('/admin/user/roles', function(e) {
            if (e.data || !e.error) {
                el.find("#role_id_input").select2({
                    language: "es",
                    width: '100%',
                    allowClear: true,
                    placeholder: 'Seleccione un rol',
                    data: $.map(e.data, function(e) {
                        e.text = e.name;
                        return parseInt(e.active) === 1 ? e : undefined;
                    })
                });
            } else if (e.error) {
                Common.error("Error!", e.r);
            }
        });
    }

    function getDependencies(el) {
        return $.get('/admin/user/dependencies', function(e) {
            if (e.data || !e.error) {
                el.find("#dependency_id_input").select2({
                    language: "es",
                    width: '100%',
                    allowClear: true,
                    placeholder: 'Seleccione una dependencia',
                    data: $.map(e.data, function(e) {
                        e.text = e.name;
                        return e;
                    })
                });
                el.find("#dependency_id_input").on('change', function(){
                    getDepartments(el, $(this).val());
                });
            } else if (e.error) {
                Common.error("Error!", e.r);
            }
        });
    }

    function getDepartments(el, val) {
        return $.get('/admin/user/departments', function(e) {
            if (e.data || !e.error) {
                var data  = $.grep(e.data, function(e){
                    return e.dependency_id == val;
                });
                el.find("#department_id_input").select2('val', '');
                el.find("#department_id_input").html('<option></option>');
                el.find("#department_id_input").select2({
                    language: "es",
                    width: '100%',
                    destroy:true,
                    allowClear: true,
                    placeholder: 'Seleccione un departamento',
                    data: $.map(data, function(e) {
                        e.text = e.name;
                        return e;
                    })
                });
            } else if (e.error) {
                Common.error("Error!", e.r);
            }
        });
    }

    function newUsuario(data) {
        Common.success("Atencion!", "Usuario registrado con exito.");
        table.ajax.reload();
    }

    function editUser() {
        var id = $(this).data('id');
        Common.modal($("#modal"), '/admin/user/' + id + '/edit')
            .then(function() {
                getRoles($("#modal"));
                getDependencies($("#modal")).then(function(){
                    $("#modal").find("#dependency_id_input").trigger('change');
                });
                $("#modal").on('hidden.bs.modal', function(){
                    getRoles($("#submitForm"));
                    getDependencies($("#submitForm"));
                    $("#submitForm").find("#department_id_input").select2({
                        language: "es",
                        width: '100%',
                        allowClear: true,
                        placeholder: 'Seleccione un departamento'
                    });
                });
                
                var u = $("#modal form #username_input").val();
                var editConfig = $.extend({}, config);
                editConfig.url = '/admin/user/' + id;
                editConfig.success = updatedUser;
                editConfig.rules.username.remote = function() {
                    return "/admin/user/userexists?before=" + u;
                };
                editConfig.rules.password = function() {
                    return $("#modal form #password_input").val();
                };
                editConfig.rules.confirm = {
                    equalTo: '#modal form #password_input'
                };
                Common.validator($("#modal form"), editConfig);
            });
    }

    function updatedUser() {
        Common.success("Usuario actualizado con exito.");
        $('#modal').modal('hide');
        $('#table').find('a').tooltip('dispose');
        table.ajax.reload();
    }

    function deleteUser() {
        Common.confirm({
            title: "¿Seguro que deseas eliminar este registro?",
            text: "No habrá manera de revertir esta acción",
            confirmText: "Si, Elimínalo",
            confirm: userDeleted,
            extras: $(this).data('id')
        });
    }

    function userDeleted(id) {
        $.ajax({
            url: '/admin/user/' + id,
            method: 'POST',
            data: {
                _token: $("[name='_token']").val(),
                _method: 'DELETE'
            },
            dataType: 'json',
            success: function(e) {
                Common.success('Aviso', 'Registro Eliminado Satisfactoriamente');
                table.ajax.reload();
            },
            error: Common.eHandler
        });
    }

    function toggleUser() {
        $.ajax({
            url: '/admin/user/' + $(this).data('id') + '/active',
            method: 'POST',
            data: {
                _token: $("[name='_token']").val(),
                _method: 'PUT'
            },
            dataType: 'json',
            success: function(e) {
                Common.success('Aviso', 'Registro Actualizado Satisfactoriamente');
                $('#table').find('a').tooltip('dispose');
                table.ajax.reload();
            },
            error: Common.eHandler
        });
    }

    function changePassword(){
        Common.modal($("#modal"), '/admin/user/changePassword')
            .then(function() {
                var conf = {
                    url: '/admin/user/changePassword',
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
                            equalTo: "#modal form #password_input"
                        }
                    }
                };
                Common.validator($("#modal form"), conf);
            });
    }

    function passwordChanged(){
        $("#modal").modal('hide');
        Common.success("Atencion!", "Contraseña actualizada con exito.");
    }


    return {
        init: function() {
            setEvents();
            getUsers();
            getRoles($("#submitForm"));
            getDependencies($("#submitForm"));
            $("#submitForm").find("#department_id_input").select2({
                language: "es",
                width: '100%',
                allowClear: true,
                placeholder: 'Seleccione un departamento'
            });
        },
        changePassword: changePassword
    };
}();
"use strict;"

var Valve = function(){
    var table;
    var config = {
        url: '/admin/valve',
        success: newValve,
        error: Common.eHandler,
        rules: {
            name: {
                required: true
            }
        }
    };

    function newValve()
    {
        Common.success('Aviso', 'Registro Actualizado Satisfactoriamente');
        table.ajax.reload();
    }

    function getValves()
    {
        var coldefs = [{
                data: 'id',
                title: '#'
            },
            {
                data: 'name',
                title: 'Válvula'
            }, 
            {
                data: 'schedule',
                title: 'Horario'
            }, 
            {
                data: 'address',
                title: 'Dirección'
            }, 
            {
                data: 'p',
                title: 'Acciones',
                render: Common.tableActions
            }
        ];
        table = Common.remoteTable($('#table'), '/admin/valve/datatable', coldefs);
        table.on('click', '[data-action="edit"]', editValve);
        table.on('click', '[data-action="delete"]', deleteValve);
    }

    function editValve()
    {
        var id = $(this).data('id');
        Common.modal($("#modal"), '/admin/valve/' + id + '/edit')
            .then(function() {
                config.url = '/admin/valve/' + id;
                config.success = updatedValve;
                Common.validator($("#modal form"), config);
            });
    }

    function updatedValve()
    {
        Common.success("Aviso!", "Registro actualizado");
        $('#modal').modal('hide');
        $('#table').find('a').tooltip('dispose');
        table.ajax.reload();
    }

    function deleteValve()
    {
        Common.confirm({
            title: "¿Seguro que deseas eliminar este registro?",
            text: "No habrá manera de revertir esta acción",
            confirmText: "Si, Elimínalo",
            confirm: valveDeleted,
            extras: $(this).data('id')
        });
    }

    function valveDeleted(id)
    {
        $.ajax({
            url: '/admin/valve/' + id,
            method: 'POST',
            data: {
                _token: $("[name='_token']").val(),
                _method: 'DELETE'
            },
            dataType: 'json',
            success: function(e) {
                Common.success('Aviso', 'Registro Eliminado Satisfactoriamente');
                table.ajax.reload();
            },
            error: Common.eHandler
        });
    }
    return {
        init: function(){
            Common.validator($("#submitForm"), config);
            getValves();
            var porlet = new mPortlet('portlet_1');
            porlet.on('reload', function(){
                table.ajax.reload();
            });
        }
    };
}();
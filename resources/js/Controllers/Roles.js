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
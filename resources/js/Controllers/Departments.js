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
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
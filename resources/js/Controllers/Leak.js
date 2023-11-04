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
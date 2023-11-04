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
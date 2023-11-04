"use strict;"

var _tDatatable = function(_Modal) {

    function _DateFormat(d)
    {
        return moment(d).format('DD-MM-YY HH:mm');
    }

    function _Active(r, s, d, u){
        var state = [
            '<span class="m-badge  m-badge--warning m-badge--wide">Pendiente</span>',
            '<span class="m-badge  m-badge--success m-badge--wide">Resuelta</span>'
        ];
        return state[r];
    }

    function _Actions(r, s, d, u){
        var t = '';
        if (r.a) {
            t += '<a data-container="body" data-id="' + d.id + '" data-action="toggle" data-toggle="m-tooltip" data-placemente="top" data-title = "Activar/Desactivar" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">' +
                '<i class="' + (d.active == "1" ? 'la la-toggle-on' : 'la la-toggle-off') + '"></i></a>'
        }
        if (r.e) {
            t += '<a data-container="body" data-id="' + d.id + '" data-action="edit" data-toggle="m-tooltip" data-placemente="top" data-title = "Editar" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill">' +
                '<i class="la la-edit"></i></a>';
        }
        if (r.d) {
            t += '<a data-container="body" data-id="' + d.id + '" data-action="delete" data-toggle="m-tooltip" data-placemente="top" data-title = "Eliminar" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill">' +
                '<i class="la la-remove"></i></a>'
        }
        return t;
    }

    function _dataTableConfig() {
        var config = {
            language: {
                processing: "Procesando...",
                search: "Buscar&nbsp;:",
                lengthMenu: "Mostrar _MENU_ ",
                info: "Mostrando de _START_ al _END_ de un total de _TOTAL_ registros",
                infoEmpty: "No hay datos disponibles",
                infoFiltered: "(Filtrando _MAX_ registros)",
                infoPostFix: "",
                loadingRecords: "Obteniendo Datos...",
                zeroRecords: "No hay datos disponibles para su búsqueda",
                emptyTable: "No hay datos disponibles",
                aria: {
                    sortAscending: ": Ordenar Ascendente",
                    sortDescending: ": Ordenar Descendente"
                }
            },
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 25, 50, "Todos"]
            ],
            destroy: true,
            responsive: true,
            dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            buttons: [
                { extend: "print", text: "Imprimir" },
                { extend: "copyHtml5", text: "Copiar" },
                "excelHtml5",
                "pdfHtml5"
            ]
        };

        return config;
    }

    function _remoteDataTable(table, url, columns, extraConfig) {
        if(!extraConfig)
            extraConfig = {};
        var config = _dataTableConfig();
        config.columns = columns;
        config.ajax = url;
        config.serverSide = true;
        config.processing = true;
        config.drawCallback = function() {
            table.find('a').tooltip();
        };
        config = $.extend({},config,extraConfig);
        var dt = table.DataTable(config);

        return dt;
    }

    function _localDataTable(table, data, columns, extraConfig) {
        if(!extraConfig)
            extraConfig = {};
        var config = _dataTableConfig();
        config.columns = columns;
        config.data = data;
        config.drawCallback = function() {
            table.find('a').tooltip();
        };
        config = $.extend({},config,extraConfig);
        var dt = table.DataTable(config);

        return dt;
    }

    _Modal.remoteTable = _remoteDataTable;
    _Modal.localTable = _localDataTable;
    _Modal.dateFormat = _DateFormat;
    _Modal.tableActions = _Actions;
    _Modal.tableActive = _Active;
    return _Modal;
}(_tModal || {});
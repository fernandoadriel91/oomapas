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
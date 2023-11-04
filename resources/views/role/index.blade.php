<div class="row">
    @if($permission->c)
    @component('components.portlet', ['form'=>'submitForm'])
    @slot('title')
    Nuevo Rol
    @endslot
    @include('role.form')
    @endcomponent
    @endif
    @if($permission->r)
    @component('components.portlet', ['table'=>'table'])
    @slot('title')
    Roles Registrados
    @endslot
    @endcomponent
    @endif
</div>
<div style="display:none" id="role_permission">
    <form>
        <p>
            <div class="m-radio-list">
                <div class="row">
                <div class="col-md-6">
                    <label class="m-checkbox m-checkbox--bold">
                        <input type="checkbox" name="menu[C]">
                        Crear
                        <span></span>
                    </label>
                    <label class="m-checkbox m-checkbox--bold">
                        <input type="checkbox" name="menu[R]">
                        Leer
                        <span></span>
                    </label>
                    <label class="m-checkbox m-checkbox--bold">
                        <input type="checkbox" name="menu[admin]">
                        Admin
                        <span></span>
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="m-checkbox m-checkbox--bold">
                        <input type="checkbox" name="menu[U]">
                        Actualizar
                        <span></span>
                    </label>
                    <label class="m-checkbox m-checkbox--bold">
                        <input type="checkbox" name="menu[D]">
                        Eliminar
                        <span></span>
                    </label>
                </div>
            </div>

            </div>
        </p>
        <div style="width: 100%; text-align: right; margin-bottom: 8px">
            <button type="button" class="btn btn-secondary" id="none" style="padding: .5rem 0.6rem; font-size: 0.65rem;">
                Ninguno
            </button>
            <button type="button" class="btn btn-metal" id="all" style="padding: .5rem 0.6rem; font-size: 0.65rem;">
                Todos
            </button>
        </div>
    </form>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary cancel">
            Cancelar
        </button>
        <button type="button" class="btn btn-brand confirm">
            Confirmar
        </button>
    </div>
</div>

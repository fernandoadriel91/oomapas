@foreach ($menu['childs'] as $menu)
    @if($menu['menu'] && count($menu['childs']) == 0)
        @php
            $permission = role_permission_value($menu, $role->permissions);
        @endphp
        <div class="col-md-4">
            <label class="m-checkbox m-checkbox--bold">
                <input type="checkbox" name="permisos[{{$menu['id']}}][permit]" {{isset($permission) ? 'checked' : ''}}>
                <input type="hidden" name="permisos[{{$menu['id']}}][id]" value="{{$menu['id']}}">
                {{ $menu['title'] }}  
                <span></span>
            </label>
            <div class="access-panel">
                <i class="la la-lock" data-for="NaN"> Click para asignar nivel de acceso</i>
                <i class="la la-eye" title="Lectura" data-for="R"></i>
                <i class="la la-plus" title="Crear" data-for="C"></i>
                <i class="la la-edit" title="Actualizar" data-for="U"></i>
                <i class="la la-times" title="Eliminar" data-for="D"></i>
                <i class="la la-user-plus" title="Admin" data-for="admin"></i>
                <input type="hidden" permission="R" name="permisos[{{$menu['id']}}][R]" value="{{isset($permission) && $permission->pivot->R ? 'true' : 'false'}}">
                <input type="hidden" permission="C" name="permisos[{{$menu['id']}}][C]" value="{{isset($permission) && $permission->pivot->C ? 'true' : 'false'}}">
                <input type="hidden" permission="U" name="permisos[{{$menu['id']}}][U]" value="{{isset($permission) && $permission->pivot->U ? 'true' : 'false'}}">
                <input type="hidden" permission="D" name="permisos[{{$menu['id']}}][D]" value="{{isset($permission) && $permission->pivot->D ? 'true' : 'false'}}">
                <input type="hidden" permission="admin" name="permisos[{{$menu['id']}}][admin]" value="{{isset($permission) && $permission->pivot->admin ? 'true' : 'false'}}">
            </div>
        </div>
    @endif
    @include('partial.role_menu_partial')
@endforeach
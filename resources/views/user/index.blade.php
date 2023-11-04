<div class="row">
    @if($permission->c)
        @component('components.portlet', ['form'=>'submitForm'])
            @slot('title')
            Nuevo Usuario
            @endslot
            @include('user.form')
        @endcomponent
    @endif
    @if($permission->r)
        @component('components.portlet', ['table'=>'table'])
            @slot('title')
            Usuarios Registrados
            @endslot
        @endcomponent
    @endif
</div>
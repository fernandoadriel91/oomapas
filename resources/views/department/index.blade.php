<div class="row">
    @if($permission->c)
        @component('components.portlet', ['form'=>'submitForm'])
            @slot('title')
            Nuevo Departamento
            @endslot
            @include('department.form')
        @endcomponent
    @endif
    @if($permission->r)
        @component('components.portlet', ['table'=>'table'])
            @slot('title')
            Departamentos Registradas
            @endslot
        @endcomponent
    @endif
</div>
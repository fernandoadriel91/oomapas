<div class="row">
    @if($permission->c)
        @component('components.portlet', ['form'=>'submitForm'])
            @slot('title')
            Nueva Dependencia
            @endslot
            @include('dependency.form')
        @endcomponent
    @endif
    @if($permission->r)
        @component('components.portlet', ['table'=>'table'])
            @slot('title')
            Dependencias Registradas
            @endslot
        @endcomponent
    @endif
</div>
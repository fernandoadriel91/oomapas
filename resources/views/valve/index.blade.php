<div class="row">
    @if($permission->c)
        @component('components.portlet', ['form'=>'submitForm'])
            @slot('title')
            Nueva Válvula
            @endslot
            @include('valve.form')
        @endcomponent
    @endif
    @if($permission->r)
        @component('components.portlet', ['table'=>'table'])
            @slot('title')
            Válvulas Registradas
            @endslot
        @endcomponent
    @endif
</div>
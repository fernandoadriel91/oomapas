<div class="row">
    @if($permission->c)
        @component('components.portlet', ['form'=>'submitForm', 'extraClass' => 'dropzone', 'multipart'=>true])
            @slot('title')
            Solicitar Pipa
            @endslot
            @include('pipe.form')
        @endcomponent
    @endif
    @if($permission->r)
        @component('components.portlet', ['table'=>'table'])
            @slot('title')
            Solicitudes de Pipas
            @endslot
        @endcomponent
    @endif
</div>
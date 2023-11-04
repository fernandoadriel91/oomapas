<div class="row">
    @if($permission->c)
        @component('components.portlet', ['form'=>'submitForm', 'extraClass' => 'dropzone', 'multipart'=>true])
            @slot('title')
            Capturar
            @endslot
            @include('capture.form')
        @endcomponent
    @endif
    @if($permission->r)
        @component('components.portlet', ['table'=>'table'])
            @slot('title')
            Datos Registrados
            @endslot
        @endcomponent
    @endif
</div>
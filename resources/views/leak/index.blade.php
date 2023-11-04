<div class="row">
    @if($permission->c)
        @component('components.portlet', ['form'=>'submitForm', 'extraClass' => 'dropzone', 'multipart'=>true])
            @slot('title')
            Registrar Fuga de Agua
            @endslot
            @include('leak.form')
        @endcomponent
    @endif
    @if($permission->r)
        @component('components.portlet', ['table'=>'table'])
            @slot('title')
            Fugas de Agua Registradas
            @endslot
        @endcomponent
    @endif
</div>
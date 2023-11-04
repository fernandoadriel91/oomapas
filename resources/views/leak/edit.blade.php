@component('components.modal', ['form'=>'modal_form', 'size'=>'xl', 'extraClass' => 'dropzone', 'multipart'=>true])
    @slot('title')
    Editar Fuga
    @endslot
    @method('PUT')
    @include('leak.form')
    @slot('footer')
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Cancelar
        </button> 
        <button type="submit" class="btn btn-brand">
            Actualizar
        </button> 
    @endslot
@endcomponent
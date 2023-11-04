@component('components.modal', ['form'=>'modal_form', 'size'=>'lg'])
    @slot('title')
    Editar Dependencia
    @endslot
    @method('PUT')
    @include('dependency.form')
    @slot('footer')
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Cancelar
        </button> 
        <button type="submit" class="btn btn-brand">
            Actualizar
        </button> 
    @endslot
@endcomponent
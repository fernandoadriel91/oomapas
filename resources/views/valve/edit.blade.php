@component('components.modal', ['form'=>'modal_form', 'size'=>'xl'])
    @slot('title')
    Válvulas
    @endslot
    @method('PUT')
    @include('valve.form')
    @slot('footer')
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Cancelar
        </button> 
        <button type="submit" class="btn btn-brand">
            Guardar
        </button> 
    @endslot
@endcomponent
@component('components.modal', ['form'=>'modal_form', 'size'=>'lg'])
    @slot('title')
    Cambiar Contraseña
    @endslot
    @method('PUT')
    @include('user.password')
    @slot('footer')
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Cancelar
        </button> 
        <button type="submit" class="btn btn-brand">
            Actualizar
        </button> 
    @endslot
@endcomponent
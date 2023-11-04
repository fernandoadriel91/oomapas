<div class="modal-dialog {{ isset($size) ? 'modal-'.$size : '' }}" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
                {{ $title }}
            </h5>
            @if(!isset($closeBtn) || $closeBtn)
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    &times;
                </span>
            </button>
            @endif
        </div>
        @if(isset($form))
        <form class="m-form m-form--fit m-form--label-align-right" id="{{ $form }}">
            @csrf()
        @endif
            <div class="modal-body">
                {{ $slot }}
            </div>
            @if(isset($footer))
            <div class="modal-footer">
                {{ $footer }}
            </div>
            @endif 
        @if(isset($form))
        </form>
        @endif
    </div>
</div>
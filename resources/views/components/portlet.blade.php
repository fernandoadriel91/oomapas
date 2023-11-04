<div class="{{isset($size) ? $size : 'col-sm-12'}}">
    <div class="m-portlet m-portlet--responsive-mobile {{ (isset($open) && $open) || (!isset($open) && isset($table)) ? '' : 'm-portlet--collapse' }}" m-portlet="true" @if(isset($id))id="{{$id}}"@endif>
        <div class="m-portlet__head">
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                                @if(isset($icon))
                                <i class="{{ $icon }}"></i>
                                @elseif(isset($form) && $form)
                                <i class="flaticon-add"></i>
                                @elseif(isset($table) && $table)
                                <i class="flaticon-list"></i>
                                @endif
                                
                            </span>
                        <h3 class="m-portlet__head-text">
                            {{ $title }}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    @if(isset($tools))
                    {{ $tools }}
                    @endif
                    <ul class="m-portlet__nav">
                        @if(isset($tools_nav))
                        {{ $tools_nav }}
                        @endif
                        @if(isset($help) && $help)
                        <li class="m-portlet__nav-item">
                            <a href="javascript:void(0);" m-portlet-tool="help" class="m-portlet__nav-link btn btn-info m-btn m-btn--icon m-btn--icon-only m-btn--pill"><i class="fa fa-question"></i></a>	
                        </li>
                        @endif
                        @if((isset($reload) && $reload) || (isset($table) && (!isset($reload) || $reload)))
                        <li class="m-portlet__nav-item">
                            <a href="javascript:void(0);" m-portlet-tool="reload" class="m-portlet__nav-link btn btn-primary m-btn m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-refresh"></i></a>	
                        </li>
                        @endif
                        @if(isset($fullscreen) && $fullscreen)
                        <li class="m-portlet__nav-item">
                            <a href="javascript:void(0);" m-portlet-tool="fullscreen" class="m-portlet__nav-link btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-expand"></i></a>	
                        </li>
                        @endif
                        @if(isset($remove) && $remove)
                        <li class="m-portlet__nav-item">
                            <a href="javascript:void(0);" m-portlet-tool="remove" class="m-portlet__nav-link btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-close"></i></a>	
                        </li>
                        @endif
                        @if((isset($toggle) && $toggle) || (isset($form) && (!isset($toggle) || $toggle)))
                        <li class="m-portlet__nav-item">
                            <a href="javascript:void(0);" m-portlet-tool="toggle" class="m-portlet__nav-link btn btn-metal m-btn m-btn--icon m-btn--icon-only m-btn--pill" toggle><i class="la la-angle-down"></i></a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            
        </div>
        @if(isset($form))
        <form class="m-form m-form--label-align-right" id="{{ $form }}" @if(!isset($open) || !$open)style="display:none"@endif>
            @csrf()
        @endif
            <div class="m-portlet__body">
                @if(isset($pre_table))
                {{$pre_table}}
                @endif
                @if(isset($table))
                <table class="table table-striped table-bordered table-hover" id="{{ $table }}"></table>
                @endif
                {{$slot}}
            </div>
            @if(isset($form))
            <div class="m-portlet__foot m-portlet__foot--fit ">
                <div class="m-form__actions m-form__actions ">
                    <div class="row ">
                        <div class="col-sm-12">
                            @if(!isset($buttons))
                            <button type="submit" id="save" class="btn btn-brand pull-right " style="margin-left: 15px; ">
                                Guardar
                            </button>
                            <button type="reset" class="btn btn-secondary pull-right ">
                                Cancelar
                            </button>
                            @else
                            {{$buttons}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endif
    </div>
</div>
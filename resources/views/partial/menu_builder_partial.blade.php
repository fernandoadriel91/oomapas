<ol @if(!isset($menu['title'])) class="sortable" @endif>
@foreach ($menu['childs'] as $menu)
<li class="item" id="menuItem_{{$menu['id']}}" data-type="@if(!count($menu['childs']) && $menu['menu'] == 1){{'2'}}@else{{$menu['menu']}}@endif">
        <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg m-portlet--bordered">
            <div class="m-portlet__head handle">
                @if($menu['parent'] == -1)
                    <i class="{{$menu['icon']}}"></i>
                @endif
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ $menu['title'] }}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="javascript:void(0)" class="m-portlet__nav-link m-portlet__nav-link--icon edit">
                                <i class="la la-edit"></i>
                            </a>
                        </li>
                        @if(count($menu['childs']))
                        <li class="m-portlet__nav-item">
                            <a href="javascript:void(0)" class="m-portlet__nav-link m-portlet__nav-link--icon disclose">
                                <i class="la la-angle-down"></i>
                            </a>
                        </li>
                        @else
                        <li class="m-portlet__nav-item">
                            <a href="javascript:void(0)" class="m-portlet__nav-link m-portlet__nav-link--icon delete" data-id="{{$menu['id']}}">
                                <i class="la la-close"></i>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <form class="m-form m-form--fit m-form--label-align-right" id="editForm_{{$menu['id']}}" name="editForm_{{$menu['id']}}" novalidate="novalidate" style="display: none;">
                {{ method_field('PUT') }}
                @csrf()
                <div class="m-portlet__body">
                    <input id="id_menu" name="id_menu" value="{{$menu['id']}}" type="hidden">
                    <div class="m-form__group form-group">
                        <label>
                            Tipo
                        </label>
                        <div class="m-radio-inline">
                            <label class="m-radio">
                                <input type="radio" name="menu" value="1" @if($menu['menu'] == 1 || $menu['menu'] == 2) checked @endif>
                                Menú
                                <span></span>
                            </label> 
                            @if(!count($menu['childs']) && $menu['parent'] == -1)
                            <label class="m-radio">
                                <input type="radio" name="menu" value="0" @if(!$menu['menu']) checked @endif>
                                Sección
                                <span></span>
                            </label>
                            <label class="m-radio">
                                <input type="radio" name="menu" value="3" @if($menu['menu'] == 3) checked @endif>
                                Custom
                                <span></span>
                            </label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group m-form__group">
                        <label for="menu">
                            Nombre del Menú
                        </label>
                        <input type="text" class="form-control m-input m-input--air" id="title" name="title" value="{{$menu['title']}}" placeholder="Usuarios">
                    </div>
                    <div class="form-group m-form__group">
                        <label for="route">
                            Ruta
                        </label>
                        <input type="text" class="form-control m-input m-input--air" id="route" name="route" value="{{$menu['route']}}" placeholder="users">
                    </div>
                    <div class="form-group m-form__group ">
                        <label for="icon">
                            Icóno
                        </label>
                        <div class="m-select2 m-select2--air">
                            <select class="form-control m-select2 " id="icon" name="icon" data-placeholder="flaticon-users ">        
                                <option value="{{$menu['icon']}}">{{ menu_builder_iconFn($menu['icon']) }}</option>   
                            </select>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit ">
                    <div class="m-form__actions m-form__actions ">
                        <div class="row ">
                            <div class="col-sm-12 ">
                                <button type="submit" id="save" class="btn btn-brand pull-right " style="margin-left: 15px; ">
                                    Guardar
                                </button>
                                <button type="reset " class="btn btn-secondary pull-right ">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @include('partial.menu_builder_partial')
    </li>
    @endforeach
</ol>
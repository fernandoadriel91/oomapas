<div class="row">
    @if($permission->c)
        @component('components.portlet', ['form'=>'submitForm', 'size'=>'col-sm-6', 'open'=>true, 'toggle'=>false])
            @slot('title')
            Nuevo Menú
            @endslot
            <div class="m-form__group form-group">
                <label>
                    Tipo
                </label>
                <div class="m-radio-inline">
                    <label class="m-radio">
                        <input type="radio" name="menu" value="1" checked>
                        Menú
                        <span></span>
                    </label>
                    <label class="m-radio">
                        <input type="radio" name="menu" value="0">
                        Sección
                        <span></span>
                    </label>
                    <label class="m-radio">
                        <input type="radio" name="menu" value="3">
                        Custom
                        <span></span>
                    </label>
                </div>
            </div>
            @mInput(["type"=>"text", "label" => "Nombre del Menú", 
                "name"=>"title", "placeholder"=>"Usuarios"])

            @mInput(["type"=>"text", "label" => "Ruta", 
            "name"=>"route", "placeholder"=>"user"])

            @mSelect2(["label" => "Icono", "name"=>"icon", "placeholder"=>"flaticon-users"])
        @endcomponent
    @endif
    @if($permission->u)
        @component('components.portlet', ['size'=>'col-sm-6'])
            @slot('title')
            Constructor de Menus
            @endslot
            <div id="menu_builder">
            </div>
        @endcomponent
    @endif
</div>
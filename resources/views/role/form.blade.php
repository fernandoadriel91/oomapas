<div class="row">
    <div class="col-sm-4">
        @mInput(["type"=>"hidden", "value"=>$role->id])
        @mInput(["type"=>"text", "label" => "Nombre del Rol", 
        "name"=>"name", "placeholder"=>"Admin", "value"=>$role->name])

        @mInput(["type"=>"text", "label" => "Estado Predeterminado", 
        "name"=>"state", "placeholder"=>"role", "value"=>$role->state])

        @mInput(["type"=>"text", "label" => "Descripción del Rol", 
        "name"=>"description", "placeholder"=>"Descripcion", "value"=>$role->description])
    </div>
    <div class="col-sm-8">
        <div class="form-group m-form__group">
            <label for="menu_input">
                Menú
            </label>
            <div class="row" id="menu_input">
                @include('partial.role_menu_partial')
            </div>
        </div>
    </div>
</div>
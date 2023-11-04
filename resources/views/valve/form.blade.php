<div class="row">
    <div class="col-sm-6 m--margin-top-15">
        @mInput(["type"=>"text", "label" => "Válvula", 
        "name"=>"name", "placeholder"=>"Nombre de la válvula", "value"=>$valve->name])            
    </div>
</div>
<div class="row">
    <div class="col-sm-6 m--margin-top-15">
        <div class="form-group m-form__group">
            <label for="schedule">
                Horario
            </label>
            <textarea name="schedule" id="schedule" placeholder="Horario de la válvula" class="form-control m-input m-input--air" rows="4">{{$valve->schedule}}</textarea>
        </div>      
    </div>
</div>
<div class="row">
    <div class="col-sm-6 m--margin-top-15">
        <div class="form-group m-form__group">
            <label for="address">
                Dirección
            </label>
            <textarea name="address" id="address" placeholder="Dirección de la válvula" class="form-control m-input m-input--air" rows="4">{{$valve->address}}</textarea>
        </div>      
    </div>
</div>

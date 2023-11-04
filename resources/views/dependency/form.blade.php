<div class="row">
    <div class="col-sm-4">
        @mInput(["type"=>"text", "label" => "Dependencia", 
        "name"=>"name", "placeholder"=>"Dependencia", "value"=>$dependency->name])            
    </div>
    <div class="col-sm-4">
        @mInput(["type"=>"text", "label" => "Encargado", 
        "name"=>"attendant", "placeholder"=>"Encargado", "value"=>$dependency->attendant])            
    </div>
</div>
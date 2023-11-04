<div class="row">
    <div class="col-sm-4">
        @mInput(["type"=>"text", "label" => "Departamento", 
        "name"=>"name", "placeholder"=>"Departamento", "value"=>$department->name])            
    </div>
    <div class="col-sm-4">
        @mSelect2(["label" => "Dependencia", 
        "name"=>"dependency_id", "placeholder"=>"Dependencia", 
        "value"=>($department->dependency ? $department->dependency->id : ''), 
        "text"=>($department->dependency ? $department->dependency->name : '')])            
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        @mInput(["type"=>"date", "label" => "Fecha", 
        "name"=>"date", "value"=>$article->date]) 
    </div>
    <div class="col-sm-4">
        @mSelect2(["label" => "Válvula", 
        "name"=>"valve_id", "placeholder"=>"Seleccionar válvula", "value"=>($capture->valve ? $capture->valve->id : ''), "text"=>($capture->valve ? $capture->valve->name : '')])              
    </div>
    <div class="col-sm-4">
        @mSelect2(["label" => "Hora de apertura", 
        "name"=>"organism_id", "placeholder"=>"Oficialia", "value"=>($director->organism ? $director->organism->id : ''), "text"=>($director->organism ? $director->organism->name : '')])                 
    </div>
</div>
<div class="row">
    <div class="col-sm-6 m--margin-bottom-15">
    <form method="post" id="upload_form" enctype="multipart/form-data">
    <label for="photo">Foto</label><br>
        <input type="file" id="photo" accept="image/*" name="photo">
        <p class="help-block">jpg, png, gif</p>          
    </div>
</div>
<div class="row">
    <div class="col-sm-6 m--margin-bottom-15">
        <form method="post" id="upload_form" enctype="multipart/form-data">
        <label for="cv">Curriculum</label><br>
        <input type="file" id="cv" accept="application/pdf" name="cv">
        <p class="help-block">pdf</p>         
    </div>
</div>
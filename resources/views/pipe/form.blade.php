<div class="row">
    <div class="col-sm-6">
        @mInput(["type"=>"text", "label" => "Nombre completo", 
        "name"=>"name", "placeholder"=>"Persona que solicita la pipa", "value"=>$pipe->name])            
    </div>
    <div class="col-sm-6">
        @mInput(["type"=>"text", "label" => "Celular", 
        "name"=>"telephone", "placeholder"=>"", "value"=>$pipe->telephone ?? ''])   
    </div>
</div>
<div class="row">
    <div class="col-sm-6 m--margin-top-15">
        @mInput(["type"=>"text", "label" => "Dirección", 
        "name"=>"address", "placeholder"=>"Calle, numero, colonia", "value"=>$pipe->address])           
    </div>
    <div class="col-sm-3 m--margin-top-15">
        @mInput(["type"=>"text", "label" => "Número de Contrato", 
        "name"=>"contract", "placeholder"=>"", "value"=>$pipe->contract])  
    </div>
    <div class="col-sm-3 m--margin-top-15">
        @mInput(["type"=>"text", "label" => "# Folio", 
        "name"=>"folio", "placeholder"=>"En caso de ya contar con folio de alguna pipa", "value"=>$pipe->folio])  
    </div>
</div>
<div class="row">
    <div class="col-sm-6 m--margin-top-15">
        <div class="form-group m-form__group">
            <label for="comment">
                ¿Comentarios adicionales?
            </label>
            <textarea name="comment" id="comment" placeholder="" class="form-control m-input m-input--air" rows="4">{{$pipe->comment}}</textarea>
        </div>      
    </div>
</div>
<div class="row">
    <div class="col-sm-6 m--margin-top-15">
    <form method="post" id="upload_form" enctype="multipart/form-data">
    <label for="photo">Recibo</label><br>
        <input type="file" id="photo" accept="image/*" name="photo">
        <p class="help-block">jpg, png, gif</p>          
    </div>
</div>
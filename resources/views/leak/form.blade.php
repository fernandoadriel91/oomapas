<div class="row">
    <div class="col-sm-6">
        @mInput(["type"=>"text", "label" => "Dirección", 
        "name"=>"address", "placeholder"=>"Calle, número, colonia", "value"=>$leak->address])            
    </div>
    <div class="col-sm-6">
        @mInput(["type"=>"text", "label" => "Entre Calles", 
        "name"=>"street", "placeholder"=>"Entre calle 1 y 2", "value"=>$leak->street])  
    </div>
</div>
<div class="row">
    <div class="col-sm-6 m--margin-top-15">
        <div class="form-group m-form__group">
            <label for="comment">
                ¿Comentarios adicionales?
            </label>
            <textarea name="comment" id="comment" placeholder="Descripción del lugar o domicilio" class="form-control m-input m-input--air" rows="4">{{$leak->comment}}</textarea>
        </div>      
    </div>
</div>
<div class="row">
    <div class="col-sm-6 m--margin-top-15">
    <form method="post" id="upload_form" enctype="multipart/form-data">
    <label for="photo">Foto</label><br>
        <input type="file" id="photo" accept="image/*" name="photo">
        <p class="help-block">jpg, png, gif</p>          
    </div>
</div>
<div class="mb-3">
    <label for="img_path" class="form-label">Immage</label>
    <input type="file" class="form-control" id="img_path" name="img_path" aria-describedby="emailHelp">
</div>

@if(isset($photo->img_path))
    <div class="mb-3">
        <img width="400" src="{{asset($photo->path)}}" title="{{$photo->name}}" alt="{{$photo->name}}">
    </div>
@endif

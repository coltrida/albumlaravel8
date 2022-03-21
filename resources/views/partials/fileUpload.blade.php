<div class="mb-3">
    <label for="album_thumb" class="form-label">Immage</label>
    <input type="file" class="form-control" id="album_thumb" name="album_thumb" aria-describedby="emailHelp">
</div>

@if($album->album_thumb)
    <div class="mb-3">
        <img width="400" src="{{asset($album->path)}}" title="{{$album->album_name}}" alt="{{$album->album_name}}">
    </div>
@endif

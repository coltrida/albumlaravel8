@extends('layouts.stile')
@section('titolo', 'modifica Album')

@section('content')
    <div class="container" style="margin: 40px auto">
        <h2>Edit Album - {{$album->album_name}}</h2>
        <form method="POST" action="{{route('albums.update', $album->id)}}">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="album_name" class="form-label">Nome Album</label>
                <input type="text" class="form-control" id="album_name" name="album_name" aria-describedby="emailHelp"
                       value="{{$album->album_name}}">
            </div>
            <div class="mb-3">
                <label for="album_thumb" class="form-label">thumb</label>
                <input type="text" class="form-control" id="album_thumb" name="album_thumb" aria-describedby="emailHelp"
                       value="{{$album->album_thumb}}">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <input type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp"
                       value="{{$album->description}}">
            </div>
            <button type="submit" class="btn btn-primary">Modifica</button>
        </form>
    </div>
@endsection

@extends('layouts.stile')
@section('titolo', 'modifica Album')

@section('content')
    <div class="container" style="margin: 40px auto">
        <h2>Edit Album - {{$album->album_name}}</h2>

        @include('partials.inputError')

        
        <form method="POST" action="{{route('albums.update', $album->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="album_name" class="form-label">Nome Album</label>
                <input type="text" class="form-control" id="album_name" name="album_name" aria-describedby="emailHelp"
                       value="{{$album->album_name}}">
            </div>

            @include('partials.fileUpload')

            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <input type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp"
                       value="{{$album->description}}">
            </div>
            <div class="flex">
                <button type="submit" class="btn btn-primary">Modifica</button>
                <a href="{{route('albums.index')}}" class="btn btn-warning">Annulla</a>
            </div>

        </form>
    </div>
@endsection

@extends('layouts.stile')
@section('titolo', 'modifica Album')

@section('content')
    <div class="container" style="margin: 40px auto">
        <h2>Create Image for album: {{$album->album_name}}</h2>

        @include('partials.inputError')

        <form method="POST" action="{{route('photos.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nome Foto</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
            </div>

            <select name="album_id" class="form-select" aria-label="Default select example">
                <option value="">SELECT</option>
                @foreach($albums as $item)
                    <option {{$item->id === $album->id ? 'selected' : ''}} value="{{$item->id}}">
                        {{$item->album_name}}
                    </option>
                @endforeach
            </select>

            @include('partials.fileUploadPhoto')

            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <input type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp">
            </div>
            <div class="flex">
                <button type="submit" class="btn btn-primary">Inserisci</button>
                <a href="{{route('albums.index')}}" class="btn btn-warning">Annulla</a>
            </div>

        </form>
    </div>
@endsection

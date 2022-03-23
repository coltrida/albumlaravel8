@extends('layouts.stile')
@section('titolo', 'modifica Album')

@section('content')
    <div class="container" style="margin: 40px auto">
        <h2>Edit Image - {{$photo->name}}</h2>

        @include('partials.inputError')

        <form method="POST" action="{{route('photos.update', $photo->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="name" class="form-label">Nome Foto</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp"
                       value="{{$photo->name}}">
            </div>

            <select name="album_id" class="form-select" aria-label="Default select example">
                <option value="">SELECT</option>
                @foreach($albums as $item)
                    <option {{$item->id === $photo->album_id ? 'selected' : ''}} value="{{$item->id}}">
                        {{$item->album_name}}
                    </option>
                @endforeach
            </select>

            @include('partials.fileUploadPhoto')

            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <input type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp"
                       value="{{$photo->description}}">
            </div>
            <div class="flex">
                <button type="submit" class="btn btn-primary">Modifica</button>
                <a href="{{route('albums.index')}}" class="btn btn-warning">Annulla</a>
            </div>

        </form>
    </div>
@endsection

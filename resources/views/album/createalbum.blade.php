@extends('layouts.stile')
@section('titolo', 'crea Album')

@section('content')
    <div class="container" style="margin: 40px auto">
        <h2>New Album</h2>

        @include('partials.inputError')


        <form method="POST" action="{{route('albums.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="album_name" class="form-label">Nome Album</label>
                <input type="text" class="form-control" id="album_name" name="album_name" aria-describedby="emailHelp"
                       value="{{old('album_name')}}">
            </div>

            @include('partials.fileUpload')

            @include('partials.category_combo')

            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <input type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp"
                       value="{{old('description')}}">
            </div>
            <button type="submit" class="btn btn-primary">Salva</button>
        </form>
    </div>
@endsection

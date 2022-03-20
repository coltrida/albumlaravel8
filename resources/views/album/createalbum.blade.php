@extends('layouts.stile')
@section('titolo', 'crea Album')

@section('content')
    <div class="container" style="margin: 40px auto">
        <h2>Create Album</h2>
        <form method="POST" action="{{route('albums.store')}}">
            @csrf
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            <div class="mb-3">
                <label for="album_name" class="form-label">Nome Album</label>
                <input type="text" required class="form-control" id="album_name" name="album_name" aria-describedby="emailHelp"
                       value="">
            </div>
            <div class="mb-3">
                <label for="album_thumb" class="form-label">thumb</label>
                <input type="text" class="form-control" id="album_thumb" name="album_thumb" aria-describedby="emailHelp"
                       value="">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <input type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp"
                       value="">
            </div>
            <button type="submit" class="btn btn-primary">Salva</button>
        </form>
    </div>
@endsection

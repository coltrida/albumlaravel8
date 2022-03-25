@extends('layouts.stile')
@section('titolo', 'crea Categoria')

@section('content')
        <div class="row justify-content-center mt-3">
            <div class="col-4">
                <h2>{{$category->category_name ? 'Modifica Categoria' : 'Inserimento Categoria'}}</h2>
                @include('category.categoryForm')
            </div>
        </div>
@stop

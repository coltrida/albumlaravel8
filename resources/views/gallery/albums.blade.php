@extends('layouts.stile')
@section('titolo', 'galleria pubblica')

@section('content')
    <div class="container">
        <h2>Albums</h2>
        <div class="row">
            @foreach($albums as $album)
                <div class="col-3">
                    <div class="card mb-4" style="width: 18rem;">
                        <a href="{{route('gallery.album.images', $album->id)}}">
                            <img src="{{asset($album->path)}}" class="card-img-top img-fluid rounded"
                                 alt="{{$album->album_name}}" title="{{$album->album_name}}">
                        </a>
                        <div class="card-body">
                            <a href="{{route('gallery.album.images', $album->id)}}">
                                <h5 class="card-title">{{Str::limit($album->album_name, 20)}}</h5>
                            </a>
                            <p class="card-text">{{Str::limit($album->description, 40)}}</p>
                            <p class="card-text">{{$album->created_at->diffForHumans()}}</p>
                            <p class="card-text">
                                @foreach($album->categories as $cat)
                                    <a href="{{route('gallery.categories.albums', $cat->id)}}">{{$cat->category_name}}</a>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
                {{$albums->links('vendor.pagination.bootstrap-4')}}
        </div>
    </div>
@stop

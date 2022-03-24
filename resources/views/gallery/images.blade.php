@extends('layouts.stile')
@section('titolo', 'galleria pubblica')

@section('content')
    <div class="container">
        <h2>Images</h2>
        <div class="row">
            @foreach($images as $image)
                <div class="col-3">
                    <div class="card mb-4" style="width: 18rem;">
                        <img src="{{asset($image->path)}}" class="card-img-top img-fluid rounded"
                             alt="{{$image->name}}" title="{{$image->name}}">
                        <div class="card-body">
                            <h5 class="card-title">{{Str::limit($image->name, 20)}}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
            {{$images->links('vendor.pagination.bootstrap-4')}}
        </div>
    </div>
@stop

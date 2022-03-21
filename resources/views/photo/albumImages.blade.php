@extends('layouts.stile')
@section('titolo', 'Images of album')

@section('content')
    <div class="container pt-3">
        <h2>Images of {{$alb->album_name}}</h2>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Created Date</th>
                <th scope="col">Title</th>
                <th scope="col">ThumbNail</th>
            </tr>
            </thead>
            <tbody>
            @forelse($alb->photos as $image)
                <tr class="align-middle">
                    <td>{{$image->id}}</td>
                    <td>{{$image->created_at}}</td>
                    <td>{{$image->name}}</td>
                    <td><img width="200" src="{{asset($image->img_path)}}" alt=""></td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No images</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@stop

@extends('layouts.stile')
@section('titolo', 'Images of album')

@section('content')
    <div class="container pt-3">

        @if(session()->has('message'))
            <x-alert
                :info="session()->get('tipo')"
                :messaggio="session()->get('message')">
            </x-alert>
        @endif

        <div class="row">
            <div class="col-10"><h2>Images of {{$album->album_name}}</h2></div>
            <div class="col"><a class="btn btn-primary" href="{{route('photos.create', $album->id)}}">New image</a></div>
        </div>


        <form>
            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Title</th>
                    <th scope="col">ThumbNail</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($images as $image)
                    <tr class="align-middle">
                        <td>{{$image->id}}</td>
                        <td>{{$image->created_at}}</td>
                        <td>{{$image->name}}</td>
                        <td><img width="200" src="{{asset($image->path)}}" alt=""></td>
                        <td>
                            <div class="d-flex">
                                <a class="btn btn-danger" href="{{route('photos.destroy', $image->id)}}">Delete</a>
                                <a class="btn btn-primary" href="{{route('photos.edit', $image->id)}}">Update</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No images</td>
                    </tr>
                @endforelse

                <tr>
                    <td colspan="5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2 d-flex justify-content-center">
                                {{$images->links('vendor.pagination.bootstrap-4')}}
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
@stop

@section('footer')
    @parent
    <script>
        $('document').ready(function () {
            $('div.alert').fadeOut(4000);

            $('tbody').on('click', 'a.btn-danger', function (ele) {
                ele.preventDefault();
                let urlAlbum = ele.target.href;    //let url = $(this).attr('href');
                let tr = ele.target.parentNode.parentNode.parentNode;
                $.ajax(urlAlbum,
                    {
                        method: 'DELETE',
                        data: {
                            '_token': $('#_token').val(),
                        },
                        complete: function (resp) {
                            if (resp.responseText == 1) {
                                tr.parentNode.removeChild(tr);
                            } else {
                                alert('problemi nella cancellazione')
                            }
                        }
                    }
                )
            });
        });
    </script>
@stop

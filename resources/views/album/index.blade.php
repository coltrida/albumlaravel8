@extends('layouts.stile')
@section('titolo', 'album')

@section('content')
    <div class="container pt-3">

        @if(session()->has('message'))
            <x-alert
                :info="session()->get('tipo')"
                :messaggio="session()->get('message')">
            </x-alert>
        @endif

        <div class="row">
            <div class="col"><h2>Album</h2></div>
            <div class="col"><a href="{{route('albums.create')}}" class="btn btn-primary">Nuovo</a></div>
        </div>

        <form>
            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">thumb</th>
                    <th scope="col">Descrizione</th>
                    <th scope="col">user_id</th>
                    <th scope="col">Azioni</th>
                </tr>
                </thead>
                <tbody>
                @foreach($albums as $album)
                    <tr>
                        <td>{{$album->album_name}}</td>
                        <td>{{$album->album_thumb}}</td>
                        <td>{{$album->description}}</td>
                        <td>{{$album->user_id}}</td>
                        <td >
                            <div class="d-flex">
                                <a class="btn btn-danger" href="{{route('albums.destroy', $album->id)}}">Delete</a>
                                <a class="btn btn-primary" href="{{route('albums.edit', $album->id)}}">Update</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </form>
    </div>
@endsection

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

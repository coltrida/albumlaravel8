@extends('layouts.stile')
@section('titolo', 'album')

@section('content')
    <div class="p-3">

        @if(session()->has('message'))
            <x-alert
                :info="session()->get('tipo')"
                :messaggio="session()->get('message')">
            </x-alert>
        @endif

        <div class="row">
            <div class="col-2">
                <h2>Album ({{count($albums)}})</h2>
            </div>

            <div class="col">
                <form class="row g-3" action="{{route('albums.filtra')}}" method="post">
                    @csrf
                    <div class="col-auto">
                        <select name="category_id" class="form-select" aria-label="Default select example">
                            <option value="">SELECT</option>
                            @foreach($categories as $item)
                                <option {{$item->id == $selectedCategory ? 'selected' : ''}} value="{{$item->id}}">
                                    {{$item->category_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">filtra</button>
                    </div>
                    <div class="col-auto">
                        <a href="{{route('albums.index')}}"  class="btn btn-warning mb-3">reset</a>
                    </div>
                </form>
            </div>

            <div class="col">
                <a href="{{route('albums.create')}}" class="btn btn-primary">Nuovo Album</a>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">thumb</th>
                <th scope="col">Autor</th>
                <th scope="col">Descrizione</th>
                <th scope="col">Categories</th>
                <th scope="col">Data Creaz</th>
                <th scope="col">Azioni</th>
            </tr>
            </thead>
            <tbody>
            @foreach($albums as $album)
                <tr class="align-middle" id="tr{{$album->id}}">
                    <td>{{$album->album_name}} ( {{$album->id}} )</td>
                    <td>
                        @if($album->album_thumb)
                            <img width="200" src="{{asset($album->path)}}" alt="">
                        @endif
                    </td>
                    <td>{{$album->user->name}}</td>
                    <td>{{$album->description}}</td>
                    <td>
                        <ul>
                            @foreach($album->categories as $cat)
                                <li>{{$cat->category_name}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td width="100">{{$album->created_at->format('d-m-Y')}}</td>
                    <td width="350">
                        <div class="row p-0 m-0">
                            <div class="col-2 p-0">
                                <form id="form{{$album->id}}" action="{{route('albums.destroy', $album->id)}}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button id="{{$album->id}}" title="elimina album" class="btn btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-2 p-0">
                                <a title="modifica album" class="btn btn-warning"
                                   href="{{route('albums.edit', $album->id)}}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>
                            <div class="col-2 p-0">
                                <a title="aggiungi foto all'album" class="btn btn-primary"
                                   href="{{route('photos.create', $album->id)}}">
                                    <i class="bi bi-plus-circle"></i>
                                </a>
                            </div>
                            <div class="col-3 p-0">
                                @if($album->photos_count)
                                    <a title="mostra foto" class="btn btn-success"
                                       href="{{route('albums.show', $album->id)}}">
                                        <i class="bi bi-image"></i> ({{$album->photos_count}})
                                    </a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="7">
                    <div class="row">
                        <div class="col-md-8 offset-md-2 d-flex justify-content-center">
                            {{$albums->links('vendor.pagination.bootstrap-4')}}
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection

@section('footer')
    @parent
    <script>
        $('document').ready(function () {
            $('div.alert').fadeOut(4000);

            $('tbody').on('click', 'button.btn-danger', function (evt) {
                evt.preventDefault();
                let idPulsante = evt.currentTarget.id;
                let form = $('#form' + idPulsante);
                let urlAlbum = form.attr('action');
                let tr = $('#tr' + idPulsante);
                $.ajax(urlAlbum,
                    {
                        method: 'DELETE',
                        data: {
                            '_token': '{{csrf_token()}}',
                        },
                        complete: function (resp) {
                            if (resp.responseText == 1) {
                                tr.remove();
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

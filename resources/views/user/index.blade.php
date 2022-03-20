@extends('layouts.stile')
@section('titolo', 'lista utenti')

@section('content')
    <div class="container pt-3">

        @if(session()->has('message'))
            <x-alert
                :info="session()->get('tipo')"
                :messaggio="session()->get('message')">
            </x-alert>
        @endif

        <h2>Utenti ( {{$users->count()}} )</h2>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">e-mail</th>
                    <th scope="col">Album</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <ul>
                                @foreach($user->albums as $album)
                                    <li>{{$album->album_name}}</li>
                                @endforeach
                            </ul>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

    </div>
@endsection

@extends('layouts.admin')
@section('content')
    @if(session()->has('message'))
        <x-alert
            :info="session()->get('tipo')"
            :messaggio="session()->get('message')">
        </x-alert>
    @endif

    <h2>Users List</h2>
    <table class="table table-striped table-dark data-table">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">email</th>
                <th scope="col">Role</th>
                <th scope="col">created</th>
                <th scope="col">deleted</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->role}}</td>
                <td>{{$user->created_at->format('d-m-Y H:i')}}</td>
                <td>{{$user->deleted_at ? $user->deleted_at->format('d-m-Y H:i') : null}}</td>
                <td>
                    <div class="row">
                        <div class="col-sm-4">
                            <a href="{{$user->deleted_at ? '#' : route('users.edit', $user->id)}}" class="btn btn-primary" title="update">
                                <i class="fa {{$user->deleted_at ? '#' : 'fa-pencil'}} "></i>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            @if(!$user->deleted_at)
                                <form action="{{route('users.destroy', $user->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-warning" title="logical delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                            @else
                                <a href="{{route('users.restore', $user->id)}}" class="btn btn-success" title="restore">
                                    <i class="fa fa-arrows"></i>
                                </a>
                            @endif
                        </div>
                        <div class="col-sm-4">
                            <a href="{{route('users.forceDelete', $user->id)}}" class="btn btn-danger elimina" title="force delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop

@section('footer')
    @parent
    <script>
        $('document').ready(function () {
            $('div.alert').fadeOut(4000);

            $('tbody').on('click', '.elimina', function (evt) {
                evt.preventDefault();

                let urlUser = $(this).attr('href');

                let tr = this.parentNode.parentNode.parentNode.parentNode;

                $.ajax(urlUser,
                    {
                        method: 'DELETE',
                        data: {
                            '_token': Laravel.csrfToken,
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

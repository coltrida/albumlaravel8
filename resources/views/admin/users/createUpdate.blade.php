@extends('layouts.admin')
@section('content')

<div class="container">
    <h2>{{$user->id ? 'Edit User' : 'New User'}}</h2>

    @include('partials.inputError')

    <form action="{{$user->id ? route('users.update', $user->id) : route('users.store')}}" method="post">
        @csrf
        @if($user->id)
            @method('PATCH')
        @endif
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" value="{{$user->name}}" class="form-control" id="name" name="name" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" value="{{$user->email}}" class="form-control" id="email" name="email">
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary">{{$user->id ? 'modifica' : 'inserisci'}}</button>
            <a href="{{route('users.index')}}" class="btn btn-warning mx-2">Annulla</a>
        </div>

    </form>
</div>

@stop

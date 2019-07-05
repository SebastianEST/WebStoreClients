@extends('layout')

@section('content')
    <div class="container">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif
        <h4>Kasutaja andmete muutmine kliendil: {{ Request::get('client') }}</h4>
        <form method="post" action="/users/{{$user[0]->id}}">

            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="firstname">Eesnimi: </label>
                <input type="text" class="form-control" name="firstname" value="{{ $user[0]->firstname }}">
            </div>
            <div class="form-group">
                <label for="lastname">Perekonnanimi: </label>
                <input type="text" class="form-control" name="lastname" value="{{ $user[0]->lastname }}">
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="text" class="form-control" name="email" value="{{ $user[0]->email }}">
            </div>
            <div class="form-group">
                <label for="username">Kasutajanimi: </label>
                <input type="text" class="form-control" name="username" value="{{ $user[0]->username }}">
            </div>
            <div class="form-group">
                <label for="personal_id">Isikukood: </label>
                <input type="text" class="form-control" name="personal_id" value="{{ $user[0]->personal_id }}">
            </div>
            <div class="form-group">
                <label for="">Parool: </label>
                <input type="text" class="form-control" name="password" value="{{ $user[0]->person ?? "parool" }}">
            </div>
            <input type="hidden" name="client" value={{ app('request')->input('client') }}>
            <button type="submit" class="btn btn-outline-success my-2 my-sm-0 float-right" name="change">Muuda</button>
        </form>
    </div>

@endsection
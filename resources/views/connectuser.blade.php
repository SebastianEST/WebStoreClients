@extends('layout')

@section('content')
    <div class="container">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif
        <h4>Kasutaja sidumine kliendile: {{ Request::get('client') }}</h4>
        <form method="post" action="/users/">

            @csrf
            <div class="form-group">
                <label for="firstname">Eesnimi: </label>
                <input type="text" class="form-control" name="firstname" value="{{ $user->firstname }}">
            </div>
            <div class="form-group">
                <label for="lastname">Perekonnanimi: </label>
                <input type="text" class="form-control" name="lastname" value="{{ $user->lastname }}">
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="text" class="form-control" name="email" value="{{ $user->email }}">
            </div>
            <div class="form-group">
                <label for="username">Kasutajanimi: </label>
                <input type="text" class="form-control" name="username" value="{{ $user->email }}">
            </div>
            <div class="form-group">
                <label for="personal_id">Isikukood: </label>
                <input type="text" class="form-control" name="personal_id" value="{{ $user->personal_id }}">
            </div>
            <div class="form-group">
                <label for="">Parool: </label>
                <input type="password" class="form-control" name="password" value="">
            </div>
            <input type="hidden" name="client" value={{ $user->client }}>
            <button type="submit" class="btn btn-outline-success my-2 my-sm-0 float-right" name="change">Seo kliendiga</button>
        </form>
    </div>

@endsection
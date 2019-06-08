@extends('layout')

@section('content')
    <div class="container">
        <h4>Kasutaja andmete muutmine</h4>
        <form method="post" action="/users/{{$user[0]->id}}">

            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="firstname">Eesnimi: </label>
                <input type="text" class="form-control" name="firstname">
            </div>
            <div class="form-group">
                <label for="lastname">Perekonnanimi: </label>
                <input type="text" class="form-control" name="lastname">
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="text" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label for="username">Email: </label>
                <input type="text" class="form-control" name="username">
            </div>
            <div class="form-group">
                <label for="personal_id">Isikukood: </label>
                <input type="text" class="form-control" name="personal_id">
            </div>
            <div class="form-group">
                <label for="">Parool: </label>
                <input type="text" class="form-control" name="password" placeholder="Kui tahad parooli muuta siis täida!">
            </div>
            <input type="hidden" name="client" value={{ app('request')->input('client') }}>
            <button type="submit" class="btn-primary" name="change">Muuda</button>
        </form>
    </div>

@endsection
@extends('layout')

@section('content')
    <div class="container">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif
        <h4>Kasutaja lisamine</h4>
        <form method="post" action="/users">

            @csrf
            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <div class="form-group">
                <label for="firstname">Eesnimi: </label>
                <input type="text" class="form-control" name="firstname" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="lastname">Perekonnanimi: </label>
                <input type="text" class="form-control" name="lastname" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="text" class="form-control" name="email" autocomplete="off" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="username">Kasutajanimi: </label>
                <input type="text" class="form-control" name="username" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="personal_id">Isikukood: </label>
                <input type="text" class="form-control" name="personal_id" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="">Parool: </label>
                <input type="password" class="form-control" name="password" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="role">Roll (Ärge muutke kui ei ole tel/kin süsteemi):</label>
                <select class="form-control" id="role" name="role">
                    <option value="1">Ostja</option>
                    <option value="2">Tellija</option>
                    <option value="3">Kinnitaja</option>
                </select>
            <div class="form-group">
                <label for="personal_id">Admin: </label>
                <input type="checkbox" class="form-check" name="admin" autocomplete="off" checked>
            </div>
            <input type="hidden" name="client" value={{ app('request')->input('client') }}>
            <button type="submit" class="btn btn-outline-success my-2 my-sm-0 float-right" name="change">Lisa uus kasutaja</button>
            <a href="{{ url()->previous() }}" class="btn btn-outline-success my-2 my-sm-0 float-left">Tagasi</a>
            </div>
        </form>
    </div>

@endsection
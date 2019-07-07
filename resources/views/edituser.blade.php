@extends('layout')

@section('content')
    <div class="container">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif
        <h4>Kasutaja andmete muutmine kliendil: {{ Request::get('client') }}</h4>
        <form method="post" action="/users/{{$webuser->id}}">

            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="firstname">Eesnimi: </label>
                <input type="text" class="form-control" name="firstname" value="{{ $webuser->firstname }}">
            </div>
            <div class="form-group">
                <label for="lastname">Perekonnanimi: </label>
                <input type="text" class="form-control" name="lastname" value="{{ $webuser->lastname }}">
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="text" class="form-control" name="email" value="{{ $webuser->email }}">
            </div>
            <div class="form-group">
                <label for="username">Kasutajanimi: </label>
                <input type="text" class="form-control" name="username" value="{{ $webuser->username }}">
            </div>
            <div class="form-group">
                <label for="personal_id">Isikukood: </label>
                <input type="text" class="form-control" name="personal_id" value="{{ $webuser->personal_id }}">
            </div>
            <div class="form-group">
                <label for="">Parool: </label>
                <input type="password" class="form-control" name="password" value="{{ $webuser->password ?? "" }}">
            </div>
            <div class="form-group">
                <label for="role">Roll (Ärge muutke kui ei ole tel/kin süsteemi):</label>
                <select class="form-control" id="role" name="role">
                    <option value="1" {{ $webuser->global_role_id === 1 ? 'selected' : "" }}>Ostja</option>
                    <option value="2" {{ $webuser->global_role_id === 2 ? 'selected' : "" }} >Tellija</option>
                    <option value="3" {{ $webuser->global_role_id === 3 ? 'selected' : "" }}>Kinnitaja</option>
                </select>
                <div class="form-group">
                    <label for="personal_id">Admin: </label>
                    <input type="checkbox" class="form-check" name="admin" autocomplete="off" {{ $webuser->admin ? 'checked' : "" }}>
                </div>
            <input type="hidden" name="client" value={{ app('request')->input('client') }}>
            <button type="submit" class="btn btn-outline-success my-2 my-sm-0 float-right" name="change">Muuda</button>
            <a href="{{ url()->previous() }}" class="btn btn-outline-success my-2 my-sm-0 float-left">Tagasi</a>
            </div>
        </form>

    </div>

@endsection
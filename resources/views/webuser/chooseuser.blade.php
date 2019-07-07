@extends('layout')

@section('content')
    <div class="container-fluid">
        <div class ="row mb-3 mt-3">
            <div class="col-2">
                <form method="post" action="/usr" class="form-inline my-2 my-lg-0">
                    @csrf
                    <input type="text" class="form-control mr-sm-2" name="email" placeholder="sisesta kasutaja email">
                    <input type="submit" value="Otsi" class="btn btn-outline-success my-2 my-sm-0">
                </form>
            </div>
        </div>
        @if( Session::has( 'success' ))
            <div class="alert alert-success">
                <strong>{{ Session::get( 'success' ) }}</strong>
            </div>
        @elseif( Session::has( 'warning' ))
            <div class="alert alert-warning">
                <strong>{{ Session::get( 'warning' ) }}</strong>
            </div>
        @endif
        @if(isset($data))
        <div class="row">
            <div class="col-4 border">
                <div class="mb-3">
                    <h4>Vali kasutaja</h4>
                </div>
                @if(isset($error))
                    {{ $error }}
                @endif
                <table class="table table-striped table-sm">
                    <tbody>
                    @foreach($data as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->firstname ." ". $user->lastname }}</strong>
                                <br>
                                <strong>{{ $user->email }}</strong>
                            </td>
                            <td>
                                <form action="/usr" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <input type="hidden" name="email" value="{{$first_email[0]}}">
                                    <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Näita</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            @if(isset($clients))
                <div class="col-4 border">
                    <div class="mb-3">
                        <h4>Kasutaja kliendikontod</h4>
                    </div>
                    @if(isset($error))
                        {{ $error }}
                    @endif
                    <table class="table table-striped table-sm">
                        <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>
                                    <strong>ID:</strong> {{ $client->id }} <strong>Kliendikood: </strong> {{ $client->ax_code }}
                                    <br>
                                    <strong>Nimi: </strong> {{ $client->name }}
                                </td>
                                <td>
                                    <form action="/client" method="get">
                                        <input type="hidden" name="client" value= {{$client->ax_code}}>
                                        <button type="submit" class="btn btn-outline-success my-2 my-sm-0 float-left mr-1">Mine</button>
                                    </form>
                                    <a href="/users/{{ $client->userid }}/edit?client={{$client->ax_code}}"><button class="btn btn-outline-success my-2 my-sm-0">Muuda</button></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            </div>
        @endif
    </div>
@endsection
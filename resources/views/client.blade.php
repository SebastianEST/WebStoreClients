@extends('layout')

@section('content')
<div class="container-fluid">
    <div class ="row mb-3 mt-3">
        <div class="col-2">
            <form method="get" action="/client" class="form-inline my-2 my-lg-0">
                @csrf
                <input type="text" class="form-control mr-sm-2" name="client" placeholder="sisesta kliendikood">
                <input type="submit" value="Näita" class="btn btn-outline-success my-2 my-sm-0">
            </form>
        </div>
    </div>
@if( Session::has( 'success' ))
        <div class="alert alert-success">
            <strong>{{ Session::get( 'success' ) }}</strong>
        </div>

@elseif( Session::has( 'warning' ))
    {{ Session::get( 'warning' ) }} <!-- here to 'withWarning()' -->
    @endif
    @if(isset($data))
    <div class="row">
        <div class="col-4 border">
            <div class="mb-3">
                <h4>Kliendi üldandmed</h4>
            </div>
            @if(isset($error))
                {{ $error }}
            @endif
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>
                            <p><strong>Ettevõtte ID: </strong></p>
                        </td>
                        <td>
                            <p>{{ $data[0]->id }}/{{ $data[0]->email }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Kliendikood:</strong></p>
                        </td>
                        <td>
                            <p>{{ $data[0]->ax_code }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Kliendi nimi: </strong></p>
                        </td>
                        <td>
                            {{ $data[0]->name }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Krediidilimiit: </strong></p>
                        </td>
                        <td>
                            <p>{{ $data[0]->balance }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Lubatud e-mailid: </strong></p>
                        </td>
                        <td>
                            <p>{{ $data[0]->allowed_emails }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Loodud e-poodi: </strong></p>
                        </td>
                        <td>
                            <p>{{ $data[0]->created_at }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-4 border">
            <div class="mb-3">
                <h4>Kliendi aadressid</h4>
            </div>
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td>
                        <p><strong>Vaike juriidiline aadress: </strong></p>
                    </td>
                    <td>
                        <p>{{ $data[0]->billing_street ." ".$data[0]->billing_city . " ". $data[0]->billing_postcode . " " . $data[0]->billing_region}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Vaike tarneaadress: </strong></p>
                    </td>
                    <td>
                        <p>{{ $data[0]->shipping_street ." ".$data[0]->shipping_city . " ". $data[0]->shipping_postcode . " " . $data[0]->shipping_region}}</p>
                    </td>
                </tr>
                </tbody>
            </table>
            <p>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Näita kõiki aadresse
                </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <table class="table table-striped">
                        <tbody>
                        @foreach($addresses as $adr)
                            <tr>
                                <td>
                                    <p><strong>Aadress: </strong></p>
                                </td>
                                <td>
                                    <p>{{ $adr->street ." ".$adr->city . " ". $adr->postcode . " " . $adr->region}}</p>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4 border">
            <div class="mb-3">
                <h4>AX volitatud isikud</h4>
            </div>
            @if(isset($axusers))
                <table class="table table-striped">
                    @foreach($axusers as $axuser)
                        <tr>
                            <td>
                                <strong>Email: </strong>{{$axuser->locator}}<br> <strong>Nimi:</strong> {{$axuser->firstname . " " .$axuser->lastname }}</td>
                            @if($axuser->web === 1)
                                <td>
                                    <a href="/users/connectuser?user={{$axuser->recid}}&email={{$axuser->locator}}&client={{ $data[0]->ax_code }}"><button class="btn btn-outline-success my-2 my-sm-0">Lisa</button></a>
                                </td>
                            @elseif($axuser->web === 2)
                                <td>
                                    <a href="/users/connectuser?user={{$axuser->recid}}&email={{$axuser->locator}}&client={{ $data[0]->ax_code }}"><button class="btn btn-outline-success my-2 my-sm-0">Seo</button></a>
                                </td>
                            @else
                                <td>
                                    <a href=""><button class="btn btn-outline-warning my-2 my-sm-0" disabled>OK</button></a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>

        <div class="col-4 border">
            <div class="mb-3">
                <h4>Kliendi kasutajad
                    <a href="/users/create?client={{ $data[0]->ax_code }}"><button class="btn btn-outline-success my-2 my-sm-0 float-right">Lisa kasutaja käsitsi</button></a>
                </h4>
            </div>
            @if(isset($users))
                <table class="table table-striped">
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <strong>Kasutajanimi: </strong>{{$user->email}}
                            <br>
                            <strong>Nimi:</strong> {{$user->firstname . " " .$user->lastname }}
                            <br>
                            <strong>Roll:</strong> {{ $user->roll }} <strong>Admin: </strong> {{$user->admin}} <strong>ID: </strong> {{$user->personal_id}}
                        </td>
                        <td>
                            <a href="/users/{{ $user->id }}/edit?client={{$data[0]->ax_code}}"><button class="btn btn-outline-success my-2 my-sm-0">Muuda</button></a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            @endif
            @endif
        </div>
    </div>


{{--        @if(isset($data))--}}
{{--        @foreach($data as $item)--}}
{{--            {{ $item->id }}--}}

{{--        @endforeach--}}
{{--        @endif--}}

</div>
@endsection
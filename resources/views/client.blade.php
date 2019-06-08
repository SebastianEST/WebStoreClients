@extends('layout')

@section('content')
<div class="container">
    <div class ="row">
        <div class="col-12">
            <h2>E-poe kliendid</h2>
            <form method="get" action="/client">
                @csrf
                <input type="text" name="client">
                <input type="submit" value="Näita">

                </br>
            </form>
        </div>
    </div>
    @if(isset($data))
    <div class="row">
        <div class="col-6 border">
            <h4>Kliendi üldandmed</h4>
            @if(isset($error))
                {{ $error }}
            @endif


                <p><strong>Kliendikood: </strong>{{ $data[0]->ax_code }}</p>
                <p><strong>Kliendi nimi: </strong>{{ $data[0]->name }}</p>
                <p><strong>Krediidilimiit: </strong>{{ $data[0]->balance }}</p>
                <p><strong>Lubatud e-mailid: </strong>{{ $data[0]->allowed_emails }}</p>
                <p><strong>Ettevõtte e-mail: </strong>{{ $data[0]->email }}</p>
                <p><strong>Loodud e-poodi: </strong>{{ $data[0]->created_at }}</p>


        </div>
        <div class="col-6 border">
            <h4>Kliendi aadressid</h4>
            <p><strong>Juriidiline aadress: </strong>{{ $data[0]->billing_street ." ".$data[0]->billing_city . " ". $data[0]->billing_postcode . " " . $data[0]->billing_region}}</p>
            <p><strong>Tarneaadress: </strong>{{ $data[0]->shipping_street ." ".$data[0]->shipping_city . " ". $data[0]->shipping_postcode . " " . $data[0]->shipping_region}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-6 border">
            <h4>AX volitatud isikud</h4>
            @if(isset($axusers))
                <table>
                        <tr>
                            <td><strong>Email: </strong>{{$axusers->locator}} <strong>Nimi:</strong> {{$axusers->firstname . " " .$axusers->lastname }}</td>

                        </tr>

                </table>
            @endif
        </div>

        <div class="col-6 border">
            <h4>Kliendi kasutajad
                <button class="btn-primary float-right">Lisa kasutaja</button>
            </h4>
            @if(isset($users))
                <table>
                    @foreach($users as $user)
                    <tr>
                        <td><strong>Kasutajanimi: </strong>{{$user->email}} <strong>Nimi:</strong> {{$user->firstname . " " .$user->lastname }}</td>
                        <td>
                            <a href="/users/{{ $user->id }}/edit?client={{$data[0]->ax_code}}"><button class="btn-primary">Muuda</button></a>
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
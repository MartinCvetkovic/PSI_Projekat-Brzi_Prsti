<!-- Autor(i)
    Petar Tirnanic 19/0039
-->

@extends("template")

@section('content')
    <div class="row">
        <div class="col-sm-12 text-center">
            <table class="table">
                <tr>
                    <td>Greske: </td>
                    <td>{{$mistakes}}</td>
                    <td rowspan="2"class="align-middle">Solo Brzo Kucanje</td>
                    <td>Prosecno vreme: </td>
                    <td>{{$text->average_time}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Vase vreme: </td>
                    <td>{{$time}}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <p>Tekst: {{$text->firstWords(10)}}</p>
            <p>Kategorija: {{$text->category()->naziv}}</p>
            <p>Tezina: {{$text->tezina}} / 10</p>

            <p><hr>Cestitamo, vasa brzina kucanja je {{$speed}} Reci po Minutu</p>
            @auth
                <p>Vas najbolji pokusaj je {{$best_speed}} Reci po Minutu @if ($speed == $best_speed)
                    (Novi licni Rekord!)
                @endif</p>
                <p>Vasa pozicija na rang listi je #{{$best_position}}</p>
            @endauth
            @guest
                <p>Rezultati kucanja se cuvaju samo registrovanim korisnicima</p>
            @endguest
            
            <table class="table"><tr>
                <td><a class="btn btn-primary" href="{{route('solo_kucanje', ['id' => $text->id])}}">Pokusaj Ponovo</a></td>
                <td><a class="btn btn-primary">Rang Lista</a></td>
            </tr></table>
        </div>
        <div class="col-sm-4">
            <p>2</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <input type="text" class="form-control">
        </div>
    </div>
@endsection
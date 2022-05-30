
{{-- Иван Савић 2019-0389 Страница за преглед профила, Martin Cvetkovic 19/0284 - napravio izmenu kod pogresnih dugmadi kod moderatora --}}

@extends("template")

@section("content")

 {{-- simulira tip i ime korisnika koji pristupa profilima --}}
<div class="row  mx-4  d-flex align-items-center">



    <div class="col-sm-8">
        <ul class="list-group bg-light">
            <li class="list-group-item d-flex justify-content-between bg-light">
                <p class="fw-bolder" style="margin: 0px 0px 0px">{{$profile->username}}</p>
                <p style="margin: 0px 5px 0px">Broj prijatelja: {{$profile->brojPrijatelja}}</p>
                <p style="margin: 0px 5px 0px">Ukupno nagrada: {{$profile->zlato  +$profile->srebro+$profile->bronza}}</p>
            </li>
        </ul>
    </div>
    {{-- Преглед сопственог профила нема додатне дугмиће --}}
    <div class="col-sm-4">

        @if ($profile->username == auth()->user()->username)
            {{-- nista ne prikazujemo na svom profilu --}}
        @else
            @if ($profile->aktivan == 1)
                @if ($prijatelj->isEmpty())
                    <a class="btn btn-primary" href="{{ route("dodaj_prijatelja",["username"=>$profile->username]) }}">Dodaj</a>
                @else
                    <a class="btn btn-danger" href="{{ route("dodaj_prijatelja",["username"=>$profile->username]) }}">Obriši</a>                    @endif
            @endif

            {{-- Ako sam ja admin/mod mogu ga blokirati/odblokirati --}}
            @if (auth()->user()->tip >0 && $profile->tip != 2)
                {{-- da li je aktivan --}}
                @if ($profile->aktivan == 1)
                <a  class="btn btn-danger mx-4" href="{{ route("blokiraj_korisnika",["username"=>$profile->username]) }}">Blokiraj</a>
                @else
                <a  class="btn btn-primary mx-4" href="{{ route("blokiraj_korisnika",["username"=>$profile->username]) }}">Odblokiraj</a>
                @endif
            @endif
            {{-- Ako sam ja admin modu dodeliti/uzeti moda --}}
            @if(auth()->user()->tip  == 2 && $profile->aktivan == 1 && $profile->tip != 2)
                @if ($profile->tip != 1)
                    <a  class="btn btn-warning " href="{{ route("dodeli_mod",["username"=>$profile->username]) }}">Dodeli mod</a>
                @else
                <a  class="btn btn-danger " href="{{ route("dodeli_mod",["username"=>$profile->username]) }}">Skini mod</a>
                @endif
            @endif
        @endif
    </div>

</div>
<div class="row pt-2  mx-4 d-flex align-items-center">
    <div class="col-sm-8 ">

        @if (!$prijatelji->isEmpty())
        <div class="list-group  overflow-auto border-top border-bottom border-black" style="max-height:200px">

                @foreach ($prijatelji as $prijatelj)
                <a href="{{route("visit_user",["username"=> $prijatelj->username])}}" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <p style="margin-bottom:0px"> {{$prijatelj->username}}</p>
                    <p style="margin-bottom:0px">
                        Broj nagrada:    {{$prijatelj->zlato+$prijatelj->srebro+$prijatelj->bronza}}
                    </p>
                </a>
                @endforeach

        </div>
        @endif
    </div>

    {{-- Угоди боје ових медаља, или стави слику медаље --}}
    <div class="col-sm-4  justify-content-center justify-content-middle ">
        <div class="d-flex align-items-center justify-content-center" style="height:80px; width:360px; background-image: url({{asset('images/gold_empty.png')}}); font-size: 24px; font-weight: bold"> {{$profile->bronza}}</div><br>
        <div class="d-flex align-items-center justify-content-center" style="height:80px; width:360px; background-image: url({{asset('images/silver_empty.png')}}); font-size: 24px; font-weight: bold">{{$profile->srebro}}</div><br>
        <div class="d-flex align-items-center justify-content-center" style="height:80px; width:360px; background-image: url({{asset('images/bronze_empty.png')}}); font-size: 24px; font-weight: bold">  {{$profile->zlato}}</div>
    </div>
</div>



@endsection

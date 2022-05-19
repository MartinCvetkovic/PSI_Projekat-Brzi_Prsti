

{{-- Иван Савић 2019-0389 Страница за преглед профила --}}

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

    </div>
    {{-- Преглед сопственог профила нема додатне дугмиће --}}
    <div class="col-sm-4">
        
        @if ($profile->username == auth()->user()->username )
            {{-- nista ne prikazujemo na svom profilu --}}
        @else
            @if ($prijatelj->isEmpty())
                <a class="btn btn-primary" href="{{ route("dodaj_prijatelja",["username"=>$profile->username]) }}">Dodaj</a>
            @else
                <a class="btn btn-danger" href="{{ route("dodaj_prijatelja",["username"=>$profile->username]) }}">Obrisi</a>
            @endif
            
            {{-- Ako sam ja admin/mod mogu ga blokirati/odblokirati --}}
            @if (auth()->user()->tip >0)
                {{-- da li je aktivan --}}
                @if ($profile->aktivan == 1)    
                <a  class="btn btn-danger mx-4" href="{{ route("blokiraj_korisnika",["username"=>$profile->username]) }}">Blokiraj</a>
                @else
                <a  class="btn btn-primary mx-4" href="{{ route("blokiraj_korisnika",["username"=>$profile->username]) }}">Odblokiraj</a>
                @endif
            @endif
            {{-- Ako sam ja admin modu dodeliti/uzeti moda --}}
            @if(auth()->user()->tip  == 2)
                @if ($profile->tip == 1)
                    <a  class="btn btn-warning " href="{{ route("dodeli_mod",["username"=>$profile->username]) }}">Mod</a>
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
        <div class=" text-center" style="height:30px; width:300px; background-color: gold" >  {{$profile->zlato}}</div><br>
        <div class="text-center" style="height:30px; width:300px;background-color: silver">{{$profile->srebro}}</div><br>
        <div class="text-center" style="height:30px; width:300px;background-color: #cc6633"> {{$profile->bronza}}</div>
    </div>
</div>


@endsection
 {{-- Иван Савић 0389/2019 Страница за претрагу профила, Martin Cvetkovic 19/0284 - izbacio prikaz admina u pretrazi --}}

@extends("template")

@section("content")

<div class="row  mx-4 d-flex align-items-center">
    <div class="col-sm-12">

        <form method="GET" action="{{route("searchusers_submit")}}" class="input-gorup w-80 p-3">
        @error("filter")
            <p class="alert alert-danger" style="margin: 0px; padding:0px 10px 0px; width:fit-content;"> {{$message}} </p>
        @enderror
        <div class="input-group rounded">
            <input id=validationFilter name="filter" type="search" value="" class="form-control rounded" placeholder="Pretraži" aria-label="Pretraži" aria-describedby="search-addon" />
        </div>

        </form>
    </div>
    <hr>
</div>

<div class="row  mx-4 p-4 d-flex justify-content-center flex-fill d-flex " >

     <div class="col-sm-10 ">

        <div class="list-group">

            @isset($profili)
            @if (!$profili->isEmpty())
            <div class="list-group  overflow-auto border-top border-bottom border-black" style="max-height:300px">
                @foreach ($profili as $profil)
                    <a href="{{route("visit_user",["username"=> $profil->username])}}" class="list-group-item list-group-item-action d-flex justify-content-between text-center ">
                        <p style="margin-bottom: 0em">  {{$profil->username}}</p>
                        <p style="margin-bottom: 0em">Broj nagrada:    {{$profil->zlato  +$profil->srebro+$profil->bronza}} </p>
                    </a>
                @endforeach
            </div>
            @else
            <p class="alert alert-danger text-center">  Korisnik nije pronađen </p>
            @endif

            @endisset
        </div>
    </div>

</div>


@endsection

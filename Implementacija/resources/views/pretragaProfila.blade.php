 {{-- Иван Савић 0389/2019 Страница за претрагу профила --}}

@extends("template")

@section("content")

<div class="row  mx-4 d-flex align-items-center">
    <div class="col-sm-12">

        <form method="GET" action="{{route("searchusers_submit")}}" class="input-gorup w-80 p-3">
        <div class="input-group rounded">
            <input name="filter" type="search" class="form-control rounded" placeholder="Pretrazi" aria-label="pretrazi" aria-describedby="search-addon" />
          </div>
        </form>
    </div>
    <hr>
</div>

<div class="row  mx-4 p-4 d-flex justify-content-center flex-fill d-flex " >
     {{-- ovde izlistamo sve korisnike sa onim @foreach  --}}

     <div class="col-sm-10 ">
        
        <div class="list-group">
            <a href="profile" class="list-group-item list-group-item-action d-flex justify-content-between text-center ">
                <p style="margin-bottom: 0em"> Korisnik 1 </p>
                 <p style="margin-bottom: 0em"> Broj nagrada: 10 </p>
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between text-center">
                <p style="margin-bottom: 0em"> Korisnik 2 </p>
                <p style="margin-bottom: 0em"> Broj nagrada: 20 </p>
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between text-center">
                <p style="margin-bottom: 0em"> Korisnik 3 </p>
                <p style="margin-bottom: 0em"> Broj nagrada: 30 </p>
            </a>
        </div>
    </div> 

</div>


@endsection
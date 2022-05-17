{{-- Иван Савић 2019-0389 Страница за преглед профила --}}

@extends("template")

@section("content")

<div class="row  mx-4  d-flex align-items-center">

    
    <div class="col-sm-8">
        <ul class="list-group bg-light">
            <li class="list-group-item d-flex justify-content-between bg-light"> 
                <p style="margin: 0px 0px 0px">Username</p>
                <p style="margin: 0px 5px 0px">Prijatelji</p>
                <p style="margin: 0px 5px 0px">Nagrade</p>
            </li>

    </div>
    {{-- Преглед сопственог профила нема додатне дугмиће --}}
    <div class="col-sm-4">
        {{-- 
        Сви
        Админ Мод
        Админ 
        --}}
        <button type="button" class="btn btn-primary ">Dodaj</button>   
        <button type="button" class="btn btn-danger mx-4">Blokiraj</button>
        <button type="button" class="btn btn-warning ">Mod</button>
    </div>

</div>
<div class="row pt-2  mx-4 d-flex align-items-center">
    <div class="col-sm-8 ">

        <div class="list-group  overflow-auto border-top border-bottom border-black" style="max-height:200px">
                
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <p style="margin-bottom:0px"> Prijatelj 1</p>
                    <p style="margin-bottom:0px">Broj nagrada:    14 </p>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <p style="margin-bottom:0px"> Prijatelj 2</p>
                    <p style="margin-bottom:0px">Broj nagrada:    14 </p>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <p style="margin-bottom:0px"> Prijatelj 1</p>
                    <p style="margin-bottom:0px">Broj nagrada:    14 </p>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <p style="margin-bottom:0px"> Prijatelj 2</p>
                    <p style="margin-bottom:0px">Broj nagrada:    14 </p>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <p style="margin-bottom:0px"> Prijatelj 1</p>
                    <p style="margin-bottom:0px">Broj nagrada:    14 </p>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <p style="margin-bottom:0px"> Prijatelj 2</p>
                    <p style="margin-bottom:0px">Broj nagrada:    14 </p>
                </a>
                
        </div>
    </div>

    {{-- Угоди боје ових медаља, или стави слику медаље --}}
    <div class="col-sm-4  justify-content-center justify-content-middle ">
        <div class="bg-warning text-center" style="height:30px; width:300px" > 13 </div><br>
        <div class="bg-warning text-center" style="height:30px; width:300px"> 2</div><br>
        <div class="bg-warning text-center" style="height:30px; width:300px"> 123</div>
    </div>
</div>


@endsection
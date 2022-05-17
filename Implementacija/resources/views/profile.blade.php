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
    <div class="col-sm-4">

        <button type="button" class="btn btn-primary ">Dodaj</button>
        <button type="button" class="btn btn-danger mx-4">Blokiraj</button>
        <button type="button" class="btn btn-warning ">Mod</button>
    </div>

</div>
<div class="row pt-2  mx-4 d-flex align-items-center">
    <div class="col-sm-8 ">

        <div class="list-group  overflow-auto" style="max-height:200px">
                
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

    <div class="col-sm-4  justify-content-center justify-content-middle ">
        <div class="bg-warning" style="height:30px; width:300px" > </div><br>
        <div class="bg-warning" style="height:30px; width:300px"></div><br>
        <div class="bg-warning" style="height:30px; width:300px"></div>
    </div>
</div>


@endsection
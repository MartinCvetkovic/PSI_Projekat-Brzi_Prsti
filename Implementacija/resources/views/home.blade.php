@extends("template")

@section("header")
<div class="row bg-primary border border-3 border-dark m-4 d-flex align-items-center">
    <div class="col-sm-3">
        <img src="{{ asset("images/logo.png") }}" alt="logo brzi prsti" id="logo">
    </div>
    <div class="col-sm-6 text-center">
        <br>
        <h1>Brzi Prsti</h1>
        <br>
        <div class="btn-group m-2">
            <button class="btn-light btn-lg" type="button" id="pocetna">Pocetna</button>
            <button class="btn-light btn-lg" type="button" id="kucanje">Kucanje</button>
            <button class="btn-light btn-lg" type="button" id="korisnici">Korisnici</button>
            <button class="btn-light btn-lg" type="button" id="tekstovi">Tekstovi</button>
            <button class="btn-light btn-lg" type="button" id="rangliste">Rang liste</button>
        </div>
    </div>
    <div class="col-sm-3 bg-light d-flex align-items-center justify-content-start p-3 my-2" style="width:24%">
        <form action="">
            <div class="form-group d-flex flex-column">
                <input class="m-1 p-1" type="text" placeholder="Korisnicko ime" size="37">
                <input class="m-1 p-1" type="password" placeholder="Lozinka">
            </div>
            <div class ="d-flex justify-content-between">
                <button class="btn p-2" id="prijava"><b>Prijavi se</b></button>
                <button class="btn p-2" id="registracija"><b>Registruj se</b></button>
            </div>
        </form>
    </div>
</div>
@endsection


@section("content")

@endsection
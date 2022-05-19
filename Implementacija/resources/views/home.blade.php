<?php
/**
* Autor:
* Martin Cvetkovic 19/0284
*/
?>

@extends("template")
    
@section("content")
    <div class="row bg-primary border border-3 border-dark m-4 p-3">
        <div class="col-sm-6"><b>Sesija brzog kucanja - nasumični tekst koji treba iskucati što je brže moguće</b></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3 text-center"><button class="btn btn-light btn-outline-dark">Započni brzo kucanje</button></div>
    </div>
    <div class="row bg-primary border border-3 border-dark m-4 p-3">
        <div class="col-sm-6"><b>Dnevni izazov - rešite dnevni izazov koji se menja svakog dana, najbolja vremena dobijaju bedževe</b></div>
        <div class="col-sm-3"></div>

        @guest
        <div class="col-sm-3 text-center"><button class="btn btn-secondary btn-outline-light bg-secondary" disabled>Započni dnevni izazov</button></div>
        @endguest

        @auth
        <div class="col-sm-3 text-center"><button class="btn btn-light btn-outline-dark">Započni dnevni izazov</button></div>
        @endauth
    </div>
    <div class="row bg-primary border border-3 border-dark m-4 p-3">
        <div class="col-sm-6"><b>Tekstovi za kucanje - odaberite tekst po kategorijama koje vam odgovaraju, sa opcijom izbora preporučenih tekstova za vašu brzinu kucanja</b></div>
        <div class="col-sm-3"></div>

        @guest
        <div class="col-sm-3 text-center"><button class="btn btn-secondary btn-outline-light bg-secondary" disabled>Izbor teksta</button></div>
        @endguest

        @auth
        <div class="col-sm-3 text-center"><button class="btn btn-light btn-outline-dark" onclick="location.href='{{route('texts')}}'">Izbor teksta</button></div>
        @endauth
    </div>
    <div class="row bg-primary border border-3 border-dark m-4 p-3">
        <div class="col-sm-6"><b>Pregled rang liste - uporedite se sa ostalim korisnicima po tekstovima</b></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3 text-center"><button class="btn btn-light btn-outline-dark">Pregled rang liste</button></div>
    </div>
@endsection
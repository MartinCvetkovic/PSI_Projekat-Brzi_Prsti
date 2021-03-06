<?php
/**
* Autor:
* Martin Cvetkovic 19/0284
*/
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--    Ako local verzija nece, ovo su CDN-ovi od ranije
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    -->

    <!-- Localne verzije Bootstrap i jQuery (public/css/... i public/js/...) -->
    <link rel="stylesheet" href="{{asset('css/bootstrap/bootstrap.min.css')}}">
    <script src="{{asset('js/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/jQuery/jquery-3.6.0.min.js')}}"></script>
    <link rel="stylesheet" href={{asset("css/templateStyle.css")}}>
    <title>Brzi prsti</title>
    @yield("additionalHead")
</head>
<body>
    <div class="container">

        <!-- header -->
        <div class="row bg-primary border border-3 border-dark mt-4 mb-4 pt-3 pb-3 d-flex align-items-center">
            <div class="col-sm-3">
                <img src="{{ asset("images/logo.png") }}" alt="logo brzi prsti" id="logo">
            </div>
            <div class="col-sm-6 text-center">
                <br>
                <h1>Brzi Prsti</h1>
                <br>
                <div class="btn-group m-2">
                    <button class="btn-light btn-lg" type="button" id="pocetna" onclick="location.href='{{route('homePage')}}'">Početna</button>
                    @guest
                    <button class="btn btn-secondary btn-outline-light bg-secondary" disabled>Kucanje</button>
                    @endguest
                    @auth
                    <button class="btn-light btn-lg" type="button" id="kucanje" onclick="location.href='{{route('solo_kucanje')}}'">Kucanje</button>
                    @endauth
                    @guest
                    <button class="btn btn-secondary btn-outline-light bg-secondary" disabled>Korisnici</button>
                    @endguest
                    @auth
                    <button class="btn-light btn-lg" type="button" id="korisnici" onclick="location.href='{{route('search_users')}}'">Korisnici</button>
                    @endauth
                    @guest
                    <button class="btn btn-secondary btn-outline-light bg-secondary" disabled>Tekstovi</button>
                    @endguest
                    @auth
                    <button class="btn-light btn-lg" type="button" id="tekstovi" onclick="location.href='{{route('texts')}}'">Tekstovi</button>
                    @endauth
                    <button class="btn-light btn-lg" type="button" id="rangliste" onclick="location.href='{{route('global_rank_list')}}'">Rang lista</button>
                </div>
            </div>
            <div class="col-sm-3 bg-light d-flex align-items-center justify-content-center py-3 px-1 rounded" style="width:24%">
                @guest

                <form action="{{route('login')}}" method="POST">
                    @csrf
                    <div class="form-group d-flex flex-column">
                        <input class="my-1 py-1" type="text" placeholder="Korisničko ime" name="username">
                        <div class="alert-danger">
                            @error("username")
                                {{$message}}
                            @enderror
                        </div>
                        <input class="my-1 py-1" type="password" placeholder="Lozinka" name="password">
                        <div class="alert-danger">
                            @error("password")
                                {{$message}}
                            @enderror
                            @if (isset($status))
                                {{$status}}
                            @endif
                            @if (session('status'))
                                {{session('status')}}
                            @endif
                        </div>
                    </div>
                    <div class ="d-flex justify-content-between">
                        <button class="btn p-2" id="prijava"><b>Prijavi se</b></button>
                        <button type="button" class="btn p-2" id="registracija" onclick="location.href='{{route('registerPage')}}'"><b>Registruj se</b></button>
                    </div>
                </form>

                @endguest

                @auth
                    <div class="d-flex flex-column">
                        <div class="text-center">
                            Dobrodošli {{auth()->user()->username}}
                        </div>
                        <div class ="d-flex justify-content-between">
                            <button type="button" class="btn p-2" onclick="location.href='{{route('visit_user', ['username' => auth()->user()->username])}}'"><b>Profil</b></button>
                            <button type="button" class="btn p-2" onclick="location.href='{{route('logout')}}'"><b>Odjavi se</b></button>
                        </div>
                    </div>
                @endauth

            </div>
        </div>
        <!-- end of header -->

        @yield("content")
    </div>
</body>
</html>

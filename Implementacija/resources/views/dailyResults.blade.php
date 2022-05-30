<!-- Autor(i)
    Petar Tirnanic 19/0039
-->

<!-- Sluzi za AJAX request, nije HTML stranica -->
<div class="col-sm-8 border border-light rounded p-3 header-text d-flex align-items-center">
    <table class="table table-borderless mb-0">
        <tr>
            <td>
                <p>Čestitamo, vaša brzina kucanja je<br>{{$speed}} Reči po Minutu</p>
                @auth
                    @if ($saved)
                        <p>Vaš najbolji pokušaj je <br>{{$best_speed}} Reči po Minutu
                            @if ($speed == $best_speed) <br>(Novi lični Rekord!) @endif
                        <p>Vaša pozicija na rang listi<br>dnevnog izazova je #{{$best_position}}</p>
                    @else
                        <p>Nažalost, dnevni izazov se je promenio u međuvremenu</p>
                        <p>Vaš rezultat nije sačuvan</p>
                    @endif
                @endauth
                 @guest
                    <p>Vaša pozicija na rang listi bi bila #{{$best_position}}</p>
                    <p>Rezultati kucanja se čuvaju samo registrovanim korisnicima</p>
                @endguest
            </td>
            <td class="divider"></td>
            <td class="text-center align-middle">
                <a class="btn btn-result title-text" href="{{route('daily_kucanje')}}">Pokušaj Ponovo ↻</a>
            </td>

        </tr>

        <tr><td colspan="3"><hr></td></tr>

        <tr>
            <td class="text-center align-middle">
                <!-- DODATI LINK NA DAILY RANG LISTU kad se napravi -->
                @if ($saved)
                    @switch($reward)
                        @case("gold")
                            <div class="card">
                                <div class="card-body inset-pill">
                                    <h4 class="card-title">Top #1</h4>
                                    <p class="card-text">
                                        Čestitamo, plasirali ste se u Top #1
                                        na dnevnom izazovu!
                                        Ako zadržite ovu poziciju do kraja dana, osvojićete:
                                    </p>
                                    <img class="card-img-bottom" src="{{asset('images/gold.png')}}" alt="Gold Badge icon">
                                </div>
                            </div>
                            @break
                        @case("silver")
                        <div class="card">
                            <div class="card-body inset-pill">
                                <h4 class="card-title">Top #3</h4>
                                <p class="card-text">
                                    Čestitamo, plasirali ste se u Top #3
                                    na dnevnom izazovu!
                                    Ako zadržite ovu poziciju do kraja dana, osvojićete:
                                </p>
                                <img class="card-img-bottom" src="{{asset('images/silver.png')}}" alt="Silver Badge icon">
                            </div>
                        </div>
                            @break
                        @case("bronze")
                        <div class="card">
                            <div class="card-body inset-pill">
                                <h4 class="card-title">Top #10</h4>
                                <p class="card-text">
                                    Čestitamo, plasirali ste se u Top #10
                                    na dnevnom izazovu!
                                    Ako zadržite ovu poziciju do kraja dana, osvojićete:
                                </p>
                                <img class="card-img-bottom" src="{{asset('images/bronze.png')}}" alt="Bronze Badge icon">
                            </div>
                        </div>
                            @break
                        @default
                        <div class="card">
                            <div class="card-body inset-pill">
                                <h4 class="card-title">Bez Nagrade</h4>
                                <p class="card-text">
                                    Nažalost, niste se plasirali dovoljno
                                    visoko da biste osvojili nagradu na dnevnom izazovu
                                </p>
                            </div>
                        </div>
                            @break
                    @endswitch
                @else
                    <p>Rezultat nije sačuvan</p>
                @endif
            </td>
            <td class="divider"></td>
            <td class="align-middle">
                <p class="text-end">{{$text->firstWords(8)}}</p>
                <p class="text-end">Kategorija: {{$text->category()->naziv}}</p>
                <p class="text-end">Težina: {{$text->tezina}} / 10</p>
            </td>
        </tr>



    </table>
</div>

<div class="col-sm border border-light rounded ml-6 p-3 h-100 d-inline-block">
    <div>
        <table class="table">
            <tr>
                <th colspan="2">Rangiranje (Dnevni)</th>
                <th>@auth <a href="#yourResult">Moja Pozicija</a> @endauth</th>
            </tr>
            <tr>
                <th>#&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                <th>Korisnik&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                <th>Vreme</th>
            </tr>
        </table>
    </div>
    <div class="w-100 h-85 d-inline-block overflow-auto">
        <table class="table" id="resultsTable">
            @foreach ($leaderboard as $row)
                <tr @auth @if (auth()->user()->id == $row->idKor)
                        id="yourResult" class="yourResult"
                    @endif @endauth>
                <td>{{$row->rank}}</td>
                <td>{{$row->user()->username}}</td>
                <td>{{$row->vreme}} s</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

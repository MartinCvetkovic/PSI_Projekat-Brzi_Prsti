<!-- Autor(i)
    Petar Tirnanic 19/0039
-->

<!-- Sluzi za AJAX request, nije HTML stranica -->
<div class="col-sm-8">
    <p>Tekst: {{$text->firstWords(10)}}</p>
    <p>Kategorija: {{$text->category()->naziv}}</p>
    <p>Tezina: {{$text->tezina}} / 10</p>

    <p><hr>Cestitamo, vasa brzina kucanja je {{$speed}} Reci po Minutu</p>
        @if ($saved)
            <p>Vasa pozicija na rang listi dnevnog izazova je #{{$best_position}}</p>
            <p>Vas najbolji pokusaj je {{$best_speed}} Reci po Minutu 
                @if ($speed == $best_speed) (Novi licni Rekord!) @endif
            @else
            <p>Nazalost, daily challenge se je promenio u medjuvremenu</p>
            <p>Vas rezultat nije sacuvan</p>
        @endif
    @guest
        <p>Vasa pozicija na rang listi dnevnog izazova bi bila #{{$best_position}}</p>
        <p>Rezultati kucanja se cuvaju samo registrovanim korisnicima</p>
    @endguest
    
    <table class="table"><tr>
        <td><a class="btn btn-primary" href="{{route('daily_kucanje')}}">Pokusaj Ponovo</a></td>
        <td><a class="btn btn-primary">Rang Lista</a></td>
    </tr></table>
</div>
<div class="col-sm-4">
    @if ($saved)
        @switch($reward)
            @case("gold")
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Top #1</h4>
                        <p class="card-text">
                            Cestitamo, plasirali ste se u Top #1
                            na dnevnom izazovu!
                            Ako zadrzite ovu poziciju do kraja dana, osvojicete:
                        </p>
                        <img class="card-img-bottom" src="{{asset('images/gold.png')}}" alt="Gold Badge icon">
                    </div>
                </div>
                @break
            @case("silver")
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top #3</h4>
                    <p class="card-text">
                        Cestitamo, plasirali ste se u Top #3
                        na dnevnom izazovu!
                        Ako zadrzite ovu poziciju do kraja dana, osvojicete:
                    </p>
                    <img class="card-img-bottom" src="{{asset('images/silver.png')}}" alt="Silver Badge icon">
                </div>
            </div>
                @break
            @case("bronze")
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top #10</h4>
                    <p class="card-text">
                        Cestitamo, plasirali ste se u Top #10
                        na dnevnom izazovu!
                        Ako zadrzite ovu poziciju do kraja dana, osvojicete:
                    </p>
                    <img class="card-img-bottom" src="{{asset('images/bronze.png')}}" alt="Bronze Badge icon">
                </div>
            </div>
                @break
            @default
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Bez Nagrade</h4>
                    <p class="card-text">
                        Nazalost, niste se plasirali dovoljno
                        visoko da biste osvojili nagradu na dnevnom izazovu
                    </p>
                </div>
            </div>
                @break
        @endswitch
    @else
        <p>Rezultat nije sacuvan</p>
    @endif
</div>
    
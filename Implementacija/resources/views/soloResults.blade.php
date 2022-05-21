<!-- Autor(i)
    Petar Tirnanic 19/0039
-->

<!-- Sluzi za AJAX request, nije HTML stranica -->
<div class="col-sm-8">
    <p>Tekst: {{$text->firstWords(10)}}</p>
    <p>Kategorija: {{$text->category()->naziv}}</p>
    <p>Tezina: {{$text->tezina}} / 10</p>

    <p><hr>Cestitamo, vasa brzina kucanja je {{$speed}} Reci po Minutu</p>
    @auth
        <p>Vas najbolji pokusaj je {{$best_speed}} Reci po Minutu @if ($speed == $best_speed)
            (Novi licni Rekord!)
        @endif</p>
        <p>Vasa pozicija na rang listi je #{{$best_position}}</p>
    @endauth
    @guest
        <p>Vasa pozicija na rang listi bi bila #{{$best_position}}</p>
        <p>Rezultati kucanja se cuvaju samo registrovanim korisnicima</p>
    @endguest
    
    <table class="table"><tr>
        <td><a class="btn btn-primary" href="{{route('solo_kucanje_id', ['id' => $text->id])}}">Pokusaj Ponovo</a></td>
        <td><a class="btn btn-primary">Rang Lista</a></td>
    </tr></table>
</div>
<div class="col-sm-4">
    <p>2</p>
</div>
    
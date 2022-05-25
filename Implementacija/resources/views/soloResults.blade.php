<!-- Autor(i)
    Petar Tirnanic 19/0039
    Martin Cvetkovic 10/0284 povezano rang dugme
-->

<!-- Sluzi za AJAX request, nije HTML stranica -->
<div class="col-sm-8 border border-light rounded p-3 header-text d-flex align-items-center">
    <table class="table table-borderless mb-0">
        <tr>
            <td>
                <p>Čestitamo, vaša brzina kucanja je<br>{{$speed}} Reči po Minutu</p>
                @auth
                    <p>Vaš najbolji pokušaj je<br>{{$best_speed}} Reči po Minutu @if ($speed == $best_speed)
                        <br>(Novi lični Rekord!)
                    @endif</p>
                    <p>Vaša pozicija na rang listi je #{{$best_position}}</p>
                @endauth
                 @guest
                    <p>Vaša pozicija na rang listi bi bila #{{$best_position}}</p>
                    <p>Rezultati kucanja se čuvaju samo registrovanim korisnicima</p>
                @endguest
            </td>
            <td class="divider"></td>
            <td class="text-center align-middle">
                <a class="btn btn-result title-text" href="{{route('solo_kucanje_id', ['id' => $text->id])}}">Pokušaj Ponovo ↻</a>
            </td>
            
        </tr>

        <tr><td colspan="3"><hr></td></tr>

        <tr>
            <td class="text-center align-middle">
                <a class="btn btn-result title-text" href="{{ route('rank_list', $text->id) }}">📋 Rang Lista</a>
            </td>
            <td class="divider"></td>
            <td>
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
                <th colspan="2">Rangiranje</th>
                <th>@auth <a href="#yourResult">Moja Pozicija</a> @endauth</th>
            </tr>
            <tr>
                <th>#&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                <th>Korisnik&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                <th>Vreme</th>
            </tr>
        </table>
    </div>
    <div class="w-100 h-75 d-inline-block overflow-auto">
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
    
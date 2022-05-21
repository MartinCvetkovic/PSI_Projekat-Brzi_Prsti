<!-- Autor(i)
    Petar Tirnanic 19/0039
    Martin Cvetkovic 10/0284 povezano rang dugme
-->

<!-- Sluzi za AJAX request, nije HTML stranica -->
<div class="col-sm-8 border border-light rounded p-3 header-text">
    <table class="table table-borderless mb-0">
        <tr>
            <td>
                <p>Cestitamo, vasa brzina kucanja je<br>{{$speed}} Reci po Minutu</p>
                @auth
                    <p>Vas najbolji pokusaj je<br>{{$best_speed}} Reci po Minutu @if ($speed == $best_speed)
                        (Novi licni Rekord!)
                    @endif</p>
                    <p>Vasa pozicija na rang listi je #{{$best_position}}</p>
                @endauth
                 @guest
                    <p>Vasa pozicija na rang listi bi bila #{{$best_position}}</p>
                    <p>Rezultati kucanja se cuvaju samo registrovanim korisnicima</p>
                @endguest
            </td>
            <td rowspan="2" class="divider"></td>
            <td class="text-center align-middle">
                <a class="btn btn-result title-text" href="{{route('solo_kucanje_id', ['id' => $text->id])}}">Pokusaj Ponovo ↻</a>
            </td>
            
        </tr>

        <tr><td colspan="3"><hr></td></tr>

        <tr>
            <td class="text-center align-middle">
                <a class="btn btn-result title-text" href="{{ route('rank_list', $text->id) }}">📋 Rang Lista</a>
            </td>
            <td rowspan="2" class="divider"></td>
            <td>
                <p class="text-end">{{$text->firstWords(10)}}</p>
                <p class="text-end">Kategorija: {{$text->category()->naziv}}</p>
                <p class="text-end">Tezina: {{$text->tezina}} / 10</p>
            </td>
        </tr>
        

        
    </table>
    
    
</div>
<div class="col-sm border border-light rounded ml-6">
    <p></p>
</div>
    
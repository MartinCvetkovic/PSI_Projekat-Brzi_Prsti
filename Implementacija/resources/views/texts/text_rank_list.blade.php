<!--
    Autor(i):
    Aleksa Savic 19/0039
    Martin Cvetkovic 19/0284 - ispravio los prikaz rang liste
-->

@extends("template")

@section('content')

<div class="row">
    <h1>Rang lista za tekst @if ($tipRangListe == 0) (globalna) @elseif ($tipRangListe == 1) (prijateljska) @endif</h1>
    <div class="col-md-12">
        <table class="table">
            <tr>
                @if ($tipRangListe == 0)
                    @auth
                        <a class="btn btn-primary" href="{{route('friendly_rank_list', ['id' => $text->id])}}">Prebaci na prijateljsku</a>
                    @endauth
                @else
                    <a class="btn btn-primary" href="{{route('rank_list', ['id' => $text->id])}}">Prebaci na globalnu</a>
                @endif
            </tr>

            <table class="table table-bordered table-striped">
                @foreach ($rankList as $listRow)
                    <tr>
                        <td>{{++$i}}.</td>
                        <td class="col-sm-5 align-middle">{{$listRow->userModel->username}}</td>
                        <td class="col-sm-3 align-middle text-center">
                            Vreme: {{$listRow->time}}, WPM: {{$listRow->wpm}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </table>
    </div>
</div>

@endsection

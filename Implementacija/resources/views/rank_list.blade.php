<!--
    Autor(i):
    Aleksa Savic 19/0595
    Martin Cvetkovic 19/0284 - ispravio los prikaz rang liste
-->

@extends("template")

@section('content')

    <div class="row">
        <h1>
            @if ($type == 0)
                Globalna rang lista
                <br>
                @auth
                    <a class="btn btn-primary" href="{{route('friendly_global_rank_list')}}">Prebaci na prijateljsku</a>
                @endauth
            @elseif ($type == 1)
                Prijateljska globalna rang lista
                <br>
                <a class="btn btn-primary" href="{{route('global_rank_list')}}">Prebaci na globalnu</a>
            @endif
        </h1>

        <div class="col-md-12">
            <table class="table">
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

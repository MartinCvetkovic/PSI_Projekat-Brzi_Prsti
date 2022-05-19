<!--
    Autor(i):
    Aleksa Savic 19/0039
-->

@extends("template")

@section('content')

<div class="row">

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
            @foreach ($users as $user)
                <tr>
                    <td rowspan="3" class="col-sm-5 align-middle">{{$user->username}}</td>
                    <td rowspan="3" class="col-sm-3 align-middle text-center">
                        Vreme: {{$user->time}}, WPM: {{$user->wpm}}
                    </td>
                </tr>
            @endforeach
        </table>
    </table>
</div>

<div class="row">
    <div class="col-sm-12">
        {{ $users->appends(request()->input())->links() }}
    </div>
</div>

@endsection

<!-- Autor(i)
    Aleksa Savic 19/0039
-->

@extends("template")

@section('content')

<div class="row">

    <div class="col-sm-12">
        <table class="table">
            <tr>
                @if ($tipRangListe == 0)
                    @auth
                        <a class="btn btn-primary" href="{{route('friendly_rank_list', ['id' => $text->id])}}">Prebaci na prijateljsku</a>
                    @endauth
                @else
                    <a class="btn btn-primary" href="{{route('rank_list', ['id' => $text->id])}}">Prebaci na globalnu</a>
                @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{$message}}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            @foreach ($users as $user)
                <tr>
                    <td rowspan="3" class="col-sm-5 align-middle">{{$user->username}}</td>
                    <td rowspan="3" class="col-sm-3 align-middle text-center">

                    </td>
                    <td class="col-sm-2">Kategorija: </td>
                    <td class="col-sm-2">{{$text->category()->naziv}}</td>
                </tr>
                <tr>
                    <td class="col-sm-2">Brzina: </td>
                    <td class="col-sm-2">{{}} WPM</td>
                </tr>
                <tr>
                    <td class="col-sm-2">Prosečno vreme: </td>
                    <td class="col-sm-2">{{}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        {{ $users->appends(request()->input())->links() }}
    </div>
</div>

@endsection

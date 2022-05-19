<!-- Autor(i)
    Petar Tirnanic 19/0039
-->

@extends("template")

@section('content')
    <div class="row">
        <div class="col-sm-2">
            <table class="table">
                <tr>
                    <td class="text-start">Kategorija: </td>
                    <td class="text-end">{{$text->category()->naziv}}</td>
                </tr>
                <tr>
                    <td class="text-start">Tezina: </td>
                    <td class="text-end">{{$text->tezina}} / 10</td>
                </tr>
            </table>
        </div>
        <div class="col-sm-10 text-center">
            <table class="table">
                <tr>
                    <td>Greske: </td>
                    <td>0</td>
                    <td rowspan="2"class="align-middle">Solo Brzo Kucanje</td>
                    <td>Prosecno vreme: </td>
                    <td>{{$text->average_time}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Vase vreme: </td>
                    <td>0.0 s</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <p>{{$text->sadrzaj}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-1">
            <form action="{{route('solo_kucanje_kraj')}}" method="GET">
                <input type="hidden" name="idTekst" value="{{$text->id}}">
                <button class="btn btn-primary">Simuliraj pokusaj (DEBUG)</button>
            </form>
        </div>
        <div class="col-sm-11">
            <input type="text" class="form-control">
        </div>
    </div>
@endsection
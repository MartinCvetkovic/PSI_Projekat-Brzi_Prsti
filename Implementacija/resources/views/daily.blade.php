<!-- Autor(i)
    Petar Tirnanic 19/0039
-->

@extends("template")

@section("additionalHead")
    <script src="{{asset('js/solo.js')}}"></script>
    <link rel="stylesheet" href={{asset("css/typingStyle.css")}}>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-2">
            <table class="table">
                <tr>
                    <td class="text-start">Kategorija: </td>
                    <td class="text-end">{{$daily->nazivKategorije}}</td>
                </tr>
                <tr>
                    <td class="text-start">Tezina: </td>
                    <td class="text-end">{{$daily->tezina}}/10</td>
                </tr>
            </table>
        </div>
        <div class="col-sm-10 text-center">
            <table class="table">
                <tr>
                    <td>Greske: </td>
                    <td><span id="mistakes">0</span></td>
                    <td rowspan="2"class="align-middle">Dnevni Izazov</td>
                    <td>Prosecno vreme: </td>
                    <td>{{$daily->average_time}} s</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Vase vreme: </td>
                    <td><span id="time">0.0 s</span></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row" id="mainRow">
        <div class="col-sm-12">
            <p id="textContent"><span class="notTypedText">{{$daily->sadrzaj}}</span></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <form>
                @csrf
                <input type="hidden" name="_text" value="{{$daily->sadrzaj}}">
                <input type="hidden" name="_idTekst" value="{{$daily->idTekst}}">
                <input type="hidden" name="_endRoute" value="{{route('daily_kucanje_kraj')}}">
                <input type="text" class="form-control" id="userInput">
            </form>
        </div>
    </div>
@endsection
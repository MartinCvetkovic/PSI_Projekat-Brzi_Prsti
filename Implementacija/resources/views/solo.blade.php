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
                    <td class="text-end">{{$text->category()->naziv}}</td>
                </tr>
                <tr>
                    <td class="text-start">Tezina: </td>
                    <td class="text-end">{{$text->tezina}}/10</td>
                </tr>
            </table>
        </div>
        <div class="col-sm-10 text-center">
            <table class="table">
                <tr>
                    <td>Greske: </td>
                    <td><span id="mistakes">0</span></td>
                    <td rowspan="2"class="align-middle">Solo Brzo Kucanje</td>
                    <td>Prosecno vreme: </td>
                    <td>{{$text->average_time}} s</td>
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
            <p id="textContent"><span class="notTypedText">{{$text->sadrzaj}}</span></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <form>
                @csrf
                <input type="hidden" name="_text" value="{{$text->sadrzaj}}">
                <input type="hidden" name="_idTekst" value="{{$text->id}}">
                <input type="hidden" name="_endRoute" value="{{route('solo_kucanje_kraj')}}">
                <input type="text" class="form-control" id="userInput">
            </form>
        </div>
    </div>
@endsection
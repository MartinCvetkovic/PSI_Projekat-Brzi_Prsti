<!-- Autor(i)
    Petar Tirnanic 19/0039
-->

@extends("template")

@section("additionalHead")
    <script src="{{asset('js/solo.js')}}"></script>
    <link rel="stylesheet" href={{asset("css/typingStyle.css")}}>
@endsection

@section('content')
    <div class="row pb-3">
        <div class="col-sm d-flex align-items-center border border-light rounded mr-6">
            <table class="table table-borderless mb-0 header-text">
                <tr>
                    <td class="align-middle text-start rounded-pill-start inset-pill ">Kategorija: </td>
                    <td class="align-middle text-end rounded-pill-end inset-pill">{{$daily->nazivKategorije}}</td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td class="align-middle text-start rounded-pill-start inset-pill">Tezina: </td>
                    <td class="align-middle text-end rounded-pill-end inset-pill">{{$daily->tezina}} / 10</td>
                </tr>
            </table>
        </div>
        <div class="col-sm-9 text-center d-flex align-items-center border border-light rounded">
            <table class="table table-borderless mb-2 mt-2 pl-3 pr-3 header-text">
                <tr>
                    <td class="col-sm align-middle text-start rounded-pill-start inset-pill" name="mistakes">Greske: </td>
                    <td class="col-sm align-middle text-end rounded-pill-end inset-pill" name="mistakes"><span id="mistakes">0</span></td>
                    <td rowspan="3"class="col-sm-7 align-middle title-text">Dnevni Izazov</td>
                    <td class="col-sm align-middle text-start rounded-pill-start inset-pill">Prosecno vreme: </td>
                    <td class="col-sm align-middle text-end rounded-pill-end inset-pill">{{$daily->average_time}} s</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="col-sm"></td>
                    <td class="col-sm"></td>
                    <td class="col-sm align-middle text-start rounded-pill-start inset-pill" name="time">Vase vreme: </td>
                    <td class="col-sm align-middle text-end rounded-pill-end inset-pill" name="time"><span id="time">0.0 s</span></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row pb-3" id="mainRow">
        <div class="col-sm-12 border border-light rounded p-3">
            <p id="textContent" class="mb-0 typing-text"><span class="notTypedText">{{$daily->cleanText()}}</span></p>
        </div>
    </div>
    <div class="row pb-3" id="userInputRow">
        <div class="col-sm-12 border border-light rounded p-1">
            <form>
                @csrf
                <input type="hidden" name="_text" value="{{$daily->cleanText()}}">
                <input type="hidden" name="_idTekst" value="{{$daily->idTekst}}">
                <input type="hidden" name="_endRoute" value="{{route('daily_kucanje_kraj')}}">
                <input type="text" class="form-control" id="userInput">
            </form>
        </div>
    </div>
@endsection
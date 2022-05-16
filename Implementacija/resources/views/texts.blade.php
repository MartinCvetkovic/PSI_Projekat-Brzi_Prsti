<!-- Autor(i)
    Petar Tirnanic 19/0039
-->

@extends("template")

@section('content')
<form method="GET" action="{{route('texts')}}">
    <div class="row">
        <span class="col-sm-3">
            <select class="form-select" name="kategorija">
                <option selected>Kategorija</option>
                @foreach ($categories as $cat)
                    <option value="{{$cat->id}}">{{$cat->naziv}}</option>
                @endforeach
            </select>
        </span>
        <span class="col-sm-2">
            <select class="form-select" name="tezina">
                <option>Tezina</option>
                <option value="1">Laki: 0-4</option>
                <option value="2">Srednji: 4-7</option>
                <option value="3">Teski: 7-10</option>
            </select>
        </span>
        <span class="col-sm-3">
            <select class="form-select" name="duzina">
                <option selected>Duzina</option>
                <option value="1">Kratki: < 20 reci</option>
                <option value="2">Srednji: 20-50 reci</option>
                <option value="3">Dugi: > 50 reci</option>
            </select>
        </span>
        <span class="col-sm-2 align-middle text-center">
            <button class="btn btn-primary" type="submit">Pretrazi</button>
        </span>
        <span class="col-sm-2 align-middle text-center">
            <a class="btn btn-primary" href="#" role="button">Dodaj Tekst</a>
        </span>
    </div>
</form>

<div class="row">
    <div class="col-sm-12">
        <table class="table">
            @foreach ($texts as $text)
                <tr>
                    <td rowspan="3" class="col-sm-5 align-middle">{{$text->sadrzaj}}</td>
                    <td rowspan="3" class="col-sm-3 align-middle"><button class="btn btn-primary">Zapocni Solo Brzo Kucanje</button></td>
                    <td class="col-sm-2">Kategorija: </td>
                    <td class="col-sm-2">{{$text->category()->naziv}}</td>
                </tr>
                <tr>
                    <td class="col-sm-2">Tezina: </td>
                    <td class="col-sm-2">{{$text->tezina}}</td>
                </tr>
                <tr>
                    <td class="col-sm-2">Prosecno vreme: </td>
                    <td class="col-sm-2">TODO</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        {{$texts->onEachSide(3)->links();}}
    </div>
</div>
@endsection
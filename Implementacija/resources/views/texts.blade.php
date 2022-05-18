<!-- Autor(i)
    Petar Tirnanic 19/0039
-->

@extends("template")

@section('content')

<div class="row">

    <div class="col-sm-12">

        <!-- Bar za pretragu -->
        <table class="table">
            <tr>
                <form method="GET" action="{{route('search_texts')}}">

                    <!-- Polje za unos kategorije -->
                    <td class="col-sm-3">
                        <select class="form-select" name="kategorija">
                            <option value="0" selected>Bilo koja kategorija</option>
                            @foreach ($categories as $cat)
                                <option value="{{$cat->id}}" @if ($kategorija == $cat->id) selected @endif>{{$cat->naziv}}</option>
                            @endforeach
                        </select>
                    </td>

                    <!-- Polje za unos tezine -->
                    <td class="col-sm-2">
                        <select class="form-select" name="tezina">
                            <option value="0">Bilo koja tezina</option>
                            <option value="1" @if ($tezina == 1) selected @endif>Laki: 0-4</option>
                            <option value="2" @if ($tezina == 2) selected @endif>Srednji: 4-7</option>
                            <option value="3" @if ($tezina == 3) selected @endif>Teski: 7-10</option>
                        </select>
                    </td>

                    <!-- Polje za unos duzine -->
                    <td class="col-sm-3">
                        <select class="form-select" name="duzina">
                            <option selected value="0">Bilo koja duzina</option>
                            <option value="1" @if ($duzina == 1) selected @endif>Kratki: < 20 reci</option>
                            <option value="2" @if ($duzina == 2) selected @endif>Srednji: 20-50 reci</option>
                            <option value="3" @if ($duzina == 3) selected @endif>Dugi: > 50 reci</option>
                        </select>
                    </td>

                    <!-- Submit dugme -->
                    <td class="col-sm-2 align-middle text-center">
                        <button class="btn btn-primary" type="submit">Pretrazi</button>
                    </td>
                </form>

                <!-- Dugme za dodavanje novog teksta -->
                <td class="col-sm-2 align-middle text-center">
                    <a class="btn btn-primary" href="#" role="button">Dodaj Tekst</a>
                </td>

            </tr>
        </table>


        <!-- Tabela tekstova -->
        <table class="table table-bordered table-striped">
            @foreach ($texts as $text)
                <tr>
                    <td rowspan="3" class="col-sm-5 align-middle">{{$text->sadrzaj}}</td>
                    <td rowspan="3" class="col-sm-3 align-middle text-center"><a class="btn btn-primary" href="{{route('solo_kucanje', ['id' => $text->id])}}">Započni Solo Brzo Kucanje</a></td>
                    <td class="col-sm-2">Kategorija: </td>
                    <td class="col-sm-2">{{$text->category()->naziv}}</td>
                </tr>
                <tr>
                    <td class="col-sm-2">Tezina: </td>
                    <td class="col-sm-2">{{$text->tezina}}</td>
                </tr>
                <tr>
                    <td class="col-sm-2">Prosecno vreme: </td>
                    <td class="col-sm-2">{{$text->average_time}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<!-- Bar za navigaciju kroz stranice tabele tekstova -->
<div class="row">
    <div class="col-sm-12">
        {{ $texts->appends(request()->input())->links() }}
    </div>
</div>

@endsection

<!-- Autor(i)
    Petar Tirnanic 19/0039
    Martin Cvetkovic 10/0284 - dodao da ne mogu svi korisnici da menjaju tekst
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
                    <a class="btn btn-primary" href="{{route("create_text")}}" role="button">Dodaj tekst</a>
                </td>

            </tr>
        </table>


        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{$message}}
            </div>
        @endif

        <!-- Tabela tekstova -->
        <table class="table table-bordered table-striped">
            @foreach ($texts as $text)
                <tr>
                    <td rowspan="3" class="col-sm-5 align-middle">{{$text->sadrzaj}}</td>
                    <td rowspan="3" class="col-sm-3 align-middle text-center">
                        <a class="btn btn-primary" href="{{route('solo_kucanje_id', ['id' => $text->id])}}">Započni Solo Brzo Kucanje</a>
                        <hr>

                        <form action="{{ route('destroy_text',$text->id) }}" method="POST">
                            <a class="btn btn-sm btn-primary " href="{{ route('rank_list', $text->id) }}"><i class="fa fa-fw fa-eye"></i>Rang liste</a>
                            @auth
                            @if(auth()->user()->tip != 0)
                            <a class="btn btn-sm btn-success" href="{{ route('edit_text', $text->id) }}"><i class="fa fa-fw fa-edit"></i>Izmeni</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i>Obriši</button>
                            @endif
                            @endauth
                        </form>
                    </td>
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

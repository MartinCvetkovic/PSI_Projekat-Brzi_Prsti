<!-- Autor(i)
    Petar Tirnanic 19/0039
    Martin Cvetkovic 10/0284 - dodao da ne mogu svi korisnici da menjaju tekst
-->

@extends("template")
    <link rel="stylesheet" href={{asset("css/textsStyle.css")}}>
@section("additionalHead")

@endsection

@section('content')

<!-- Script za uvecanje paginacije i ucitavanje tooltipa za zvezdicu -->
<script>$(document).ready(function() {
        $("#pageContainer>nav>ul.pagination").addClass("pagination-lg");
    });
</script>


<div class="row">

    <div class="col-sm-12 p-0">

        <!-- Bar za pretragu -->
        <table class="table table-borderless search-bar">
            <tr>
                <form method="GET" action="{{route('search_texts')}}">
                    <td class="col-sm-1 align-middle text-center">
                        <a type="button" id="starButton" class="btn btn-warning w-100" title="Preporuci mi tekstove">⭐</a>
                    </td>

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
                    <td class="col-sm-2">
                        <select class="form-select" name="duzina">
                            <option selected value="0">Bilo koja duzina</option>
                            <option value="1" @if ($duzina == 1) selected @endif>Kratki: < 20 reci</option>
                            <option value="2" @if ($duzina == 2) selected @endif>Srednji: 20-50 reci</option>
                            <option value="3" @if ($duzina == 3) selected @endif>Dugi: > 50 reci</option>
                        </select>
                    </td>

                    <!-- Submit dugme -->
                    <td class="col-sm align-middle text-center">
                        <button class="btn btn-secondary w-100" type="submit">Pretrazi &nbsp🔎</button>
                    </td>
                </form>

                @if (auth()->user()->tip == 1 || auth()->user()->tip == 2)
                        <!-- Dugme za dodavanje novog teksta -->
                    <td class="col-sm-2 align-middle text-center">
                        <a class="btn btn-success w-100" href="{{route("create_text")}}" role="button">Dodaj tekst &nbsp🞧</a>
                    </td>
                @endif
                

            </tr>
        </table>


        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                {{$message}}
            </div>
        @endif

        <!-- Tabela tekstova -->
        <table class="table table-bordered table-striped border-row-divide">
            @foreach ($texts as $text)
                <tr>
                    <td rowspan="3" class="col-sm-5 align-middle">{{$text->firstWords(35)}}</td>
                    <td rowspan="3" class="col-sm-3 align-middle">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td colspan="3">
                                    <a class="btn btn-result w-100 h-100" href="{{route('solo_kucanje_id', ['id' => $text->id])}}">Započni Solo Brzo Kucanje</a>
                                </td>
                            </tr>
                            <tr>
                                <form action="{{ route('destroy_text',$text->id) }}" method="POST">
                                    <td>
                                        <a class="btn btn-dark w-100 h-100" href="{{ route('rank_list', $text->id) }}"><i class="fa fa-fw fa-eye"></i>Rang lista</a>
                                    </td>
                                    @auth
                                        @if(auth()->user()->tip != 0)
                                            <td>
                                                <a class="btn btn-success w-100 h-100" href="{{ route('edit_text', $text->id) }}"><i class="fa fa-fw fa-edit"></i>Izmeni</a>
                                            </td>
                                            <td>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger w-100 h-100"><i class="fa fa-fw fa-trash"></i>Obriši</button>
                                            </td>
                                        @endif
                                    @endauth
                                </form>
                            </tr>
                        </table>
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
    <div class="col-sm-12 ps-3 pe-3 pt-1" id="pageContainer">
        {{ $texts->appends(request()->input())->onEachSide(5.5)->links() }}
    </div>
</div>

@endsection

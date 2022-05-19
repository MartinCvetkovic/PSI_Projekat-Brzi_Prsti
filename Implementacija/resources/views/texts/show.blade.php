@extends('template')

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <h2 class="card-title">Prikaz teksta</h2>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('texts') }}">Nazad</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Sadržaj:</strong>
                            {{ $tekst->sadrzaj }}
                        </div>
                        <br>
                        <div class="form-group">
                            <strong>Težina:</strong>
                            {{ $tekst->tezina }}
                        </div>
                        <br>
                        <div class="form-group">
                            <strong>Kategorija:</strong>
                            {{ $tekst->idKat }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('template')

@section('template_title')
    {{ $tekst->name ?? 'Show Tekst' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Tekst</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('texts') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Sadrzaj:</strong>
                            {{ $tekst->sadrzaj }}
                        </div>
                        <div class="form-group">
                            <strong>Tezina:</strong>
                            {{ $tekst->tezina }}
                        </div>
                        <div class="form-group">
                            <strong>Idkat:</strong>
                            {{ $tekst->idKat }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

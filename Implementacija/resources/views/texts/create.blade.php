@extends('template')

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-6">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <h2 class="card-title">Dodavanje teksta</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('store_text') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('texts.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

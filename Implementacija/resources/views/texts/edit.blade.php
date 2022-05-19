@extends('template')

@section('template_title')
    Update Tekst
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Tekst</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('update_text', $tekst->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('POST') }}
                            @csrf

                            @include('texts.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

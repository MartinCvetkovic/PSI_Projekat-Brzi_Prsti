<div class="box box-info padding-1">
    <div class="box-body">

        {{ Form::hidden('id', $tekst->id, array('id' => $tekst->id)) }}

        <div class="form-group">
            {{ Form::label('sadrzaj') }}
            {{ Form::textarea('sadrzaj', $tekst->sadrzaj, ['class' => 'form-control' . ($errors->has('sadrzaj') ? ' is-invalid' : ''), 'placeholder' => 'Sadrzaj']) }}
            {!! $errors->first('sadrzaj', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tezina') }}
            {{ Form::text('tezina', $tekst->tezina, ['class' => 'form-control' . ($errors->has('tezina') ? ' is-invalid' : ''), 'placeholder' => 'Tezina']) }}
            {!! $errors->first('tezina', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('idKat') }}
            {{ Form::text('idKat', $tekst->idKat, ['class' => 'form-control' . ($errors->has('idKat') ? ' is-invalid' : ''), 'placeholder' => 'Idkat']) }}
            {!! $errors->first('idKat', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Snimi</button>
    </div>
</div>

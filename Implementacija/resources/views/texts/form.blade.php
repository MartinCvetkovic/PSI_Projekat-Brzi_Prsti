<div class="box box-info padding-1">
    <div class="box-body">

        {{ Form::hidden('id', $tekst->id, array('id' => $tekst->id)) }}

        <div class="form-group">
            <label for="sadrzaj">Sadržaj</label>
            {{ Form::textarea('sadrzaj', $tekst->sadrzaj, ['class' => 'form-control' . ($errors->has('sadrzaj') ? ' is-invalid' : ''), 'placeholder' => 'Sadržaj']) }}
            {!! $errors->first('sadrzaj', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            <label for="tezina">Težina</label>
            {{ Form::text('tezina', $tekst->tezina, ['class' => 'form-control' . ($errors->has('tezina') ? ' is-invalid' : ''), 'placeholder' => 'Tezina']) }}
            {!! $errors->first('tezina', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('idKat', 'Kategorija:')}}
            {!! Form::select('idKat', $kategorije, null, ['class' => 'form-control']) !!}
            {!! $errors->first('idKat', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <br>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Snimi</button>
    </div>
</div>

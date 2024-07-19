<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $nivelesDo?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_niveles_uno" class="form-label">{{ __('Id Niveles Uno') }}</label>
            <input type="text" name="id_niveles_uno" class="form-control @error('id_niveles_uno') is-invalid @enderror" value="{{ old('id_niveles_uno', $nivelesDo?->id_niveles_uno) }}" id="id_niveles_uno" placeholder="Id Niveles Uno">
            {!! $errors->first('id_niveles_uno', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
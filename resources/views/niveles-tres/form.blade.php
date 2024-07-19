<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $nivelesTre?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_niveles_dos" class="form-label">{{ __('Id Niveles Dos') }}</label>
            <input type="text" name="id_niveles_dos" class="form-control @error('id_niveles_dos') is-invalid @enderror" value="{{ old('id_niveles_dos', $nivelesTre?->id_niveles_dos) }}" id="id_niveles_dos" placeholder="Id Niveles Dos">
            {!! $errors->first('id_niveles_dos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_referencias_gastos" class="form-label">{{ __('Id Referencias Gastos') }}</label>
            <input type="text" name="id_referencias_gastos" class="form-control @error('id_referencias_gastos') is-invalid @enderror" value="{{ old('id_referencias_gastos', $nivelesTre?->id_referencias_gastos) }}" id="id_referencias_gastos" placeholder="Id Referencias Gastos">
            {!! $errors->first('id_referencias_gastos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
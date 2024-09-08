<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="nit" class="form-label">{{ __('Nit') }}</label>
            <input type="text" name="nit" class="form-control @error('nit') is-invalid @enderror"
                value="{{ old('nit', $tercero?->nit) }}" id="nit" placeholder="Nit">
            {!! $errors->first('nit', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="tipo_factura" class="form-label">{{ __('Tipo Factura') }}</label>
            <input type="text" name="tipo_factura" class="form-control @error('tipo_factura') is-invalid @enderror"
                value="{{ old('tipo_factura', $tercero?->tipo_factura) }}" id="tipo_factura" placeholder="Tipo Factura">
            {!! $errors->first('tipo_factura', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $tercero?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Crear') }}</button>
    </div>
</div>

<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="fecha_recepcion_factura" class="form-label">{{ __('Fecha Recepcion Factura') }}</label>
            <input type="text" name="fecha_recepcion_factura"
                class="form-control @error('fecha_recepcion_factura') is-invalid @enderror"
                value="{{ old('fecha_recepcion_factura', $entrada?->fecha_recepcion_factura) }}"
                id="fecha_recepcion_factura" placeholder="Fecha Recepcion Factura">
            {!! $errors->first(
                'fecha_recepcion_factura',
                '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
            ) !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="adjunto" class="form-label">{{ __('Adjunto') }}</label>
            <input type="text" name="adjunto" class="form-control @error('adjunto') is-invalid @enderror"
                value="{{ old('adjunto', $entrada?->adjunto) }}" id="adjunto" placeholder="Adjunto">
            {!! $errors->first('adjunto', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="numero" class="form-label">{{ __('Numero') }}</label>
            <input type="text" name="numero" class="form-control @error('numero') is-invalid @enderror"
                value="{{ old('numero', $entrada?->numero) }}" id="numero" placeholder="Numero">
            {!! $errors->first('numero', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_users" class="form-label">{{ __('Id Users') }}</label>
            <input type="text" name="id_users" class="form-control @error('id_users') is-invalid @enderror"
                value="{{ old('id_users', $entrada?->id_users) }}" id="id_users" placeholder="Id Users">
            {!! $errors->first('id_users', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha" class="form-label">{{ __('Fecha') }}</label>
            <input type="text" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                value="{{ old('fecha', $entrada?->fecha) }}" id="fecha" placeholder="Fecha">
            {!! $errors->first('fecha', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="estado" class="form-label">{{ __('Estado') }}</label>
            <input type="text" name="estado" class="form-control @error('estado') is-invalid @enderror"
                value="{{ old('estado', $entrada?->estado) }}" id="estado" placeholder="Estado">
            {!! $errors->first('estado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Crear') }}</button>
    </div>
</div>

<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="fecha_solicitud" class="form-label">{{ __('Fecha Solicitud') }}</label>
            <input type="text" name="fecha_solicitud" class="form-control @error('fecha_solicitud') is-invalid @enderror" value="{{ old('fecha_solicitud', $solicitudCompra?->fecha_solicitud) }}" id="fecha_solicitud" placeholder="Fecha Solicitud">
            {!! $errors->first('fecha_solicitud', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $solicitudCompra?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="area" class="form-label">{{ __('Area') }}</label>
            <input type="text" name="area" class="form-control @error('area') is-invalid @enderror" value="{{ old('area', $solicitudCompra?->area) }}" id="area" placeholder="Area">
            {!! $errors->first('area', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="tipo_factura" class="form-label">{{ __('Tipo Factura') }}</label>
            <input type="text" name="tipo_factura" class="form-control @error('tipo_factura') is-invalid @enderror" value="{{ old('tipo_factura', $solicitudCompra?->tipo_factura) }}" id="tipo_factura" placeholder="Tipo Factura">
            {!! $errors->first('tipo_factura', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="prefijo" class="form-label">{{ __('Prefijo') }}</label>
            <input type="text" name="prefijo" class="form-control @error('prefijo') is-invalid @enderror" value="{{ old('prefijo', $solicitudCompra?->prefijo) }}" id="prefijo" placeholder="Prefijo">
            {!! $errors->first('prefijo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="cantidad" class="form-label">{{ __('Cantidad') }}</label>
            <input type="text" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad', $solicitudCompra?->cantidad) }}" id="cantidad" placeholder="Cantidad">
            {!! $errors->first('cantidad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nota" class="form-label">{{ __('Nota') }}</label>
            <input type="text" name="nota" class="form-control @error('nota') is-invalid @enderror" value="{{ old('nota', $solicitudCompra?->nota) }}" id="nota" placeholder="Nota">
            {!! $errors->first('nota', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_centro_costo" class="form-label">{{ __('Id Centro Costo') }}</label>
            <input type="text" name="id_centro_costo" class="form-control @error('id_centro_costo') is-invalid @enderror" value="{{ old('id_centro_costo', $solicitudCompra?->id_centro_costo) }}" id="id_centro_costo" placeholder="Id Centro Costo">
            {!! $errors->first('id_centro_costo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_referencia_gastos" class="form-label">{{ __('Id Referencia Gastos') }}</label>
            <input type="text" name="id_referencia_gastos" class="form-control @error('id_referencia_gastos') is-invalid @enderror" value="{{ old('id_referencia_gastos', $solicitudCompra?->id_referencia_gastos) }}" id="id_referencia_gastos" placeholder="Id Referencia Gastos">
            {!! $errors->first('id_referencia_gastos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
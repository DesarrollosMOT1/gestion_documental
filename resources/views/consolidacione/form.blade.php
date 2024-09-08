<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="id_solicitudes_compras" class="form-label">{{ __('Id Solicitudes Compras') }}</label>
            <input type="text" name="id_solicitudes_compras"
                class="form-control @error('id_solicitudes_compras') is-invalid @enderror"
                value="{{ old('id_solicitudes_compras', $consolidacione?->id_solicitudes_compras) }}"
                id="id_solicitudes_compras" placeholder="Id Solicitudes Compras">
            {!! $errors->first(
                'id_solicitudes_compras',
                '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
            ) !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_solicitud_elemento" class="form-label">{{ __('Id Solicitud Elemento') }}</label>
            <input type="text" name="id_solicitud_elemento"
                class="form-control @error('id_solicitud_elemento') is-invalid @enderror"
                value="{{ old('id_solicitud_elemento', $consolidacione?->id_solicitud_elemento) }}"
                id="id_solicitud_elemento" placeholder="Id Solicitud Elemento">
            {!! $errors->first(
                'id_solicitud_elemento',
                '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
            ) !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="estado" class="form-label">{{ __('Estado') }}</label>
            <input type="text" name="estado" class="form-control @error('estado') is-invalid @enderror"
                value="{{ old('estado', $consolidacione?->estado) }}" id="estado" placeholder="Estado">
            {!! $errors->first('estado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="cantidad" class="form-label">{{ __('Cantidad') }}</label>
            <input type="text" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror"
                value="{{ old('cantidad', $consolidacione?->cantidad) }}" id="cantidad" placeholder="Cantidad">
            {!! $errors->first('cantidad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Crear') }}</button>
    </div>
</div>

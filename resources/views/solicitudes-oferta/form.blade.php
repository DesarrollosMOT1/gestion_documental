<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="fecha_solicitud_oferta" class="form-label">{{ __('Fecha Solicitud Oferta') }}</label>
            <input type="text" name="fecha_solicitud_oferta" class="form-control @error('fecha_solicitud_oferta') is-invalid @enderror" value="{{ old('fecha_solicitud_oferta', $solicitudesOferta?->fecha_solicitud_oferta) }}" id="fecha_solicitud_oferta" placeholder="Fecha Solicitud Oferta">
            {!! $errors->first('fecha_solicitud_oferta', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_users" class="form-label">{{ __('Id Users') }}</label>
            <input type="text" name="id_users" class="form-control @error('id_users') is-invalid @enderror" value="{{ old('id_users', $solicitudesOferta?->id_users) }}" id="id_users" placeholder="Id Users">
            {!! $errors->first('id_users', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_terceros" class="form-label">{{ __('Id Terceros') }}</label>
            <input type="text" name="id_terceros" class="form-control @error('id_terceros') is-invalid @enderror" value="{{ old('id_terceros', $solicitudesOferta?->id_terceros) }}" id="id_terceros" placeholder="Id Terceros">
            {!! $errors->first('id_terceros', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
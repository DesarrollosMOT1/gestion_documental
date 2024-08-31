<!-- Formulario en solicitudes-oferta.create -->
<form id="solicitudOfertaForm" method="POST" action="{{ route('solicitudes-ofertas.store') }}">
    @csrf
    <!-- Información General -->
    <div class="form-group mb-2 mb20">
        <label for="fecha_solicitud_oferta" class="form-label">{{ __('Fecha Solicitud de Oferta') }}</label>
        <input type="date" name="fecha_solicitud_oferta" class="form-control @error('fecha_solicitud_oferta') is-invalid @enderror" value="{{ old('fecha_solicitud_oferta') }}" id="fecha_solicitud_oferta">
        {!! $errors->first('fecha_solicitud_oferta', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
    </div>
    <div class="form-group mb-2 mb20">
        <label for="id_users" class="form-label">{{ __('Usuario') }}</label>
        <select name="id_users" id="id_users" class="form-control @error('id_users') is-invalid @enderror">
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('id_users') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('id_users', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
    </div>
    <div class="form-group mb-2 mb20">
        <label for="id_terceros" class="form-label">{{ __('Tercero') }}</label>
        <select name="id_terceros" id="id_terceros" class="form-control select2 @error('id_terceros') is-invalid @enderror">
            <option value="">{{ __('Seleccione una opción') }}</option>
            @foreach($terceros as $tercero)
                <option value="{{ $tercero->nit }}" {{ old('id_terceros') == $tercero->nit ? 'selected' : '' }}>
                    {{ $tercero->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('id_terceros', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
    </div>
    <h4 class="mb-3">Elementos a Solicitar</h4>
    <!-- Contenedor para los elementos dinámicos -->
    <div id="formularioSolicitudOfertaContainer" class="row"></div>

    <!-- Botón para generar la solicitud de oferta -->
    <button id="btnEnviar" type="submit" class="btn btn-primary">
        {{ __('Submit') }}
    </button>
</form>

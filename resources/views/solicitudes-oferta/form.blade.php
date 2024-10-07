<!-- Información General -->
<div class="form-group mb-2 mb20">
    <label for="fecha_solicitud_oferta" class="form-label">{{ __('Fecha Solicitud de Oferta') }}</label>
    <input type="date" name="fecha_solicitud_oferta" class="form-control @error('fecha_solicitud_oferta') is-invalid @enderror" value="{{ old('fecha_solicitud_oferta') }}" id="fecha_solicitud_oferta" required>
    {!! $errors->first('fecha_solicitud_oferta', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>

<div class="form-group mb-2 mb20">
    <label for="id_users" class="form-label">{{ __('Usuario') }}</label>
    <select name="id_users" id="id_users" class="form-control @error('id_users') is-invalid @enderror" required>
        <option value="" disabled selected>{{ __('Selecciona un usuario') }}</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('id_users') == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('id_users', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>

<div class="form-group mb-2 mb20">
    <label for="terceros" class="form-label">{{ __('Terceros') }}</label>
    <select name="terceros[]" id="terceros" size="5" class="form-control select2 @error('terceros') is-invalid @enderror" multiple required>
        @foreach($terceros as $tercero)
            <option value="{{ $tercero->nit }}" {{ collect(old('terceros'))->contains($tercero->nit) ? 'selected' : '' }}>
                {{ $tercero->nombre }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('terceros', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>

<h4 class="mb-3">Elementos a Solicitar</h4>
<!-- Contenedor para los elementos dinámicos -->
<div id="formularioSolicitudOfertaContainer" class="row g-3"></div>

<!-- Botón para generar la solicitud de oferta -->
<button id="btnEnviar" type="submit" class="btn btn-primary" disabled>
    {{ __('Submit') }}
</button>
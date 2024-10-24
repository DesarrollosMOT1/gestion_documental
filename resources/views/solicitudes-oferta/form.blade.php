<!-- Información General -->
<h4 class="mb-3">Información General</h4>
<div class="form-group mb-2 mb20">
    <label for="fecha_solicitud_oferta" class="form-label">{{ __('Fecha Solicitud de Oferta') }}</label>
    <x-campo-fecha nombre="fecha_solicitud_oferta" :valor="old('fecha_solicitud_oferta')" :errores="$errors" />
</div>

<div class="form-group mb-2 mb20">
    <label for="id_users" class="form-label">{{ __('Usuario') }}</label>
    <x-select-user nombre="id_users" :errores="$errors" />
</div>

<div class="form-group mb-2 mb20">
    <label for="terceros" class="form-label">{{ __('Terceros') }}</label>
    <select name="terceros[]" id="terceros" size="5" class="form-control select2 @error('terceros') is-invalid @enderror" multiple required>
        @foreach($terceros as $tercero)
            <option value="{{ $tercero->id }}" {{ collect(old('terceros'))->contains($tercero->id) ? 'selected' : '' }}>
                {{ $tercero->nit }} - {{ $tercero->nombre }}
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
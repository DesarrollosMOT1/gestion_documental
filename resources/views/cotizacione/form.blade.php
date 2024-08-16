<!-- Pestañas -->
<ul class="nav nav-tabs" id="formTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Información General</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Solicitudes Seleccionadas</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Elementos de las Solicitudes</a>
    </li>
</ul>

<!-- Contenido de las pestañas -->
<div class="tab-content" id="formTabsContent">
    <!-- Información General -->
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        <div class="form-group mb-2">
            <label for="fecha_cotizacion" class="form-label">{{ __('Fecha Cotizacion') }}</label>
            <input type="date" name="fecha_cotizacion" class="form-control @error('fecha_cotizacion') is-invalid @enderror" value="{{ old('fecha_cotizacion', $fechaActual) }}" id="fecha_cotizacion" placeholder="Fecha Cotizacion">
            {!! $errors->first('fecha_cotizacion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $cotizacione?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2">
            <label for="valor" class="form-label">{{ __('Valor') }}</label>
            <input type="text" name="valor" class="form-control @error('valor') is-invalid @enderror" value="{{ old('valor', $cotizacione?->valor) }}" id="valor" placeholder="Valor" readonly>
            {!! $errors->first('valor', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2">
            <label for="condiciones_pago" class="form-label">{{ __('Condiciones Pago') }}</label>
            <select name="condiciones_pago" class="form-control @error('condiciones_pago') is-invalid @enderror" id="condiciones_pago">
                <option value="">{{ __('Seleccione una opción') }}</option>
                <option value="30 días" {{ old('condiciones_pago', $cotizacione?->condiciones_pago) == '30 días' ? 'selected' : '' }}>30 días</option>
                <option value="contado" {{ old('condiciones_pago', $cotizacione?->condiciones_pago) == 'contado' ? 'selected' : '' }}>Contado</option>
                <option value="crédito" {{ old('condiciones_pago', $cotizacione?->condiciones_pago) == 'crédito' ? 'selected' : '' }}>Crédito</option>
            </select>
            {!! $errors->first('condiciones_pago', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>        
        <div class="form-group mb-2">
            <label for="descuento" class="form-label">{{ __('Descuento') }}</label>
            <input type="number" name="descuento" class="form-control @error('descuento') is-invalid @enderror" value="{{ old('descuento', $cotizacione?->descuento) }}" id="descuento" placeholder="Descuento">
            {!! $errors->first('descuento', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2">
            <label for="id_terceros" class="form-label">{{ __('Tercero') }}</label>
            <select name="id_terceros" class="form-control @error('id_terceros') is-invalid @enderror" id="id_terceros">
                <option value="" disabled selected>Seleccione un tercero</option>
                @foreach($terceros as $tercero)
                    <option value="{{ $tercero->nit }}" {{ old('id_terceros', $cotizacione?->id_terceros) == $tercero->nit ? 'selected' : '' }}>
                        {{ $tercero->nombre }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('id_terceros', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha_inicio_vigencia" class="form-label">{{ __('Fecha Inicio Vigencia') }}</label>
            <input type="text" name="fecha_inicio_vigencia" class="form-control @error('fecha_inicio_vigencia') is-invalid @enderror" value="{{ old('fecha_inicio_vigencia', $cotizacione?->fecha_inicio_vigencia) }}" id="fecha_inicio_vigencia" placeholder="Fecha Inicio Vigencia">
            {!! $errors->first('fecha_inicio_vigencia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha_fin_vigencia" class="form-label">{{ __('Fecha Fin Vigencia') }}</label>
            <input type="text" name="fecha_fin_vigencia" class="form-control @error('fecha_fin_vigencia') is-invalid @enderror" value="{{ old('fecha_fin_vigencia', $cotizacione?->fecha_fin_vigencia) }}" id="fecha_fin_vigencia" placeholder="Fecha Fin Vigencia">
            {!! $errors->first('fecha_fin_vigencia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <!-- Solicitudes Seleccionadas -->
    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
        <div class="col-md-12 mt-4">
            <h6>Solicitudes seleccionadas:</h6>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Prefijo</th>
                        <th>Descripción</th>
                        <th>Fecha Solicitud</th>
                    </tr>
                </thead>
                <tbody id="solicitudes_seleccionadas_tabla">
                    <!-- Aquí se cargarán dinámicamente las solicitudes seleccionadas -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Elementos de las Solicitudes -->
    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
        <div id="elementos_container" class="col-md-12 mt-4">
            <h6>Elementos de las solicitudes:</h6>
            <!-- Aquí se cargarán dinámicamente los elementos de la solicitud -->
        </div>
    </div>
</div>

<!-- Botón de envío -->
<div class="col-md-12 mt20 mt-2">
    <button id="btnEnviar" type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
</div>

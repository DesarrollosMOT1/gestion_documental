<div class="row padding-1 p-1">
    <div class="col-md-6">
        <h4 class="mb-3">Información General</h4>
        <div class="form-group mb-2 mb20">
            <label for="fecha_solicitud" class="form-label">{{ __('Fecha Solicitud') }}</label>
            <input type="date" name="fecha_solicitud" class="form-control @error('fecha_solicitud') is-invalid @enderror" value="{{ old('fecha_solicitud', $fechaActual, $solicitudesCompra?->fecha_solicitud) }}" id="fecha_solicitud" placeholder="Fecha Solicitud">
            {!! $errors->first('fecha_solicitud', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="id_users" class="form-label">{{ __('Usuario') }}</label>
            <select name="id_users" class="form-control @error('id_users') is-invalid @enderror" id="id_users">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('id_users', $solicitudesCompra?->id_users) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            {!! $errors->first('id_users', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="prefijo" class="form-label">{{ __('Prefijo') }}</label>
            <input type="text" name="prefijo" class="form-control @error('prefijo') is-invalid @enderror" value="{{ old('prefijo', $solicitudesCompra?->prefijo) }}" id="prefijo" placeholder="Prefijo" readonly>
            {!! $errors->first('prefijo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="descripcion" class="form-label">{{ __('Descripción') }}</label>
            <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion', $solicitudesCompra?->descripcion) }}" id="descripcion" placeholder="Descripción">
            {!! $errors->first('descripcion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>

    <div class="col-md-6">
        <h4 class="mb-3">Elementos de la Solicitud</h4>
        <div class="form-group mb-2 mb20">
            <label for="reset_options" class="form-label">{{ __('Opciones de limpieza de campos') }}</label>
            <select id="reset_options" class="form-control">
                <option value="all">Limpiar todos los campos</option>
                <option value="partial">Limpiar sólo cantidad y centro de costos</option>
                <option value="none">No limpiar campos</option>
            </select>
        </div>        
        <div class="form-group mb-2 mb20">
            <label for="select_niveles_uno" class="form-label">{{ __('Nivel Uno') }}</label>
            <select id="select_niveles_uno" class="form-control">
                <option selected>Seleccione una opción</option>
                @foreach($nivelesUno as $nivelUno)
                    <option value="{{ $nivelUno->id }}">{{ $nivelUno->nombre }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="select_niveles_dos" class="form-label">{{ __('Nivel Dos') }}</label>
            <select id="select_niveles_dos" class="form-control">
                <option selected>Seleccione una opción</option>
            </select>
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="select_niveles_tres" class="form-label">{{ __('Nivel Tres') }}</label>
            <select id="select_niveles_tres" name="id_niveles_tres" class="form-control">
                <option selected>Seleccione una opción</option>
            </select>
        </div>        

        <div class="form-group mb-2 mb20">
            <label for="select_id_centros_costos" class="form-label">{{ __('Centros Costos') }}</label>
            <select id="select_id_centros_costos" class="form-control select2">
                <option selected>Seleccione una opción</option>
                @foreach($centrosCostos as $centroCosto)
                <option value="{{ $centroCosto->id }}">{{ $centroCosto->codigo_mekano }} - {{ $centroCosto->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-2 mb20">
            <label for="input_cantidad" class="form-label">{{ __('Cantidad Unidad') }}</label>
            <input type="number" id="input_cantidad" class="form-control" placeholder="Cantidad Unidad">
        </div>

        <button type="button" id="addElement" class="btn btn-secondary mb-3">
            <i class="fas fa-plus"></i> {{ __('Agregar Elemento') }}
        </button>

        <!-- Tabla para mostrar los elementos agregados -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('Elemento') }}</th>
                        <th>{{ __('Centro Costo') }}</th>
                        <th>{{ __('Cantidad Unidad') }}</th>
                        <th>{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody id="elementsTableBody">
                    <tr id="noElementsRow">
                        <td colspan="4" class="text-center text-muted">{{ __('No hay elementos agregados') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-12 mt20 mt-2">
    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
</div>
<div class="row padding-1 p-1">
    <div class="col-md-6">
        <div class="form-group mb-2 mb20">
            <label for="fecha_solicitud" class="form-label">{{ __('Fecha Solicitud') }}</label>
            <input type="date" name="fecha_solicitud" class="form-control @error('fecha_solicitud') is-invalid @enderror" value="{{ old('fecha_solicitud', $solicitudesCompra?->fecha_solicitud) }}" id="fecha_solicitud" placeholder="Fecha Solicitud">
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

        <div class="form-group mb-2 mb20">
            <label for="estado_solicitud" class="form-label">{{ __('Estado Solicitud') }}</label>
            <input type="text" name="estado_solicitud" class="form-control @error('estado_solicitud') is-invalid @enderror" value="{{ old('estado_solicitud', $solicitudesCompra?->estado_solicitud) }}" id="estado_solicitud" placeholder="Estado Solicitud">
            {!! $errors->first('estado_solicitud', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="fecha_estado" class="form-label">{{ __('Fecha Estado') }}</label>
            <input type="date" name="fecha_estado" class="form-control @error('fecha_estado') is-invalid @enderror" value="{{ old('fecha_estado', $solicitudesCompra?->fecha_estado) }}" id="fecha_estado" placeholder="Fecha Estado">
            {!! $errors->first('fecha_estado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-2 mb20">
            <label for="select_id_niveles_tres" class="form-label">{{ __('Niveles Tres') }}</label>
            <select id="select_id_niveles_tres" class="form-control">
                <option selected>Seleccione una opción</option>
                @foreach($nivelesTres as $nivelTres)
                    <option value="{{ $nivelTres->id }}">{{ $nivelTres->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-2 mb20">
            <label for="select_id_centros_costos" class="form-label">{{ __('Centros Costos') }}</label>
            <select id="select_id_centros_costos" class="form-control">
                <option selected>Seleccione una opción</option>
                @foreach($centrosCostos as $centroCosto)
                    <option value="{{ $centroCosto->codigo }}">{{ $centroCosto->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-2 mb20">
            <label for="input_cantidad" class="form-label">{{ __('Cantidad') }}</label>
            <input type="number" id="input_cantidad" class="form-control" placeholder="Cantidad">
        </div>

        <button type="button" id="addElement" class="btn btn-secondary">{{ __('Agregar Elemento') }}</button>

        <!-- Tabla para mostrar los elementos agregados -->
        <div class="table-responsive mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('Elemento') }}</th>
                        <th>{{ __('Centro Costo') }}</th>
                        <th>{{ __('Cantidad') }}</th>
                        <th>{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody id="elementsTableBody">
                    <!-- Mensaje cuando no hay elementos -->
                    <tr id="noElementsRow">
                        <td colspan="5" class="text-center text-muted">{{ __('No hay elementos agregados') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-12 mt20 mt-2">
    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
</div>

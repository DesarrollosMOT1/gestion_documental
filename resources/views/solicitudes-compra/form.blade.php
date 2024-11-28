<div class="row padding-1 p-1">
    <div class="col-md-6">
        <h4 class="mb-3">Información General</h4>
        <div class="form-group mb-2 mb20">
            <label for="fecha_solicitud" class="form-label">{{ __('Fecha Solicitud') }}</label>
            <x-campo-fecha nombre="fecha_solicitud" :valor="$solicitudesCompra?->fecha_solicitud" :errores="$errors" />
        </div>

        <div class="form-group mb-2 mb20">
            <label for="id_users" class="form-label">{{ __('Usuario') }}</label>
            <x-select-user nombre="id_users" :errores="$errors" />
        </div>

        <div class="form-group mb-2 mb20">
            <label for="prefijo" class="form-label">{{ __('Prefijo') }}</label>
            <input type="text" name="prefijo" class="form-control @error('prefijo') is-invalid @enderror" value="{{ old('prefijo', $solicitudesCompra?->prefijo) }}" id="prefijo" placeholder="Prefijo" readonly>
            {!! $errors->first('prefijo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="descripcion" class="form-label">{{ __('Descripción') }}</label>
            <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion', $solicitudesCompra?->descripcion) }}" id="descripcion" placeholder="Descripción" required>
            {!! $errors->first('descripcion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>

    <div class="col-md-6">
        <h4 class="mb-3">Elementos de la Solicitud</h4>
        <div class="form-group mb-2 mb20">
            <label for="reset_options" class="form-label">{{ __('Opciones de limpieza de campos') }}</label>
            <select id="reset_options" class="form-control">
                <option value="all">Limpiar todos los campos</option>
                <option value="partial">Limpiar sólo cantidad,centro de costos y descripción</option>
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

        <div class="form-group mb-2 mb20">
            <label for="input_descripcion" class="form-label">{{ __('Descripción') }}</label>
            <textarea id="input_descripcion" class="form-control" placeholder="Descripción (opcional)" maxlength="255"></textarea>
            <div id="contador_caracteres" class="text-muted">0 / 255</div>
        </div>

        <button type="button" id="addElement" class="btn btn-secondary mb-3">
            <i class="fas fa-plus"></i> {{ __('Agregar Elemento') }}
        </button>

        <!-- Tabla para mostrar los elementos agregados -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th class="align-middle" style="min-width: 150px">{{ __('Elemento') }}</th>
                        <th class="align-middle" style="min-width: 150px">{{ __('Centro Costo') }}</th>
                        <th class="align-middle" style="min-width: 120px">{{ __('Cantidad Unidad') }}</th>
                        <th class="align-middle" style="min-width: 300px">{{ __('Descripción') }}</th>
                        <th class="align-middle" style="min-width: 100px">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody id="elementsTableBody">
                    @if ($elementsWithNames)
                        @foreach ($elementsWithNames as $index => $element)
                            <tr id="element-{{ $index }}">
                                <td class="align-middle text-break">{{ $element['nombre_nivel_tres'] }}</td>
                                <td class="align-middle text-break">{{ $element['nombre_centro_costo'] }}</td>
                                <td class="align-middle text-center">{{ $element['cantidad'] }}</td>
                                <td class="align-middle">
                                    <div class="text-break">{{ $element['descripcion'] }}</div>
                                </td>
                                <td class="align-middle text-center">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeElement({{ $index }})">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </td>
                                <input type="hidden" name="elements[{{ $index }}][id_niveles_tres]" value="{{ $element['id_niveles_tres'] }}">
                                <input type="hidden" name="elements[{{ $index }}][id_centros_costos]" value="{{ $element['id_centros_costos'] }}">
                                <input type="hidden" name="elements[{{ $index }}][cantidad]" value="{{ $element['cantidad'] }}">
                                <input type="hidden" name="elements[{{ $index }}][descripcion]" value="{{ $element['descripcion'] }}">
                            </tr>
                        @endforeach
                    @else
                        <tr id="noElementsRow">
                            <td colspan="5" class="text-center text-muted">{{ __('No hay elementos agregados') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-12 mt20 mt-2">
    <button type="submit" id="submitForm" class="btn btn-primary">{{ __('Submit') }}</button>
</div>
<div class="container-fluid">
    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#productoModal">
        {{ __('Agregar Registro') }}
    </button>

    <!-- Tabla para mostrar los productos agregados -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>{{ __('Producto') }}</th>
                    <th>{{ __('Unidad') }}</th>
                    <th>{{ __('Cantidad') }}</th>
                    <th>{{ __('Cliente') }}</th>
                    <th>{{ __('Motivo') }}</th>
                    <th>{{ __('Detalle Registro') }}</th>
                    <th>{{ __('Acciones') }}</th>
                </tr>
            </thead>
            <tbody id="productosTabla">
                <!-- Aquí se insertarán dinámicamente las filas -->
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar productos -->
    <div class="modal fade" id="productoModal" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productoModalLabel">{{ __('Crear Producto') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="productoForm">
                        <x-drop-down-input name="producto" route="{{ route('productos.get-all') }}" />
                        <x-drop-down-input name="unidad" route="{{ route('unidades.get-all') }}" />
                        <div class="form-group mb-3">
                            <label for="cantidad" class="form-label">{{ __('Cantidad') }}</label>
                            <input type="number" name="cantidad" class="form-control" id="cantidad" required
                                min="1" step="1">
                        </div>
                        <x-drop-down-input name="tercero" route="{{ route('terceros-tests.get-all') }}" />
                        <input type="hidden" name="movimiento" class="form-control" id="movimiento" value=" "
                            required>
                        <x-drop-down-input name="motivo" route="{{ route('motivos.get-all') }}" />
                        <div class="form-group mb-3">
                            <label for="detalle_registro" class="form-label">{{ __('Detalle de Registro') }}</label>
                            <textarea name="detalle_registro" class="form-control @error('detalle_registro') is-invalid @enderror"
                                id="detalle_registro" required>{{ old('detalle_registro') }}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('Cerrar') }}</button>
                            <button type="submit" class="btn btn-success"
                                id="guardarProducto">{{ __('Guardar Producto') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let registros = [];

    function actualizarTabla() {
        const tabla = document.getElementById('productosTabla');
        tabla.innerHTML = '';

        registros.forEach((registro, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${registro.producto}</td>
                <td>${registro.unidad}</td>
                <td>${registro.cantidad}</td>
                <td>${registro.tercero}</td>
                <td>${registro.motivo}</td>
                <td>${registro.detalle_registro}</td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="eliminarRegistro(${index})">{{ __('Eliminar') }}</button>
                </td>
            `;
            tabla.appendChild(row);
        });

        // Actualiza el input oculto en la vista de crear movimiento
        const registrosInput = window.document.getElementById('registrosInput');
        if (registrosInput) {
            registrosInput.value = JSON.stringify(registros);
        }
    }

    function guardarRegistro(registro) {
        registros.push(registro);
        actualizarTabla();
    }

    function eliminarRegistro(index) {
        registros.splice(index, 1);
        actualizarTabla();
    }

    document.getElementById('productoForm').addEventListener('submit', (event) => {
        event.preventDefault();

        const form = document.getElementById('productoForm');
        const formData = new FormData(form);
        const registro = Object.fromEntries(formData.entries());

        if (registro.producto && registro.unidad && registro.cantidad && registro.tercero && registro
            .movimiento && registro.motivo && registro.detalle_registro) {
            guardarRegistro(registro);

            form.reset();
            $('#productoModal').modal('hide');
        } else {
            alert('Por favor, complete todos los campos del formulario.');
        }
    });
</script>

$(document).ready(function() {
    // Manejar la selección de todas las solicitudes
    $('#select_all').change(function() {
        $('.select_item').prop('checked', $(this).prop('checked'));
        actualizarSolicitudesYElementos();
    });

    // Manejar la selección individual de solicitudes
    $('.select_item').change(function() {
        actualizarSolicitudesYElementos();
        toggleGenerateButton();
    });

    // Función para actualizar las solicitudes seleccionadas y cargar los elementos
    function actualizarSolicitudesYElementos() {
        var solicitudesSeleccionadas = $('.select_item:checked').map(function() {
            return {
                id: $(this).val(),
                prefijo: $(this).closest('tr').find('td:eq(4)').text(),
                descripcion: $(this).closest('tr').find('td:eq(5)').text(),
                fecha_solicitud: $(this).closest('tr').find('td:eq(2)').text()
            };
        }).get();

        // Actualizar la tabla de solicitudes seleccionadas
        var tablaSolicitudes = '';
        solicitudesSeleccionadas.forEach(function(solicitud) {
            tablaSolicitudes += `
                <tr>
                    <td>${solicitud.prefijo}</td>
                    <td>${solicitud.descripcion}</td>
                    <td>${solicitud.fecha_solicitud}</td>
                </tr>
            `;
        });
        $('#solicitudes_seleccionadas_tabla').html(tablaSolicitudes);

        // Cargar los elementos de las solicitudes seleccionadas
        if (solicitudesSeleccionadas.length > 0) {
            $.ajax({
                url: '/get-elementos-multiple',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    solicitudes: solicitudesSeleccionadas.map(s => s.id)
                },
                success: function(data) {
                    if (data.length > 0) {
                        var html = '';
                        data.forEach(function(elemento, index) {
                            var impuestosOptions = impuestos.map(function(impuesto) {
                                return `<option value="${impuesto.id}">${impuesto.tipo}</option>`;
                            }).join('');
                            html += `
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <input type="hidden" name="elementos[${index}][id_solicitud_elemento]" value="${elemento.id}">
                                        <input type="hidden" name="elementos[${index}][id_solicitudes_compras]" value="${elemento.id_solicitudes_compra}">
                                        <label for="NombreElemento" class="form-label">Elemento: ${elemento.niveles_tres.nombre}</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Cantidad" class="form-label">Cantidad</label>
                                        <input type="number" name="elementos[${index}][cantidad]" class="form-control" placeholder="Cantidad" value="${elemento.cantidad}" required>
                                    </div>
                                    <div class="col-md-3">
                                    <label for="Impuestos" class="form-label">Impuestos</label>
                                        <select name="elementos[${index}][id_impuestos]" class="form-control" required>
                                            <option value="">Seleccione un impuesto</option>
                                            ${impuestosOptions}
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Precio" class="form-label">Precio Unitario</label>
                                        <input type="number" step="0.01" name="elementos[${index}][precio]" class="form-control" placeholder="Precio" required>
                                    </div>
                                </div>
                            `;
                        });
                        $('#elementos_container').html(html);
                        $('#btnGenerarCotizacion').prop('disabled', false);
                    } else {
                        $('#elementos_container').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Atención!</strong> No se pueden generar cotizaciones porque las solicitudes seleccionadas no tienen elementos aprobados.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                        $('#btnEnviar').prop('disabled', true);
                    }
                }
            });
        } else {
            $('#elementos_container').html('');
            $('#btnGenerarCotizacion').prop('disabled', true);
        }
    }

    // Función para habilitar o deshabilitar el botón de Generar Cotización
    function toggleGenerateButton() {
        var checkedItems = $('.select_item:checked').length > 0;
        $('#btnGenerarCotizacion').prop('disabled', !checkedItems);
    }

    // Abrir el modal
    $('#cotizacionModal').on('show.bs.modal', function (e) {
        actualizarSolicitudesYElementos();
    });
});

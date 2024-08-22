$(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Token CSRF

    // Obtener el ID de la agrupación 
    const agrupacionId = $('#agrupacion_id').val(); 

    // Eventos para los checkboxes de selección
    $('#select_all').change(function() {
        $('.select_item').prop('checked', $(this).prop('checked'));
        actualizarSolicitudesYElementos();
    });

    $('.select_item').change(function() {
        actualizarSolicitudesYElementos();
        toggleGenerateButton();
    });

    // Función principal para actualizar las solicitudes y sus elementos
    function actualizarSolicitudesYElementos() {
        const solicitudesSeleccionadas = obtenerSolicitudesSeleccionadas();
        actualizarTablaSolicitudes(solicitudesSeleccionadas);

        if (solicitudesSeleccionadas.length > 0) {
            obtenerElementos(solicitudesSeleccionadas);
        } else {
            limpiarFormularioConsolidacion();
            toggleGenerateButton(false);
        }
    }

    // Función para obtener las solicitudes seleccionadas
    function obtenerSolicitudesSeleccionadas() {
        return $('.select_item:checked').map(function() {
            return $(this).val();
        }).get();
    }

    // Actualizar la tabla de solicitudes consolidadas
    function actualizarTablaSolicitudes(solicitudes) {
        let tablaSolicitudes = '';
        $('.select_item:checked').closest('tr').each(function() {
            const prefijo = $(this).find('td:eq(4)').text();
            const descripcion = $(this).find('td:eq(5)').text();
            const fecha_solicitud = $(this).find('td:eq(2)').text();
            tablaSolicitudes += generarFilaTabla(prefijo, descripcion, fecha_solicitud);
        });
        $('#solicitudes_consolidadas_tabla').html(tablaSolicitudes);
    }

    // Generar una fila de la tabla de solicitudes
    function generarFilaTabla(prefijo, descripcion, fecha) {
        return `
            <tr>
                <td>${prefijo}</td>
                <td>${descripcion}</td>
                <td>${fecha}</td>
            </tr>
        `;
    }

    // Obtener elementos para las solicitudes seleccionadas
    function obtenerElementos(solicitudes) {
        $.ajax({
            url: '/get-elementos-multiple',
            type: 'POST',
            data: {
                _token: csrfToken,
                solicitudes: solicitudes
            },
            success: function(data) {
                actualizarFormularioConsolidacion(data);
            },
            error: function() {
                mostrarError('No se pueden generar consolidaciones porque las solicitudes seleccionadas no tienen elementos aprobados.');
                toggleGenerateButton(false);
            }
        });
    }

    // Actualizar el formulario de consolidación con los elementos obtenidos
    function actualizarFormularioConsolidacion(data) {
        let html = `
            <input type="hidden" name="agrupacion_id" value="${agrupacionId}">
        `;

        data.forEach(function(elemento, index) {
            html += generarElementoHTML(elemento, index);
        });

        $('#formularioConsolidacionContainer').html(html);

        // Agregar funcionalidad para eliminar elementos
        $('.btn-eliminar').on('click', function() {
            $(this).closest('.card').remove();
            toggleGenerateButton($('#formularioConsolidacionContainer .card').length > 0);
        });

        // Habilitar o deshabilitar el botón de enviar
        toggleGenerateButton($('#formularioConsolidacionContainer .card').length > 0);
    }

    // Generar HTML para cada elemento
    function generarElementoHTML(elemento, index) {
        return `
            <div class="col-md-6 col-lg-4">
                <div class="card p-2 mb-3">
                    <div class="card-body">
                        <input type="hidden" name="elementos[${index}][id_solicitud_elemento]" value="${elemento.id}">
                        <input type="hidden" name="elementos[${index}][id_solicitudes_compras]" value="${elemento.id_solicitudes_compra}">
                        <label class="form-label">Elemento: ${elemento.niveles_tres.nombre}</label>
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="elementos[${index}][cantidad]" class="form-control" placeholder="Cantidad" value="${elemento.cantidad}" required readonly>
                        <input type="hidden" name="elementos[${index}][estado]" value="0">
                        <button type="button" class="btn btn-danger btn-eliminar mt-2"><i class="fa fa-fw fa-trash"></i></button>
                    </div>
                </div>
            </div>
        `;
    }

    function mostrarError(mensaje) {
        $('#formularioConsolidacionContainer').html(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Atención!</strong> ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
    }

    function limpiarFormularioConsolidacion() {
        $('#formularioConsolidacionContainer').html('');
    }

    function toggleGenerateButton(enable) {
        $('#btnEnviar').prop('disabled', !enable);
        $('#btnGenerarConsolidacion').prop('disabled', !enable);
    }

    $('#consolidacionModal').on('show.bs.modal', function() {
        actualizarSolicitudesYElementos();
    });

    // Agregar SweetAlert2 para confirmación antes de enviar
    $('#btnEnviar').on('click', function(e) {
        e.preventDefault(); // Evitar el envío inmediato del formulario
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas crear esta consolidación?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, crear',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, enviar el formulario
                $(this).closest('form').submit();
            }
        });
    });
});

$(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Token CSRF

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
                toggleGenerateButton(true);
            },
            error: function() {
                mostrarError('No se pueden generar consolidaciones porque las solicitudes seleccionadas no tienen elementos aprobados.');
                toggleGenerateButton(false);
            }
        });
    }

    // Actualizar el formulario de consolidación con los elementos obtenidos
    function actualizarFormularioConsolidacion(data) {
        const userSelect = generarSelectUsuarios();
        let html = userSelect;

        data.forEach(function(elemento, index) {
            html += generarElementoHTML(elemento, index);
        });

        $('#formularioConsolidacionContainer').html(html);
        configurarEventoUserSelect();
    }

    // Generar HTML del select de usuarios
    function generarSelectUsuarios() {
        const usuariosOptions = usuarios.map(user => `<option value="${user.id}">${user.name}</option>`).join('');
        return `
            <div class="row mb-3">
                <label for="user_id" class="form-label">Usuario</label>
                <select id="userSelect" class="form-control">
                    ${usuariosOptions}
                </select>
            </div>
        `;
    }

    // Generar HTML para cada elemento
    function generarElementoHTML(elemento, index) {
        return `
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="hidden" name="elementos[${index}][id_solicitud_elemento]" value="${elemento.id}">
                    <input type="hidden" name="elementos[${index}][id_solicitudes_compras]" value="${elemento.id_solicitudes_compra}">
                    <label class="form-label">Elemento: ${elemento.niveles_tres.nombre}</label>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="elementos[${index}][cantidad]" class="form-control" placeholder="Cantidad" value="${elemento.cantidad}" required>
                </div>
                <input type="hidden" name="elementos[${index}][estado]" value="0">
            </div>
        `;
    }

    // Configurar evento de cambio del select de usuario
    function configurarEventoUserSelect() {
        $('#userSelect').change(function() {
            const selectedUserId = $(this).val();
            $('input[name^="elementos["][name$="[user_id]"]').val(selectedUserId);
        });
    }

    // Mostrar un mensaje de error en el formulario
    function mostrarError(mensaje) {
        $('#formularioConsolidacionContainer').html(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Atención!</strong> ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
    }

    // Limpiar el formulario de consolidación
    function limpiarFormularioConsolidacion() {
        $('#formularioConsolidacionContainer').html('');
    }

    // Habilitar o deshabilitar el botón de generar consolidación
    function toggleGenerateButton(enable) {
        $('#btnGenerarConsolidacion').prop('disabled', !enable);
    }

    // Evento al mostrar el modal
    $('#consolidacionModal').on('show.bs.modal', function() {
        actualizarSolicitudesYElementos();
    });
});

$(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Token CSRF

    // Obtener el ID de la agrupación 
    const agrupacionId = $('#agrupacion_id').val(); 

    // Eventos para los checkboxes de selección
    $('#select_all').change(function() {
        $('.form-check-input.select_item').prop('checked', $(this).prop('checked'));
        actualizarSolicitudesYElementos();
    });

    $('.form-check-input.select_item').change(function() {
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
        return $('.form-check-input.select_item:checked').map(function() {
            return $(this).val();
        }).get();
    }

    // Actualizar la tabla de solicitudes consolidadas
    function actualizarTablaSolicitudes(solicitudes) {
        let tablaSolicitudes = '';
        $('.form-check-input.select_item:checked').closest('tr').each(function() {
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
        let html = `<input type="hidden" name="agrupacion_id" value="${agrupacionId}">`;
    
        // Crear un objeto para consolidar los elementos por nivel_tres
        const elementosConsolidados = {};
    
        // Recorrer los elementos y agrupar por nivel_tres
        data.forEach(function(elemento) {
            const nivelTresId = elemento.niveles_tres.id;
    
            if (!elementosConsolidados[nivelTresId]) {
                // Si el nivel_tres aún no existe, crear un nuevo grupo
                elementosConsolidados[nivelTresId] = {
                    id: elemento.id,
                    id_solicitudes_compra: elemento.id_solicitudes_compra,
                    nivel_tres_nombre: elemento.niveles_tres.nombre,
                    cantidad: elemento.cantidad,
                    elementos_originales: [{
                        id_solicitud_elemento: elemento.id,
                        id_solicitudes_compra: elemento.id_solicitudes_compra,
                        cantidad: elemento.cantidad
                    }]
                };
            } else {
                // Si ya existe, sumar la cantidad y agregar a elementos_originales
                elementosConsolidados[nivelTresId].cantidad += elemento.cantidad;
                elementosConsolidados[nivelTresId].elementos_originales.push({
                    id_solicitud_elemento: elemento.id,
                    id_solicitudes_compra: elemento.id_solicitudes_compra,
                    cantidad: elemento.cantidad
                });
            }
        });
    
        // Generar el HTML con los elementos consolidados
        Object.keys(elementosConsolidados).forEach(function(key, index) {
            const elemento = elementosConsolidados[key];
            html += generarElementoHTML(elemento, index);
        });
    
        $('#formularioConsolidacionContainer').html(html);

        // Agregar funcionalidad para eliminar elementos
        $('.btn-eliminar').on('click', function() {
            $(this).closest('.col-md-6').remove();
            toggleGenerateButton($('#formularioConsolidacionContainer .card').length > 0); // Verifica si quedan tarjetas
        });

        // Habilitar o deshabilitar el botón de enviar
        toggleGenerateButton($('#formularioConsolidacionContainer .card').length > 0);
    }

    // Generar HTML para cada elemento
    function generarElementoHTML(elemento, index) {
        let elementosOriginalesHTML = '';
        elemento.elementos_originales.forEach((el, i) => {
            elementosOriginalesHTML += `
                <input type="hidden" name="elementos[${index}][elementos_originales][${i}][id_solicitud_elemento]" value="${el.id_solicitud_elemento}">
                <input type="hidden" name="elementos[${index}][elementos_originales][${i}][id_solicitudes_compra]" value="${el.id_solicitudes_compra}">
                <input type="hidden" name="elementos[${index}][elementos_originales][${i}][cantidad]" value="${el.cantidad}">
            `;
        });
    
        // Si el elemento fue consolidado (porque su cantidad fue sumada), añadimos las clases y texto correspondientes.
        const consolidadoClass = elemento.elementos_originales.length > 1 ? 'bg-warning' : '';
        const consolidadoTexto = elemento.elementos_originales.length > 1 ? '<span class="badge bg-warning">Consolidado</span>' : '';
    
        return `
            <div class="col-md-6 col-lg-4">
                <div class="card p-2 mb-3 ${consolidadoClass}">
                    <div class="card-body">
                        ${consolidadoTexto} <!-- Muestra el texto "Consolidado" si es necesario -->
                        <input type="hidden" name="elementos[${index}][id_solicitud_elemento]" value="${elemento.id}">
                        <input type="hidden" name="elementos[${index}][id_solicitudes_compra]" value="${elemento.id_solicitudes_compra}">
                        <label class="form-label">Elemento: ${elemento.nivel_tres_nombre}</label>
                        <label class="form-label">Cantidad Unidad:</label>
                        <input type="number" name="elementos[${index}][cantidad]" class="form-control cantidad" placeholder="Cantidad" value="${elemento.cantidad}" required readonly>
                        <input type="hidden" name="elementos[${index}][estado]" value="0">
                        ${elementosOriginalesHTML}
                        <button type="button" class="btn btn-danger btn-eliminar mt-2"><i class="fa fa-fw fa-trash"></i></button>
                    </div>
                </div>
            </div>
        `;
    }

    function mostrarError(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: mensaje
        });
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

        // Validaciones antes de enviar
        if (!validarFormulario()) {
            return; // Detener el envío si hay errores
        }

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

    // Validar el formulario antes de enviarlo
    function validarFormulario() {
        const elementos = $('#formularioConsolidacionContainer .card');
        
        if (elementos.length === 0) {
            mostrarError('No hay elementos para consolidar.');
            return false;
        }

        let tieneErrores = false;

        elementos.each(function() {
            const cantidadInput = $(this).find('.cantidad');
            const cantidad = parseInt(cantidadInput.val());

            if (isNaN(cantidad) || cantidad < 0) {
                tieneErrores = true;
                mostrarError('La cantidad debe ser un número válido y no puede ser menor que 0.');
                return false; // Salir del loop each
            }
        });

        return !tieneErrores; // Retornar verdadero si no hay errores
    }
});

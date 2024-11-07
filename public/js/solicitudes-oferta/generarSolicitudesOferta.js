$(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Eventos para los checkboxes de selección
    $('#selected_all').change(function() {
        $('.selected_item:not(:disabled)').prop('checked', $(this).prop('checked'));
        actualizarConsolidacionesSeleccionadas();
    });

    $('.selected_item').change(function() {
        if ($(this).prop('disabled')) {
            $(this).prop('checked', false);
            return;
        }
        actualizarConsolidacionesSeleccionadas();
        toggleGenerateButton();
    });

    // Función para actualizar el estado de #selected_all
    function actualizarSelectedAll() {
        const totalCheckboxes = $('.selected_item:not(:disabled)').length;
        const checkedCheckboxes = $('.selected_item:not(:disabled):checked').length;
        $('#selected_all').prop('checked', totalCheckboxes === checkedCheckboxes && totalCheckboxes > 0);
    }

    function actualizarConsolidacionesSeleccionadas() {
        const consolidacionesSeleccionadas = obtenerConsolidacionesSeleccionadas();
        if (consolidacionesSeleccionadas.length > 0) {
            obtenerDetallesConsolidaciones(consolidacionesSeleccionadas);
        } else {
            limpiarFormularioSolicitudOferta();
            toggleGenerateButton(false);
        }
        actualizarSelectedAll();
    }

    function obtenerConsolidacionesSeleccionadas() {
        return $('.selected_item:checked').map(function() {
            return $(this).val();
        }).get();
    }

    function obtenerDetallesConsolidaciones(consolidaciones) {
        $.ajax({
            url: '/get-consolidaciones-detalles',
            type: 'POST',
            data: {
                _token: csrfToken,
                consolidaciones: consolidaciones
            },
            success: function(data) {
                actualizarFormularioSolicitudOferta(data);
            },
            error: function(jqXHR) {
                const errorMessage = jqXHR.responseJSON?.message || 'No se pueden generar solicitudes de oferta para las consolidaciones seleccionadas.';
                mostrarError(errorMessage);
                toggleGenerateButton(false);
            }
        });
    }

    function actualizarFormularioSolicitudOferta(data) {
        let html = '';
        data.forEach(function(consolidacion, index) {
            html += generarConsolidacionHTML(consolidacion, index);
        });

        $('#formularioSolicitudOfertaContainer').html(html);
        $('.btn-eliminar').on('click', function() {
            $(this).closest('.col-md-6').remove();
            toggleGenerateButton($('#formularioSolicitudOfertaContainer .card').length > 0);
        });

        toggleGenerateButton($('#formularioSolicitudOfertaContainer .card').length > 0);
    }

    function generarConsolidacionHTML(consolidacion, index) {
        const elementoNombre = consolidacion.solicitudes_elemento?.niveles_tres?.nombre || 'No especificado';
        
        return `
            <div class="col-md-6 col-lg-4">
                <div class="card p-2 mb-3">
                    <div class="card-body">
                        <input type="hidden" name="elementos[${index}][id_consolidaciones]" value="${consolidacion.id}">
                        <input type="hidden" name="elementos[${index}][id_solicitudes_compras]" value="${consolidacion.id_solicitudes_compras}">
                        <input type="hidden" name="elementos[${index}][id_solicitud_elemento]" value="${consolidacion.id_solicitud_elemento}">
                        <label class="form-label">Elemento: ${elementoNombre}</label>
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="elementos[${index}][cantidad]" class="form-control" placeholder="Cantidad" value="${consolidacion.cantidad}" readonly required min="0">
                        <label class="form-label">Descripción</label>
                        <textarea name="elementos[${index}][descripcion]" class="form-control" placeholder="Descripción" maxlength="255"></textarea>
                        <input type="hidden" name="elementos[${index}][estado]" value="0">
                        <button type="button" class="btn btn-danger btn-eliminar mt-2"><i class="fa fa-fw fa-trash"></i></button>
                    </div>
                </div>
            </div>
        `;
    }        

    function mostrarError(mensaje) {
        $('#formularioSolicitudOfertaContainer').html(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Atención!</strong> ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
    }

    function limpiarFormularioSolicitudOferta() {
        $('#formularioSolicitudOfertaContainer').html('');
    }

    function toggleGenerateButton(enable) {
        $('#btnEnviar').prop('disabled', !enable);
        $('#btnGenerarSolicitudOferta').prop('disabled', !enable);
    }

    $('#solicitudesOfertaModal').on('show.bs.modal', function() {
        actualizarConsolidacionesSeleccionadas();
    });

    $('#btnEnviar').on('click', function(e) {
        e.preventDefault();

        // Validaciones antes de mostrar la alerta
        const elementos = $('#formularioSolicitudOfertaContainer input[name^="elementos"]');
        let valid = true;
        let cantidadInvalida = false;

        elementos.each(function() {
            const cantidad = parseFloat($(this).val());
            if ($(this).attr('name').includes('cantidad')) {
                if (isNaN(cantidad) || cantidad < 0) {
                    cantidadInvalida = true;
                    return false; // Salir del bucle each
                }
            }
            if ($(this).val() === '') {
                valid = false; // Si algún campo está vacío
            }
        });

        if (!valid) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos deben ser completados.',
            });
            return;
        }

        if (cantidadInvalida) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La cantidad debe ser un número válido y no puede ser menor que 0.',
            });
            return;
        }

        // Mostrar alerta de confirmación
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas crear esta solicitud de oferta?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, crear',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).closest('form').submit();
            }
        });
    });

    // Agregar un observador de mutaciones para manejar cambios dinámicos en los checkboxes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'disabled') {
                actualizarSelectedAll();
            }
        });
    });

    const config = { attributes: true, subtree: true, attributeFilter: ['disabled'] };
    observer.observe(document.body, config);
});
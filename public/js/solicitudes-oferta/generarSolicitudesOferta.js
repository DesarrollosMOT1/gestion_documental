$(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Función para contar caracteres en el textarea de descripción
    function configurarContadorCaracteres() {
        // Monitorear todos los textareas de descripción
        $('textarea[name^="elementos"][name$="[descripcion]"]').each(function() {
            const maxLength = 255;
            const contador = $(this).next('.contador-caracteres');
            const textarea = $(this);

            // Inicializar el contador
            actualizarContador(textarea, contador);

            // Monitorear el evento de entrada
            textarea.on('input', function() {
                actualizarContador(textarea, contador);
            });
        });
    }

    // Función para actualizar el contador de caracteres
    function actualizarContador(textarea, contador) {
        const maxLength = 255;
        const currentLength = textarea.val().length;
        
        // Actualiza el texto del contador
        contador.text(`${currentLength} / ${maxLength}`);
        
        // Validar si se excede el límite
        if (currentLength > maxLength) {
            contador.addClass('text-danger'); // Cambia el color del contador si se excede el límite
        } else {
            contador.removeClass('text-danger');
        }
    }

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

        // Llamar a la función para configurar el contador de caracteres
        configurarContadorCaracteres();

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
                        
                        <div class="mb-2">
                            <label class="form-label">Elemento: ${elementoNombre}</label>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Cantidad: ${consolidacion.cantidad}</label>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Descripción</label>
                            <textarea name="elementos[${index}][descripcion]" class="form-control" placeholder="Descripción" maxlength="255"></textarea>
                            <div class="contador-caracteres text-muted">0 / 255</div>
                        </div>
                        
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


        elementos.each(function() {
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
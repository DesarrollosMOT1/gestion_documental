$(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Eventos para los checkboxes de selección
    $('#selected_all').change(function() {
        $('.selected_item').prop('checked', $(this).prop('checked'));
        actualizarConsolidacionesSeleccionadas();
    });

    $('.selected_item').change(function() {
        actualizarConsolidacionesSeleccionadas();
        toggleGenerateButton();
    });

    function actualizarConsolidacionesSeleccionadas() {
        const consolidacionesSeleccionadas = obtenerConsolidacionesSeleccionadas();
        if (consolidacionesSeleccionadas.length > 0) {
            obtenerDetallesConsolidaciones(consolidacionesSeleccionadas);
        } else {
            limpiarFormularioSolicitudOferta();
            toggleGenerateButton(false);
        }
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
            error: function() {
                mostrarError('No se pueden generar solicitudes de oferta para las consolidaciones seleccionadas.');
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
        const elementoNombre = consolidacion.solicitudes_elemento && 
                            consolidacion.solicitudes_elemento.niveles_tres ? 
                            consolidacion.solicitudes_elemento.niveles_tres.nombre : 
                            'No especificado';
        
        return `
            <div class="col-md-6 col-lg-4">
                <div class="card p-2 mb-3">
                    <div class="card-body">
                        <input type="hidden" name="elementos[${index}][id_consolidaciones]" value="${consolidacion.id}">
                        <input type="hidden" name="elementos[${index}][id_solicitudes_compras]" value="${consolidacion.id_solicitudes_compras}">
                        <input type="hidden" name="elementos[${index}][id_solicitud_elemento]" value="${consolidacion.id_solicitud_elemento}">
                        <label class="form-label">Elemento: ${elementoNombre}</label>
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="elementos[${index}][cantidad]" class="form-control" placeholder="Cantidad" value="${consolidacion.cantidad}" readonly required>
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
});
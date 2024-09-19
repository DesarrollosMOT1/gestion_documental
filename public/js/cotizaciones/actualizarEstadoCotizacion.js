document.addEventListener('DOMContentLoaded', function() {
    let cotizacionPendiente = null;
    const justificacionModal = new bootstrap.Modal(document.getElementById('justificacionModal'));
    const justificacionTexto = document.getElementById('justificacionTexto');
    const justificacionError = document.getElementById('justificacionError');
    const charCount = document.getElementById('charCount');
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Limitar a 255 caracteres y mostrar el conteo
    justificacionTexto.addEventListener('input', function() {
        const maxLength = 255;
        const currentLength = justificacionTexto.value.length;

        // Actualizar el contador de caracteres
        charCount.textContent = `${currentLength}/${maxLength} caracteres`;

        // Verificar si se excede el límite
        if (currentLength > maxLength) {
            justificacionTexto.value = justificacionTexto.value.substring(0, maxLength); // Recortar texto
        }
    });

    function actualizarEstadoCotizacion(id, estado, idAgrupacion, idConsolidaciones, justificacion = null) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/cotizaciones/actualizar-estado/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ 
                estado, 
                id_agrupaciones_consolidaciones: idAgrupacion,
                id_consolidaciones: idConsolidaciones,
                justificacion: justificacion
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Estado actualizado correctamente.');
                actualizarInterfaz(id, estado, data.idSolicitudElemento, justificacion);
            } else {
                console.error('Error al actualizar el estado.');
            }
        })
        .catch(error => {
            console.error('Error en la solicitud AJAX:', error);
        });
    }

    function compararPrecios(id, idAgrupacion, precio) {
        const elementoActual = document.querySelector(`[data-id="${id}"]`).closest('tr');
        const todasLasCotizaciones = elementoActual.querySelectorAll('.estado-checkbox');
        let precioMayor = false;

        todasLasCotizaciones.forEach(cotizacion => {
            const precioCotizacion = parseFloat(cotizacion.closest('td').querySelector('.badge.bg-info').textContent.replace('$', '').replace(',', ''));
            if (precio > precioCotizacion && id !== cotizacion.getAttribute('data-id')) {
                precioMayor = true;
            }
        });

        return precioMayor;
    }

    document.querySelectorAll('.estado-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const idAgrupacion = this.getAttribute('data-id-agrupacion');
            const idConsolidaciones = this.getAttribute('data-id-consolidaciones'); 
            const estado = this.checked ? 1 : 0;
            const precio = parseFloat(this.closest('td').querySelector('.badge.bg-info').textContent.replace('$', '').replace(',', ''));

            if (estado === 1 && compararPrecios(id, idAgrupacion, precio)) {
                cotizacionPendiente = { id, estado, idAgrupacion };
                justificacionModal.show();
                this.checked = false; // Revertir el cambio del checkbox
            } else {
                actualizarEstadoCotizacion(id, estado, idAgrupacion, idConsolidaciones);
            }
        });
    });

    document.getElementById('guardarJustificacion').addEventListener('click', function() {
        const justificacion = justificacionTexto.value.trim();
        if (justificacion === '') {
            justificacionTexto.classList.add('is-invalid');
            justificacionError.style.display = 'block';
        } else if (cotizacionPendiente) {
            justificacionTexto.classList.remove('is-invalid');
            justificacionError.style.display = 'none';
            const idConsolidaciones = document.querySelector(`[data-id="${cotizacionPendiente.id}"]`).getAttribute('data-id-consolidaciones');
            actualizarEstadoCotizacion(cotizacionPendiente.id, cotizacionPendiente.estado, cotizacionPendiente.idAgrupacion, idConsolidaciones, justificacion);
            justificacionModal.hide();
            justificacionTexto.value = ''; 
            charCount.textContent = '0/255 caracteres'; 
            cotizacionPendiente = null;
        }
    });

    // Limpiar la validación cuando se abra el modal
    justificacionModal._element.addEventListener('show.bs.modal', function () {
        justificacionTexto.classList.remove('is-invalid');
        justificacionError.style.display = 'none';
    });

    function actualizarInterfaz(id, estado, idSolicitudElemento, justificacion = null) {
        const checkboxes = document.querySelectorAll(`.estado-checkbox[data-id-solicitud-elemento="${idSolicitudElemento}"]`);
        
        checkboxes.forEach(checkbox => {
            const currentId = checkbox.getAttribute('data-id');
            const row = checkbox.closest('tr');
            const icono = row.querySelector(`#icono-estado${currentId}`);
            const comentarioIcon = row.querySelector('.fa-comment-dots');
            
            if (currentId == id) {
                checkbox.checked = estado === 1;
                if (estado === 1) {
                    icono.classList.remove('fa-times-circle', 'text-danger');
                    icono.classList.add('fa-check-circle', 'text-success');
                    
                    // Actualizar o agregar el icono de comentario si hay justificación
                    if (justificacion) {
                        if (comentarioIcon) {
                            comentarioIcon.title = justificacion;
                        } else {
                            const nuevoComentarioIcon = document.createElement('i');
                            nuevoComentarioIcon.className = 'fas fa-comment-dots ms-2 text-primary';
                            nuevoComentarioIcon.title = justificacion;
                            nuevoComentarioIcon.setAttribute('data-bs-toggle', 'tooltip');
                            checkbox.parentNode.appendChild(nuevoComentarioIcon);
                            new bootstrap.Tooltip(nuevoComentarioIcon);
                        }
                    }
                } else {
                    icono.classList.remove('fa-check-circle', 'text-success');
                    icono.classList.add('fa-times-circle', 'text-danger');
                    // Remover el icono de comentario si existe
                    if (comentarioIcon) {
                        comentarioIcon.remove();
                    }
                }
            } else {
                checkbox.checked = false;
                checkbox.disabled = estado === 1;
                icono.classList.remove('fa-check-circle', 'text-success');
                icono.classList.add('fa-times-circle', 'text-danger');
            }
            
            // Deshabilitar otros inputs en la misma celda
            const cell = checkbox.closest('td');
            cell.querySelectorAll('input:not(.estado-checkbox)').forEach(input => {
                input.disabled = checkbox.disabled || !checkbox.checked;
            });
            
            // Asegurarse de que el campo de selección se actualice correctamente
            const selectInput = row.querySelector(`input[name="cotizaciones[]"][value="${currentId}"]`);
            if (selectInput) {
                selectInput.disabled = checkbox.disabled;
            }
        });
    }

    // Función para aplicar el estado inicial al cargar la página
    function aplicarEstadoInicial() {
        document.querySelectorAll('.estado-checkbox:checked').forEach(checkbox => {
            const id = checkbox.getAttribute('data-id');
            const idSolicitudElemento = checkbox.getAttribute('data-id-solicitud-elemento');
            actualizarInterfaz(id, 1, idSolicitudElemento);
        });
    }

    // Llamar a la función para aplicar el estado inicial
    aplicarEstadoInicial();
});
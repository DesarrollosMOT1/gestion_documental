document.addEventListener('DOMContentLoaded', () => {
    let cotizacionPendiente = null;

    // Inicialización de elementos y modales
    const justificacionModal = new bootstrap.Modal(document.getElementById('justificacionModal'));
    const justificacionTexto = document.getElementById('justificacionTexto');
    const justificacionError = document.getElementById('justificacionError');
    const charCount = document.getElementById('charCount');

    // Inicialización de tooltips
    const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Limitar el texto a 255 caracteres y actualizar el contador
    justificacionTexto.addEventListener('input', () => {
        const maxLength = 255;
        const currentLength = justificacionTexto.value.length;

        // Actualizar el contador de caracteres
        charCount.textContent = `${currentLength}/${maxLength} caracteres`;

        // Recortar texto si excede el límite
        if (currentLength > maxLength) {
            justificacionTexto.value = justificacionTexto.value.substring(0, maxLength);
        }
    });

    // Función para actualizar el estado de cotización
    const actualizarEstadoCotizacion = (id, estado, idAgrupacion, idConsolidaciones, justificacion = null, estadoJefe = null) => {
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
                justificacion,
                estado_jefe: estadoJefe
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Estado actualizado correctamente.');
                actualizarInterfaz(id, estado, data.idSolicitudElemento, justificacion, estadoJefe);
            } else {
                console.error('Error al actualizar el estado.');
            }
        })
        .catch(error => {
            console.error('Error en la solicitud AJAX:', error);
        });
    };

    // Función para comparar precios
    const compararPrecios = (id, idAgrupacion, precio) => {
        const elementoActual = document.querySelector(`[data-id="${id}"]`).closest('tr');
        const todasLasCotizaciones = elementoActual.querySelectorAll('.estado-checkbox');
        let precioMayor = false;

        todasLasCotizaciones.forEach(cotizacion => {
            const precioCotizacion = parseFloat(cotizacion.closest('td').querySelector('.badge.bg-info').textContent.replace(/[$,]/g, ''));
            if (precio > precioCotizacion && id !== cotizacion.getAttribute('data-id')) {
                precioMayor = true;
            }
        });

        return precioMayor;
    };

    // Manejo del cambio en los checkboxes de estado
    document.querySelectorAll('.estado-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const idAgrupacion = this.getAttribute('data-id-agrupacion');
            const idConsolidaciones = this.getAttribute('data-id-consolidaciones');
            const estado = this.checked ? 1 : 0;
            const precio = parseFloat(this.closest('td').querySelector('.badge.bg-info').textContent.replace(/[$,]/g, ''));

            if (estado === 1 && compararPrecios(id, idAgrupacion, precio)) {
                cotizacionPendiente = { id, estado, idAgrupacion, idConsolidaciones };
                justificacionModal.show();
                this.checked = false; // Revertir el cambio del checkbox
            } else {
                const estadoJefeCheckbox = this.closest('td').querySelector('.estado-jefe-checkbox');
                const estadoJefe = estado === 1 ? estadoJefeCheckbox.checked ? 1 : 0 : 0;
                actualizarEstadoCotizacion(id, estado, idAgrupacion, idConsolidaciones, null, estadoJefe);
            }
        });
    });

    // Manejo del cambio en los checkboxes de estado_jefe
    document.querySelectorAll('.estado-jefe-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const estadoCheckbox = this.closest('td').querySelector('.estado-checkbox');
            const idAgrupacion = estadoCheckbox.getAttribute('data-id-agrupacion');
            const idConsolidaciones = estadoCheckbox.getAttribute('data-id-consolidaciones');
            const estadoJefe = this.checked ? 1 : 0;

            actualizarEstadoCotizacion(id, 1, idAgrupacion, idConsolidaciones, null, estadoJefe);
        });
    });

    // Manejo del botón de guardar justificación
    document.getElementById('guardarJustificacion').addEventListener('click', () => {
        const justificacion = justificacionTexto.value.trim();
        if (justificacion === '') {
            justificacionTexto.classList.add('is-invalid');
            justificacionError.style.display = 'block';
        } else if (cotizacionPendiente) {
            justificacionTexto.classList.remove('is-invalid');
            justificacionError.style.display = 'none';
            const estadoJefeCheckbox = document.querySelector(`.estado-jefe-checkbox[data-id="${cotizacionPendiente.id}"]`);
            const estadoJefe = estadoJefeCheckbox.checked ? 1 : 0;
            actualizarEstadoCotizacion(cotizacionPendiente.id, cotizacionPendiente.estado, cotizacionPendiente.idAgrupacion, cotizacionPendiente.idConsolidaciones, justificacion, estadoJefe);
            justificacionModal.hide();
            justificacionTexto.value = '';
            charCount.textContent = '0/255 caracteres';
            cotizacionPendiente = null;
        }
    });

    // Limpiar la validación cuando se abra el modal
    justificacionModal._element.addEventListener('show.bs.modal', () => {
        justificacionTexto.classList.remove('is-invalid');
        justificacionError.style.display = 'none';
    });

    // Función para actualizar la interfaz después de cambiar el estado
    const actualizarInterfaz = (id, estado, idSolicitudElemento, justificacion = null, estadoJefe = null) => {
        const checkboxes = document.querySelectorAll(`.estado-checkbox[data-id-solicitud-elemento="${idSolicitudElemento}"]`);

        checkboxes.forEach(checkbox => {
            const currentId = checkbox.getAttribute('data-id');
            const row = checkbox.closest('tr');
            const icono = row.querySelector(`#icono-estado${currentId}`);
            const comentarioIcon = row.querySelector('.fa-comment-dots');
            const estadoJefeCheckbox = row.querySelector(`.estado-jefe-checkbox[data-id="${currentId}"]`);

            if (currentId === id) {
                checkbox.checked = estado === 1;
                if (estado === 1) {
                    icono.classList.remove('fa-times-circle', 'text-danger');
                    icono.classList.add('fa-check-circle', 'text-success');
                    estadoJefeCheckbox.disabled = false;
                    if (estadoJefe !== null) {
                        estadoJefeCheckbox.checked = estadoJefe === 1;
                    }

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
                    estadoJefeCheckbox.checked = false;
                    estadoJefeCheckbox.disabled = true;
                    if (comentarioIcon) {
                        comentarioIcon.remove();
                    }
                }
            } else {
                checkbox.checked = false;
                checkbox.disabled = estado === 1;
                icono.classList.remove('fa-check-circle', 'text-success');
                icono.classList.add('fa-times-circle', 'text-danger');
                estadoJefeCheckbox.checked = false;
                estadoJefeCheckbox.disabled = true;
            }

            // Deshabilitar otros inputs en la misma celda
            const cell = checkbox.closest('td');
            cell.querySelectorAll('input:not(.estado-checkbox):not(.estado-jefe-checkbox)').forEach(input => {
                input.disabled = checkbox.disabled || !checkbox.checked;
            });

            // Asegurarse de que el campo de selección se actualice correctamente
                icono.classList.remove('fa-check-circle', 'text-success');
                icono.classList.add('fa-times-circle', 'text-danger');
        });
    };

    // Aplicar el estado inicial al cargar la página
    const aplicarEstadoInicial = () => {
        document.querySelectorAll('.estado-checkbox:checked').forEach(checkbox => {
            const id = checkbox.getAttribute('data-id');
            const idSolicitudElemento = checkbox.getAttribute('data-id-solicitud-elemento');
            const estadoJefeCheckbox = checkbox.closest('td').querySelector('.estado-jefe-checkbox');
            actualizarInterfaz(id, 1, idSolicitudElemento, null, estadoJefeCheckbox.checked ? 1 : 0);
        });
    };

    // Llamar a la función para aplicar el estado inicial
    aplicarEstadoInicial();
});
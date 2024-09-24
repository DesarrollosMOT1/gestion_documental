document.addEventListener('DOMContentLoaded', () => {
    window.scrollTo({ top: 500, behavior: 'smooth' });; // hacer scroll al cargar la pagina hasta la tabla

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

        // Crear un objeto con los datos a actualizar
        const dataToUpdate = {
            id_agrupaciones_consolidaciones: idAgrupacion,
            id_consolidaciones: idConsolidaciones
        };

        // Solo incluir los campos que realmente se están actualizando
        if (estado !== null) dataToUpdate.estado = estado;
        if (justificacion !== null) dataToUpdate.justificacion = justificacion;
        if (estadoJefe !== null) dataToUpdate.estado_jefe = estadoJefe;

        fetch(`/cotizaciones/actualizar-estado/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(dataToUpdate)
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

    // Función para verificar si se puede seleccionar el checkbox de estado_jefe
    const puedeSeleccionarEstadoJefe = (fila) => {
        return fila.querySelector('.estado-checkbox:checked') !== null;
    };

    // Función para actualizar el estado de los checkboxes de estado_jefe
    const actualizarEstadoJefeCheckboxes = (fila) => {
        const estadoJefeCheckboxes = fila.querySelectorAll('.estado-jefe-checkbox');
        const puedeSeleccionar = puedeSeleccionarEstadoJefe(fila);

        estadoJefeCheckboxes.forEach(checkbox => {
            checkbox.disabled = !puedeSeleccionar;
            if (!puedeSeleccionar) {
                checkbox.checked = false;
            }
        });
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
                cotizacionPendiente = { id, estado, idAgrupacion };
                justificacionModal.show();
                this.checked = false; // Revertir el cambio del checkbox
            } else {
                actualizarEstadoCotizacion(id, estado, idAgrupacion, idConsolidaciones, null, null);
            }

            // Actualizar el estado de los checkboxes de estado_jefe en la misma fila
            actualizarEstadoJefeCheckboxes(this.closest('tr'));
        });
    });

    // Manejo del cambio en los checkboxes de estado_jefe
    document.querySelectorAll('.estado-jefe-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (!puedeSeleccionarEstadoJefe(this.closest('tr'))) {
                this.checked = false;
                return;
            }

            const id = this.getAttribute('data-id');
            const idAgrupacion = this.getAttribute('data-id-agrupacion');
            const idConsolidaciones = this.getAttribute('data-id-consolidaciones');
            const estadoJefe = this.checked ? 1 : 0;

            // Desmarcar todos los otros checkboxes de estado_jefe en la misma fila
            const fila = this.closest('tr');
            fila.querySelectorAll('.estado-jefe-checkbox').forEach(otherCheckbox => {
                if (otherCheckbox !== this) {
                    otherCheckbox.checked = false;
                }
            });

            // Solo actualizamos el estado_jefe, dejando los demás campos intactos
            actualizarEstadoCotizacion(id, null, idAgrupacion, idConsolidaciones, null, estadoJefe);
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
            const idConsolidaciones = document.querySelector(`[data-id="${cotizacionPendiente.id}"]`).getAttribute('data-id-consolidaciones');
            actualizarEstadoCotizacion(cotizacionPendiente.id, cotizacionPendiente.estado, cotizacionPendiente.idAgrupacion, idConsolidaciones, justificacion);
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
            const estadoJefeCheckbox = document.getElementById(`estadoJefe${currentId}`);
            actualizarEstadoJefeCheckboxes(checkbox.closest('tr'));

            if (currentId === id) {
                if (estado !== null) {
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
                        
                                // Selecciona el span que contiene el precio y añade el ícono justo después
                                const precioSpan = checkbox.closest('td').querySelector('.badge.bg-info');
                                precioSpan.insertAdjacentElement('afterend', nuevoComentarioIcon); 
                                
                                new bootstrap.Tooltip(nuevoComentarioIcon);
                            }
                        }
                    } else {
                        icono.classList.remove('fa-check-circle', 'text-success');
                        icono.classList.add('fa-times-circle', 'text-danger');
                    }
                }

                // Actualizar el estado del checkbox de jefe si se proporcionó
                if (estadoJefe !== null) {
                    estadoJefeCheckbox.checked = estadoJefe === 1;
                }
            } else {
                if (estado !== null) {
                    checkbox.checked = false;
                    checkbox.disabled = estado === 1;
                    icono.classList.remove('fa-check-circle', 'text-success');
                    icono.classList.add('fa-times-circle', 'text-danger');
                }
            }

            // Deshabilitar otros inputs en la misma celda, excepto estado_jefe
            const cell = checkbox.closest('td');
            cell.querySelectorAll('input:not(.estado-checkbox):not(.estado-jefe-checkbox)').forEach(input => {
                input.disabled = checkbox.disabled || !checkbox.checked;
            });

            // Asegurarse de que el campo de selección se actualice correctamente
            const selectInput = row.querySelector(`input[name="cotizaciones[]"][value="${currentId}"]`);
            if (selectInput) {
                selectInput.disabled = checkbox.disabled;
            }
        });

        // Deshabilitar otros checkboxes de estado_jefe en la misma fila
        if (estadoJefe !== null) {
            const row = document.getElementById(`estadoJefe${id}`).closest('tr');
            row.querySelectorAll('.estado-jefe-checkbox').forEach(checkbox => {
                checkbox.disabled = checkbox.id !== `estadoJefe${id}` && estadoJefe === 1;
            });
        }
    };

    // Aplicar el estado inicial al cargar la página
    const aplicarEstadoInicial = () => {
        document.querySelectorAll('.estado-checkbox:checked').forEach(checkbox => {
            const id = checkbox.getAttribute('data-id');
            const idSolicitudElemento = checkbox.getAttribute('data-id-solicitud-elemento');
            const estadoJefeCheckbox = document.getElementById(`estadoJefe${id}`);
            const estadoJefe = estadoJefeCheckbox.checked ? 1 : 0;
            actualizarInterfaz(id, 1, idSolicitudElemento, null, estadoJefe);
        });

        // Aplicar el estado inicial para los checkboxes de estado_jefe
        document.querySelectorAll('tr').forEach(row => {
            actualizarEstadoJefeCheckboxes(row);
        });

        // Aplicar el estado inicial para los checkboxes de estado_jefe
        document.querySelectorAll('.estado-jefe-checkbox:checked').forEach(checkbox => {
            const row = checkbox.closest('tr');
            row.querySelectorAll('.estado-jefe-checkbox').forEach(otherCheckbox => {
                if (otherCheckbox !== checkbox) {
                    otherCheckbox.disabled = true;
                }
            });
        });
    };

    // Llamar a la función para aplicar el estado inicial
    aplicarEstadoInicial();
});
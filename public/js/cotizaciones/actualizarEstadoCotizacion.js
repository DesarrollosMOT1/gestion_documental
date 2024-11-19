import { mostrarCotizaciones, generarCotizacionHTML, toggleGenerateButton } from '../ordenes-compra/generarOrdenesCompra.js';

// Estado global
let cotizacionPendiente = null;
let justificacionModal = null;
let justificacionTexto = null;
let justificacionError = null;
let charCount = null;

// Funciones de utilidad
const tienePermiso = (checkbox) => {
    return checkbox.getAttribute('data-permiso') && !checkbox.hasAttribute('disabled');
};

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

// Funciones de actualización de interfaz
const actualizarSelectedItem = (row) => {
    const selectedItem = row.querySelector('.selected_item');
    const estadoJefeCheckbox = row.querySelector('.estado-jefe-checkbox:checked');
    if (selectedItem) {
        selectedItem.disabled = !!estadoJefeCheckbox;
        if (estadoJefeCheckbox) {
            selectedItem.checked = false;
        }
    }
};

const actualizarInterfaz = (id, estado, idSolicitudElemento, justificacion = null, estadoJefe = null) => {
    const checkboxes = document.querySelectorAll(`.estado-checkbox[data-id-solicitud-elemento="${idSolicitudElemento}"]`);

    checkboxes.forEach(checkbox => {
        const currentId = checkbox.getAttribute('data-id');
        const row = checkbox.closest('tr');
        const icono = row.querySelector(`#icono-estado${currentId}`);
        const comentarioIcon = row.querySelector('.fa-comment-dots');

        if (currentId === id) {
            if (estado !== null) {
                checkbox.checked = estado === 1;
                if (estado === 1) {
                    icono.classList.remove('fa-times-circle', 'text-danger');
                    icono.classList.add('fa-check-circle', 'text-success');

                    if (justificacion) {
                        if (comentarioIcon) {
                            comentarioIcon.title = justificacion;
                        } else {
                            const nuevoComentarioIcon = document.createElement('i');
                            nuevoComentarioIcon.className = 'fas fa-comment-dots ms-2 text-primary';
                            nuevoComentarioIcon.title = justificacion;
                            nuevoComentarioIcon.setAttribute('data-bs-toggle', 'tooltip');

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
        } else {
            if (estado !== null) {
                checkbox.checked = false;
                checkbox.disabled = estado === 1 || !tienePermiso(checkbox);
                icono.classList.remove('fa-check-circle', 'text-success');
                icono.classList.add('fa-times-circle', 'text-danger');
            }
        }

        const cell = checkbox.closest('td');
        cell.querySelectorAll('input:not(.estado-checkbox):not(.estado-jefe-checkbox)').forEach(input => {
            input.disabled = checkbox.disabled || !checkbox.checked;
        });

        const selectInput = row.querySelector(`input[name="cotizaciones[]"][value="${currentId}"]`);
        if (selectInput) {
            selectInput.disabled = checkbox.disabled;
        }
    });

    if (estadoJefe !== null) {
        const row = document.getElementById(`estadoJefe${id}`).closest('tr');
        row.querySelectorAll('.estado-jefe-checkbox').forEach(checkbox => {
            checkbox.disabled = (checkbox.id !== `estadoJefe${id}` && estadoJefe === 1) || !tienePermiso(checkbox);
        });
        actualizarSelectedItem(row);
    }

    document.querySelectorAll('tr').forEach(row => {
        actualizarSelectedItem(row);
    });
};

// Funciones de API
const actualizarEstadoCotizacion = (id, estado, idAgrupacion, idConsolidaciones, justificacion = null, estadoJefe = null) => {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const dataToUpdate = {
        id_agrupaciones_consolidaciones: idAgrupacion,
        id_consolidaciones: idConsolidaciones
    };

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
            obtenerCotizacionesActualizadas(idAgrupacion);
        } else {
            console.error('Error al actualizar el estado.');
        }
    })
    .catch(error => {
        console.error('Error en la solicitud AJAX:', error);
    });
};

const obtenerCotizacionesActualizadas = (agrupacionId) => {
    fetch(`/cotizaciones-precio/estado-jefe/${agrupacionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarCotizaciones(data.data);
                // Llama a toggleGenerateButton para habilitar o deshabilitar el botón según la cantidad de cotizaciones
                toggleGenerateButton(document.querySelectorAll('#formularioOrdenesCompra .card').length > 0);
            } else {
                console.error('No se pudieron obtener las cotizaciones actualizadas.');
            }
        })
        .catch(error => {
            console.error('Error al obtener cotizaciones:', error);
        });
};

// Manejadores de eventos
const handleJustificacionInput = () => {
    const maxLength = 255;
    const currentLength = justificacionTexto.value.length;

    charCount.textContent = `${currentLength}/${maxLength} caracteres`;

    if (currentLength > maxLength) {
        justificacionTexto.value = justificacionTexto.value.substring(0, maxLength);
    }
};

const handleJustificacionJefeInput = function() {
    const maxLength = 255;
    const currentLength = this.value.length;
    const charCountElement = document.getElementById(`charCountJefe${this.getAttribute('data-id')}`);

    charCountElement.textContent = `${currentLength}/${maxLength} caracteres`;

    if (currentLength > maxLength) {
        this.value = this.value.substring(0, maxLength);
    }
};

const handleEstadoCheckboxChange = function() {
    if (!tienePermiso(this)) {
        this.checked = !this.checked;
        return;
    }

    const id = this.getAttribute('data-id');
    const idAgrupacion = this.getAttribute('data-id-agrupacion');
    const idConsolidaciones = this.getAttribute('data-id-consolidaciones');
    const estado = this.checked ? 1 : 0;
    const precio = parseFloat(this.closest('td').querySelector('.badge.bg-info').textContent.replace(/[$,]/g, ''));

    // Verifica si en la misma fila hay un estado-jefe seleccionado
    const filaActual = this.closest('tr');
    const estadoJefeSeleccionado = filaActual.querySelector('.estado-jefe-checkbox:checked');
    if (estadoJefeSeleccionado) {
        // Si hay un estado-jefe seleccionado, no dejar deseleccionar el estado
        this.checked = true;
        return;
    }

    if (estado === 1) {
        const fila = this.closest('tr');
        fila.querySelectorAll('.estado-checkbox').forEach(otherCheckbox => {
            if (otherCheckbox !== this) {
                otherCheckbox.checked = false;
                otherCheckbox.disabled = true;
            }
        });
    } else {
        const fila = this.closest('tr');
        fila.querySelectorAll('.estado-checkbox').forEach(otherCheckbox => {
            if (otherCheckbox !== this) {
                otherCheckbox.disabled = false;
            }
        });
    }

    if (estado === 1 && compararPrecios(id, idAgrupacion, precio)) {
        cotizacionPendiente = { id, estado, idAgrupacion };
        justificacionModal.show();
        this.checked = false;
    } else {
        actualizarEstadoCotizacion(id, estado, idAgrupacion, idConsolidaciones, null, null);
    }
};

const handleEstadoJefeCheckboxChange = function() {
    if (!tienePermiso(this)) {
        this.checked = !this.checked;
        return;
    }

    const id = this.getAttribute('data-id');
    const idAgrupacion = this.getAttribute('data-id-agrupacion');
    const idConsolidaciones = this.getAttribute('data-id-consolidaciones');
    const estadoJefe = this.checked ? 1 : 0;

    const fila = this.closest('tr');
    
    if (estadoJefe === 1) {
        // Si se selecciona, deshabilitar los otros en la fila
        fila.querySelectorAll('.estado-jefe-checkbox').forEach(otherCheckbox => {
            if (otherCheckbox !== this) {
                otherCheckbox.checked = false;
                otherCheckbox.disabled = true;
            }
        });
    } else {
        // Si se deselecciona, volver a habilitar los otros checkboxes en la fila
        fila.querySelectorAll('.estado-jefe-checkbox').forEach(otherCheckbox => {
            otherCheckbox.disabled = false;
        });
    }

    actualizarEstadoCotizacion(id, null, idAgrupacion, idConsolidaciones, null, estadoJefe);
};

const handleGuardarJustificacion = () => {
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
};

const handleGuardarJustificacionJefe = function() {
    const id = this.getAttribute('data-id');
    const idAgrupacion = this.getAttribute('data-id-agrupacion');
    const idConsolidaciones = this.getAttribute('data-id-consolidaciones');
    const justificacionJefeTexto = document.getElementById(`justificacionJefe${id}`);
    const justificacionJefeError = document.getElementById(`justificacionJefeError${id}`);
    const justificacion = justificacionJefeTexto.value.trim();

    if (justificacion === '') {
        justificacionJefeTexto.classList.add('is-invalid');
        justificacionJefeError.style.display = 'block';
    } else {
        justificacionJefeTexto.classList.remove('is-invalid');
        justificacionJefeError.style.display = 'none';

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch(`/cotizaciones/actualizar-justificacion-jefe/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                id_agrupaciones_consolidaciones: idAgrupacion,
                id_consolidaciones: idConsolidaciones,
                justificacion_jefe: justificacion
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const fila = document.querySelector(`[data-id="${id}"]`).closest('tr');
                const contenedorJustificacion = fila.querySelector('.d-flex.align-items-center');
                const comentarioIcon = contenedorJustificacion.querySelector('.fa-comment-dots');

                if (comentarioIcon) {
                    comentarioIcon.title = justificacion;
                } else {
                    const nuevoComentarioIcon = document.createElement('i');
                    nuevoComentarioIcon.className = 'fas fa-comment-dots ms-2 text-danger';
                    nuevoComentarioIcon.title = justificacion;
                    nuevoComentarioIcon.setAttribute('data-bs-toggle', 'tooltip');

                    contenedorJustificacion.insertAdjacentElement('beforeend', nuevoComentarioIcon);
                    new bootstrap.Tooltip(nuevoComentarioIcon);
                }
            }
        })
        .catch(error => {
            console.error('Error al guardar justificación:', error);
        });
    }
};

const handleModalHide = () => {
    justificacionTexto.classList.remove('is-invalid');
    justificacionError.style.display = 'none';

    if (cotizacionPendiente) {
        const fila = document.querySelector(`[data-id="${cotizacionPendiente.id}"]`).closest('tr');
        fila.querySelectorAll('.estado-checkbox').forEach(checkbox => {
            checkbox.disabled = false;
            checkbox.checked = false;
        });
        cotizacionPendiente = null;
    }
};

// Función de inicialización
const aplicarEstadoInicial = () => {
    document.querySelectorAll('.estado-checkbox:checked').forEach(checkbox => {
        const id = checkbox.getAttribute('data-id');
        const idSolicitudElemento = checkbox.getAttribute('data-id-solicitud-elemento');
        actualizarInterfaz(id, 1, idSolicitudElemento);
    });

    document.querySelectorAll('tr').forEach(row => {
        const checkedJefe = row.querySelector('.estado-jefe-checkbox:checked');
        if (checkedJefe) {
            const id = checkedJefe.getAttribute('data-id');
            row.querySelectorAll('.estado-jefe-checkbox').forEach(otherCheckbox => {
                if (otherCheckbox !== checkedJefe) {
                    otherCheckbox.checked = false;
                    otherCheckbox.disabled = true || !tienePermiso(otherCheckbox);
                }
            });

            const idAgrupacion = checkedJefe.getAttribute('data-id-agrupacion');
            const idConsolidaciones = checkedJefe.getAttribute('data-id-consolidaciones');
            actualizarEstadoCotizacion(id, null, idAgrupacion, idConsolidaciones, null, 1);
        }
        actualizarSelectedItem(row);
    });
};

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', () => {
    window.scrollTo({ top: 500, behavior: 'smooth' });

    // Inicialización de elementos DOM
    justificacionModal = new bootstrap.Modal(document.getElementById('justificacionModal'));
    justificacionTexto = document.getElementById('justificacionTexto');
    justificacionError = document.getElementById('justificacionError');
    charCount = document.getElementById('charCount');

    // Inicialización de tooltips
    const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Configuración de event listeners
    justificacionTexto.addEventListener('input', handleJustificacionInput);
    document.querySelectorAll('.estado-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', handleEstadoCheckboxChange);
    });
    document.querySelectorAll('.estado-jefe-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', handleEstadoJefeCheckboxChange);
    });
    document.getElementById('guardarJustificacion').addEventListener('click', handleGuardarJustificacion);
    justificacionModal._element.addEventListener('hide.bs.modal', handleModalHide);

    document.querySelectorAll('.justificacion-jefe-textarea').forEach(textarea => {
        textarea.addEventListener('input', handleJustificacionJefeInput);
    });

    document.querySelectorAll('.guardar-justificacion-jefe').forEach(button => {
        button.addEventListener('click', handleGuardarJustificacionJefe);
    });

    // Aplicar estado inicial
    aplicarEstadoInicial();
});
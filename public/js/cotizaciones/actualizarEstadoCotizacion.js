document.addEventListener('DOMContentLoaded', function() {
    // Función para actualizar el estado mediante AJAX
    function actualizarEstadoCotizacion(id, estado, idAgrupacion) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/cotizaciones/actualizar-estado/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ estado, id_agrupaciones_consolidaciones: idAgrupacion })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Estado actualizado correctamente.');

                // Actualizar el ícono visualmente en función del estado
                const icono = document.getElementById(`icono-estado${id}`);
                if (estado === 1) {
                    icono.classList.remove('fa-times-circle', 'text-danger');
                    icono.classList.add('fa-check-circle', 'text-success');
                } else {
                    icono.classList.remove('fa-check-circle', 'text-success');
                    icono.classList.add('fa-times-circle', 'text-danger');
                }
            } else {
                console.error('Error al actualizar el estado.');
            }
        })
        .catch(error => {
            console.error('Error en la solicitud AJAX:', error);
        });
    }

    // Manejar el evento de cambio en el checkbox
    document.querySelectorAll('.estado-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const idAgrupacion = this.getAttribute('data-id-agrupacion');
            const estado = this.checked ? 1 : 0; // Convertir a 1 o 0 para el backend
            actualizarEstadoCotizacion(id, estado, idAgrupacion);
        });
    });
});

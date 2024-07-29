document.addEventListener('DOMContentLoaded', function() {
    // Función para actualizar el estado mediante AJAX
    function actualizarEstado(id, estado) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/solicitudes-compras/actualizar-estado/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ estado })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Estado actualizado correctamente.');
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
            const estado = this.checked ? 1 : 0; // Convertir a 1 o 0 para el backend
            actualizarEstado(id, estado);
        });
    });
});

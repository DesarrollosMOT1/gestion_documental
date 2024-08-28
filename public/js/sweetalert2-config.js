document.addEventListener('DOMContentLoaded', function() {
    // Manejar la confirmación de eliminación para todos los formularios con la clase .delete-form
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Enviar el formulario si se confirma
                }
            });
        });
    });

    // Mostrar mensaje de éxito si existe
    const successMessageElement = document.getElementById('success-message');
    if (successMessageElement) {
        showSuccessMessage(successMessageElement.dataset.message);
    }
});

// Función para mostrar mensaje de éxito
function showSuccessMessage(message) {
    Swal.fire({
        title: 'Éxito!',
        text: message,
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
}

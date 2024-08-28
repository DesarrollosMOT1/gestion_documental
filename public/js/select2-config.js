document.addEventListener("DOMContentLoaded", function() {
    // Inicializar automáticamente cualquier select con la clase .select2
    $('.select2').select2({
        theme: 'bootstrap-5', // Opcional: si estás usando un tema de Bootstrap
        placeholder: 'Seleccione una opción',
        allowClear: true // Opcional: permite limpiar la selección
    });
});

document.addEventListener("DOMContentLoaded", function() {
    // Inicializar automáticamente cualquier select con la clase .select2
    $('.select2').select2({
        theme: 'bootstrap-5', 
        placeholder: 'Seleccione una opción',
        allowClear: true 
    });
});

$(document).ready(function() {
    // Función para actualizar el valor total de la cotización
    function actualizarValorTotal() {
        var total = 0;
        $('input[name^="elementos"][name$="[precio]"]').each(function() {
            var precio = parseFloat($(this).val()) || 0;
            var cantidad = parseFloat($(this).closest('.row').find('input[name$="[cantidad]"]').val()) || 0;
            total += precio * cantidad;
        });

        // Aplicar el descuento si existe
        var descuento = parseFloat($('#descuento').val()) || 0;
        total = total - (total * (descuento / 100));

        // Actualizar el campo de valor
        $('#valor').val(total.toFixed(2));
    }

    // Actualizar el valor total cuando cambie el precio o la cantidad de algún elemento
    $(document).on('input', 'input[name^="elementos"][name$="[precio]"], input[name^="elementos"][name$="[cantidad]"]', function() {
        actualizarValorTotal();
    });

    // Actualizar el valor total cuando cambie el descuento
    $('#descuento').on('input', function() {
        actualizarValorTotal();
    });

    // Observar cambios en el contenedor de elementos
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                actualizarValorTotal();
            }
        });
    });

    var config = { childList: true, subtree: true };
    observer.observe(document.getElementById('elementos_container'), config);

    // Asegurarse de que el valor se actualice antes de enviar el formulario
    $('#cotizacionForm').on('submit', function() {
        actualizarValorTotal();
    });
});
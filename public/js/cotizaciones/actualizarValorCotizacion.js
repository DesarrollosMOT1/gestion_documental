$(document).ready(function() {
    // Función para actualizar el valor total de la cotización
    function actualizarValorTotal() {
        var total = 0;

        // Iterar sobre cada tarjeta de elemento
        $('input[name^="elementos"][name$="[precio]"]').each(function() {
            var precio = parseFloat($(this).val()) || 0;
            var cantidad = parseFloat($(this).closest('.card').find('input[name$="[cantidad]"]').val()) || 0;
            var descuento = parseFloat($(this).closest('.card').find('input[name$="[descuento]"]').val()) || 0;
            
            // Calcular el valor con el descuento aplicado
            var subtotal = (precio * cantidad);
            var descuentoAplicado = subtotal * (descuento / 100);

            // Restar el descuento al subtotal
            total += (subtotal - descuentoAplicado);
        });

        // Actualizar el campo de valor con el total calculado
        $('#valor').val(total.toFixed(2));
    }

    // Actualizar el valor total cuando cambie el precio, la cantidad o el descuento de algún elemento
    $(document).on('input', 'input[name^="elementos"][name$="[precio]"], input[name^="elementos"][name$="[cantidad]"], input[name^="elementos"][name$="[descuento]"]', function() {
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
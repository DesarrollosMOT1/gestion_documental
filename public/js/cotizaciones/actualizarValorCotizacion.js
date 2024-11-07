$(document).ready(function() {
    // Función para actualizar el valor total de la cotización
    function actualizarValorTotal() {
        var total = 0;

        // Iterar sobre cada tarjeta de elemento
        $('input[name^="elementos"][name$="[precio]"]').each(function() {
            var precio = parseFloat($(this).val()) || 0;
            var cantidad = parseFloat($(this).closest('.card').find('input[name$="[cantidad]"]').val()) || 0;
            var descuento = parseFloat($(this).closest('.card').find('input[name$="[descuento]"]').val()) || 0;
            
            // Obtener el porcentaje del impuesto seleccionado
            var impuestoId = $(this).closest('.card').find('select[name$="[id_impuestos]"]').val();
            var impuestoPorcentaje = parseFloat($(this).closest('.card').find(`option[value="${impuestoId}"]`).text().match(/\((\d+\.\d+)%\)/)?.[1] || 0) / 100;

            console.log(impuestoPorcentaje)
            // Calcular el subtotal con cantidad y precio
            var subtotal = precio * cantidad;

            // Aplicar descuento
            var descuentoAplicado = subtotal * (descuento / 100);
            var subtotalConDescuento = subtotal - descuentoAplicado;

            // Calcular el valor del IVA
            var ivaAplicado = subtotalConDescuento * impuestoPorcentaje;

            // Sumar subtotal con descuento y el IVA al total
            total += (subtotalConDescuento + ivaAplicado);
        });

        // Actualizar el campo de valor con el total calculado
        $('#valor').val(total.toFixed(2));
    }

    // Actualizar el valor total cuando cambie el precio, la cantidad, el descuento o el impuesto de algún elemento
    $(document).on('input change', 'input[name^="elementos"][name$="[precio]"], input[name^="elementos"][name$="[cantidad]"], input[name^="elementos"][name$="[descuento]"], select[name^="elementos"][name$="[id_impuestos]"]', function() {
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
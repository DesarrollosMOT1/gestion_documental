$(document).ready(function() {
    $('#btnCrearOrdenCompra').on('click', function() {
        let seleccionados = $('input[name="consolidaciones[]"]:checked').map(function() {
            return this.value;
        }).get();

        if (seleccionados.length > 0) {
            $.ajax({
                url: '/crear-orden-compra',
                method: 'POST',
                data: {
                    consolidaciones: seleccionados,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Manejar la respuesta del servidor
                    alert('Orden de compra creada con éxito.');
                    $('#modalCotizacionesVigentes').modal('hide');
                },
                error: function(xhr) {
                    // Manejar errores
                    alert('Hubo un error al crear la orden de compra.');
                }
            });
        } else {
            alert('Por favor, selecciona al menos una cotización.');
        }
    });
});

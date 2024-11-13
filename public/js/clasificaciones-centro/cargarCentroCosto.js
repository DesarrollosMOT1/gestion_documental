$(document).ready(function() {
    function cargarCentroCosto(idClasificacionCentro) {
        $.ajax({
            url: '/api/centros-costos/' + idClasificacionCentro,
            method: 'GET',
            success: function(response) {
                let centrosCostosList = $('#centrosCostosList');
                centrosCostosList.empty();

                if (response.length > 0) {
                    response.forEach(function(centroCosto) {
                        centrosCostosList.append(`
                            <a href="#" class="list-group-item list-group-item-action" data-id="${centroCosto.id}">
                                ${centroCosto.nombre}
                                <a href="/centros-costos/${centroCosto.id}/edit" class="btn btn-warning btn-sm float-right">Editar</a>
                            </a>
                        `);
                    });
                } else {
                    centrosCostosList.html('<div class="alert alert-warning">No hay centros costos disponibles para esta clasificación centro.</div>');
                }
            },
            error: function() {
                console.error('Error al cargar centros costos.');
                $('#centrosCostosList').html('<div class="alert alert-danger">Error al cargar centros costos.</div>');
            }
        });
    }

    $('#ClasificacionesCentrosList').on('click', '.list-group-item', function(event) {
        event.preventDefault();
        let idClasificacionCentro = $(this).data('id');
        cargarCentroCosto(idClasificacionCentro);
        $(this).addClass('active').siblings().removeClass('active');
    });
});

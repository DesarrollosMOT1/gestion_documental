$(document).ready(function() {
    // Función para cargar niveles dos
    function cargarNivelesDos(idNivelUno) {
        $.ajax({
            url: '/api/niveles-dos/' + idNivelUno,
            method: 'GET',
            success: function(response) {
                let nivelesDosList = $('#nivelesDosList');
                nivelesDosList.empty();
                $('#nivelesTresList').empty().html('<div class="alert alert-info">No se ha seleccionado ningún nivel dos aún.</div>');
                if (response.length > 0) {
                    response.forEach(function(nivelDos) {
                        nivelesDosList.append(`
                            <a href="#" class="list-group-item list-group-item-action" data-id="${nivelDos.id}">
                                ${nivelDos.nombre}
                            </a>
                        `);
                    });
                } else {
                    nivelesDosList.html('<div class="alert alert-warning">No hay niveles dos disponibles para este nivel uno.</div>');
                }
            },
            error: function() {
                console.error('Error al cargar niveles dos.');
                $('#nivelesDosList').html('<div class="alert alert-danger">Error al cargar niveles dos.</div>');
            }
        });
    }

    // Función para cargar niveles tres
    function cargarNivelesTres(idNivelDos) {
        $.ajax({
            url: '/api/niveles-tres/' + idNivelDos,
            method: 'GET',
            success: function(response) {
                let nivelesTresList = $('#nivelesTresList');
                nivelesTresList.empty();
                if (response.length > 0) {
                    response.forEach(function(nivelTres) {
                        nivelesTresList.append(`
                            <span class="list-group-item">${nivelTres.nombre}</span>
                        `);
                    });
                } else {
                    nivelesTresList.html('<div class="alert alert-warning">No hay niveles tres disponibles para este nivel dos.</div>');
                }
            },
            error: function() {
                console.error('Error al cargar niveles tres.');
                $('#nivelesTresList').html('<div class="alert alert-danger">Error al cargar niveles tres.</div>');
            }
        });
    }

    // Manejo de eventos de clic para cargar niveles jerárquicos
    $('#nivelesUnoList').on('click', '.list-group-item', function(event) {
        event.preventDefault();
        let idNivelUno = $(this).data('id');
        cargarNivelesDos(idNivelUno);
        $(this).addClass('active').siblings().removeClass('active');
    });

    $('#nivelesDosList').on('click', '.list-group-item', function(event) {
        event.preventDefault();
        let idNivelDos = $(this).data('id');
        cargarNivelesTres(idNivelDos);
        $(this).addClass('active').siblings().removeClass('active');
    });
});
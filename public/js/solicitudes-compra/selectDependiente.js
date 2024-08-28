function fetchNivel(url, targetSelect, callback) {
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('La respuesta de la red no fue correcta: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            let options = '<option selected>Seleccione una opción</option>';
            data.forEach(function(item) {
                options += `<option value="${item.id}" data-inventario="${item.inventario}">${item.nombre}</option>`;
            });
            $(targetSelect).html(options).trigger('change'); // Actualiza el select y dispara el evento change
            if (callback) callback(data);
        })
        .catch(error => {
            console.error('Ha habido un problema con su operación de recuperación:', error);
        });
}

function initializeSelects() {
    const selectNivelesUno = $('#select_niveles_uno');
    const selectNivelesDos = $('#select_niveles_dos');
    const selectNivelesTres = $('#select_niveles_tres');
    const selectCentrosCostos = $('#select_id_centros_costos');

    // Inicializar Select2 en los selects dependientes
    selectNivelesUno.select2({
        theme: 'bootstrap-5',
        placeholder: 'Seleccione una opción',
        allowClear: true
    });

    selectNivelesDos.select2({
        theme: 'bootstrap-5',
        placeholder: 'Seleccione una opción',
        allowClear: true
    });

    selectNivelesTres.select2({
        theme: 'bootstrap-5',
        placeholder: 'Seleccione una opción',
        allowClear: true
    });

    selectCentrosCostos.select2({
        theme: 'bootstrap-5',
        placeholder: 'Seleccione una opción',
        allowClear: true
    });

    selectNivelesUno.on('change', function() {
        const idNivelUno = this.value;
        fetchNivel(`/api/niveles-dos/${idNivelUno}`, selectNivelesDos[0]);
    });

    selectNivelesDos.on('change', function() {
        const idNivelDos = this.value;
        fetchNivel(`/api/niveles-tres/${idNivelDos}`, selectNivelesTres[0], handleNivelTresChange);
    });

    function handleNivelTresChange() {
        selectNivelesTres.on('change', function() {
            const selectedOption = $(this).find(':selected');
            const isInventario = selectedOption.data('inventario') === 1;

            if (isInventario) {
                selectCentrosCostos.val('11011').trigger('change').prop('disabled', true);
            } else {
                selectCentrosCostos.prop('disabled', false).trigger('change');
            }
        });
    }
}

$(document).ready(function() {
    initializeSelects();
});

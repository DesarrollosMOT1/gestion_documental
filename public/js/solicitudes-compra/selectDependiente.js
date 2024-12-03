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
                const equivalenciasData = JSON.stringify(item.equivalencias || []);
                const additionalData = `
                    data-unidad="${item.unidad_nombre || ''}"
                    data-inventario="${item.inventario}"
                    data-equivalencias='${equivalenciasData}'
                `;
                options += `<option value="${item.id}" ${additionalData}>${item.nombre}</option>`;
            });
            $(targetSelect).html(options).trigger('change');
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
    const selectUnidad = $('#select_unidad');

    // Inicializar Select2 en los selects dependientes
    [selectNivelesUno, selectNivelesDos, selectNivelesTres, selectCentrosCostos, selectUnidad].forEach(select => {
        select.select2({
            theme: 'bootstrap-5',
            placeholder: 'Seleccione una opción',
            allowClear: true
        });
    });

    selectNivelesUno.on('change', function() {
        const idNivelUno = this.value;
        fetchNivel(`/api/niveles-dos/${idNivelUno}`, selectNivelesDos[0]);
        // Resetear selects dependientes
        selectNivelesTres.html('<option selected>Seleccione una opción</option>').trigger('change');
        selectUnidad.html('<option selected>Sin nivel tres seleccionado</option>').trigger('change');
    });

    selectNivelesDos.on('change', function() {
        const idNivelDos = this.value;
        fetchNivel(`/api/niveles-tres/${idNivelDos}`, selectNivelesTres[0], handleNivelTresChange);
        // Resetear unidad
        selectUnidad.html('<option selected>Sin nivel tres seleccionado</option>').trigger('change');
    });

    function handleNivelTresChange() {
        selectNivelesTres.on('change', function() {
            const selectedOption = $(this).find(':selected');
            const isInventario = selectedOption.data('inventario') === 1;
            const unidadNombre = selectedOption.data('unidad');
    
            // Actualizar select de unidad
            if (selectedOption.val() === 'Seleccione una opción') {
                selectUnidad.html('<option selected>Sin nivel tres seleccionado</option>').trigger('change');
            } else if (unidadNombre) {
                selectUnidad.html(`<option selected>${unidadNombre}</option>`).trigger('change');
            } else {
                selectUnidad.html('<option selected>Este elemento no tiene una unidad relacionada</option>').trigger('change');
            }
    
            // Manejar centro de costos basado en inventario
            if (isInventario) {
                let centroCostoMekano = $('#select_id_centros_costos option').filter(function() {
                    return $(this).text().includes('11011');
                });
    
                if (centroCostoMekano.length > 0) {
                    selectCentrosCostos.val(centroCostoMekano.val()).trigger('change').prop('disabled', true);
                }
            } else {
                selectCentrosCostos.prop('disabled', false).trigger('change');
            }
        });
    }
}

$(document).ready(function() {
    initializeSelects();
});
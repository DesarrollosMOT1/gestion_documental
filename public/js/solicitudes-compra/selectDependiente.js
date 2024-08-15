function fetchNivel(url, targetSelect, callback) {
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('La respuesta de la red no fue correcta: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            targetSelect.innerHTML = '<option selected>Seleccione una opción</option>';
            data.forEach(function(item) {
                targetSelect.innerHTML += `<option value="${item.id}" data-inventario="${item.inventario}">${item.nombre}</option>`;
            });
            if (callback) callback(data);
        })
        .catch(error => {
            console.error('Ha habido un problema con su operación de recuperación:', error);
        });
}

function initializeSelects() {
    const selectNivelesUno = document.getElementById('select_niveles_uno');
    const selectNivelesDos = document.getElementById('select_niveles_dos');
    const selectNivelesTres = document.getElementById('select_niveles_tres');
    const selectCentrosCostos = document.getElementById('select_id_centros_costos');

    selectNivelesUno.addEventListener('change', function() {
        const idNivelUno = this.value;
        fetchNivel(`/api/niveles-dos/${idNivelUno}`, selectNivelesDos);
    });

    selectNivelesDos.addEventListener('change', function() {
        const idNivelDos = this.value;
        fetchNivel(`/api/niveles-tres/${idNivelDos}`, selectNivelesTres, handleNivelTresChange);
    });

    function handleNivelTresChange(data) {
        selectNivelesTres.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const isInventario = selectedOption.getAttribute('data-inventario') === '1';

            if (isInventario) {
                selectCentrosCostos.value = '11011';
                selectCentrosCostos.disabled = true;
            } else {
                selectCentrosCostos.disabled = false;
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initializeSelects();
});
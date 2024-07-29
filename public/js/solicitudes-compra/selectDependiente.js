function fetchNivel(url, targetSelect) {
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
                targetSelect.innerHTML += `<option value="${item.id}">${item.nombre}</option>`;
            });
        })
        .catch(error => {
            console.error('Ha habido un problema con su operación de recuperación:', error);
        });
}

function initializeSelects() {
    const selectNivelesUno = document.getElementById('select_niveles_uno');
    const selectNivelesDos = document.getElementById('select_niveles_dos');
    const selectNivelesTres = document.getElementById('select_niveles_tres');

    selectNivelesUno.addEventListener('change', function() {
        const idNivelUno = this.value;
        fetchNivel(`/api/niveles-dos/${idNivelUno}`, selectNivelesDos);
    });

    selectNivelesDos.addEventListener('change', function() {
        const idNivelDos = this.value;
        fetchNivel(`/api/niveles-tres/${idNivelDos}`, selectNivelesTres);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initializeSelects();
});

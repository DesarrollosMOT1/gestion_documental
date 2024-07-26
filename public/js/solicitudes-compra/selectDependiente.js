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

function handleAddElement() {
    const selectNivelesTres = document.getElementById('select_niveles_tres');
    const selectCentrosCostos = document.getElementById('select_id_centros_costos');
    const inputCantidad = document.getElementById('input_cantidad');
    const elementsTableBody = document.getElementById('elementsTableBody');
    const noElementsRow = document.getElementById('noElementsRow');

    if (selectNivelesTres.value !== "Seleccione una opción" &&
        selectCentrosCostos.value !== "Seleccione una opción" &&
        inputCantidad.value !== "") {

        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td>${selectNivelesTres.options[selectNivelesTres.selectedIndex].text}</td>
            <td>${selectCentrosCostos.options[selectCentrosCostos.selectedIndex].text}</td>
            <td>${inputCantidad.value}</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-element">Eliminar</button></td>
        `;

        elementsTableBody.appendChild(newRow);

        selectNivelesTres.selectedIndex = 0;
        selectCentrosCostos.selectedIndex = 0;
        inputCantidad.value = "";

        noElementsRow.style.display = 'none';

        newRow.querySelector('.remove-element').addEventListener('click', function() {
            elementsTableBody.removeChild(newRow);
            if (elementsTableBody.children.length === 0) {
                noElementsRow.style.display = '';
            }
        });
    } else {
        alert('Por favor complete todos los campos antes de agregar.');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initializeSelects();
    document.getElementById('addElement').addEventListener('click', handleAddElement);
});

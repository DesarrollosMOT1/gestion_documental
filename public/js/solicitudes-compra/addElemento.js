let elementIndex = 0;
const noElementsRow = document.getElementById('noElementsRow');

function updateTableMessage() {
    const tableBody = document.getElementById('elementsTableBody');
    const rows = tableBody.querySelectorAll('tr:not(#noElementsRow)');
    if (rows.length === 0) {
        noElementsRow.style.display = '';
    } else {
        noElementsRow.style.display = 'none';
    }
}

document.getElementById('addElement').addEventListener('click', function() {
    const nivelesTres = document.getElementById('select_id_niveles_tres');
    const centrosCostos = document.getElementById('select_id_centros_costos');
    const cantidad = document.getElementById('input_cantidad').value;

    if (cantidad && nivelesTres.value !== 'Seleccione una opción' && centrosCostos.value !== 'Seleccione una opción') {
        const nivelesTresText = nivelesTres.options[nivelesTres.selectedIndex].text;
        const centrosCostosText = centrosCostos.options[centrosCostos.selectedIndex].text;
        const nivelesTresValue = nivelesTres.value;
        const centrosCostosValue = centrosCostos.value;

        const newRow = `
            <tr id="element-${elementIndex}">
                <td>${nivelesTresText}</td>
                <td>${centrosCostosText}</td>
                <td>${cantidad}</td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="removeElement(${elementIndex})">Eliminar</button>
                </td>
                <input type="hidden" name="elements[${elementIndex}][id_niveles_tres]" value="${nivelesTresValue}">
                <input type="hidden" name="elements[${elementIndex}][id_centros_costos]" value="${centrosCostosValue}">
                <input type="hidden" name="elements[${elementIndex}][cantidad]" value="${cantidad}">
            </tr>
        `;
        document.getElementById('elementsTableBody').insertAdjacentHTML('beforeend', newRow);
        elementIndex++;

        // Resetear los campos de entrada
        document.getElementById('select_id_niveles_tres').value = 'Seleccione una opción';
        document.getElementById('select_id_centros_costos').value = 'Seleccione una opción';
        document.getElementById('input_cantidad').value = '';

        // Actualizar el mensaje de la tabla
        updateTableMessage();
    } else {
        alert('Por favor, complete todos los campos antes de agregar un elemento.');
    }
});

function removeElement(index) {
    const row = document.getElementById(`element-${index}`);
    row.remove();

    // Actualizar el mensaje de la tabla
    updateTableMessage();
}

// Inicializar el mensaje de la tabla
updateTableMessage();

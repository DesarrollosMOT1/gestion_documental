let elementIndex = 0;
const noElementsRow = document.getElementById('noElementsRow');
const nivelesTresSet = new Set(); // Crear un Set para almacenar los niveles tres agregados

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
    const nivelesTres = document.getElementById('select_niveles_tres');
    const centrosCostos = document.getElementById('select_id_centros_costos');
    const cantidad = document.getElementById('input_cantidad').value;
    const resetOption = document.getElementById('reset_options').value;

    if (cantidad && nivelesTres.value !== 'Seleccione una opción' && centrosCostos.value !== 'Seleccione una opción' &&
        nivelesTres.value !== '' && centrosCostos.value !== '') {
        
        const nivelesTresText = nivelesTres.options[nivelesTres.selectedIndex].text;
        const centrosCostosText = centrosCostos.options[centrosCostos.selectedIndex].text;
        const nivelesTresValue = nivelesTres.value;
        const centrosCostosValue = centrosCostos.value;

        // Verificar si el nivel tres ya fue agregado
        if (nivelesTresSet.has(nivelesTresValue)) {
            Swal.fire({
                icon: 'warning',
                title: 'Elemento ya agregado',
                text: 'Ya hay un elemento agregado con el mismo Nivel Tres.',
            });
            return; // Salir de la función si el nivel tres ya existe
        }

        // Agregar el nivel tres al conjunto
        nivelesTresSet.add(nivelesTresValue);

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

        // Lógica para limpiar campos basada en la opción seleccionada
        if (resetOption === 'all') {
            $('#select_niveles_uno').val(null).trigger('change');
            $('#select_niveles_dos').val(null).trigger('change');
            $('#select_niveles_tres').val(null).trigger('change');
            $('#select_id_centros_costos').val(null).trigger('change');
            document.getElementById('input_cantidad').value = '';
        } else if (resetOption === 'partial') {
            $('#select_id_centros_costos').val(null).trigger('change');
            document.getElementById('input_cantidad').value = '';
        }

        updateTableMessage();
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Campos incompletos',
            text: 'Por favor, complete todos los campos antes de agregar un elemento.',
        });
    }
});

function removeElement(index) {
    const row = document.getElementById(`element-${index}`);
    const nivelesTresValue = row.querySelector('input[name^="elements[' + index + '][id_niveles_tres]"]').value;

    // Eliminar el nivel tres del conjunto
    nivelesTresSet.delete(nivelesTresValue);

    row.remove();
    updateTableMessage();
}

document.getElementById('submitForm').addEventListener('click', function(event) {
    event.preventDefault();
    const elementsCount = document.querySelectorAll('#elementsTableBody tr:not(#noElementsRow)').length;
    if (elementsCount === 0) {
        Swal.fire({
            icon: 'error',
            title: 'No hay elementos',
            text: 'Debe agregar al menos un elemento antes de enviar el formulario.',
        });
    } else {
        // Aquí puedes proceder a enviar el formulario
        document.getElementById('solicitudesCompras').submit();
    }
});


updateTableMessage();

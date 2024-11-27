let elementIndex = 0;
const noElementsRow = document.getElementById('noElementsRow');
const nivelesTresSet = new Set(); // Crear un Set para almacenar los niveles tres agregados

function updateTableMessage() {
    const tableBody = document.getElementById('elementsTableBody');
    const rows = tableBody.querySelectorAll('tr:not(#noElementsRow)');
    noElementsRow.style.display = rows.length === 0 ? '' : 'none';
}

document.getElementById('addElement').addEventListener('click', function () {
    const nivelesTres = document.getElementById('select_niveles_tres');
    const centrosCostos = document.getElementById('select_id_centros_costos');
    const cantidad = document.getElementById('input_cantidad').value;
    const resetOption = document.getElementById('reset_options').value;
    const descripcion = document.getElementById('input_descripcion').value;

    // Validar que los campos no estén vacíos
    if (!cantidad || nivelesTres.value === 'Seleccione una opción' || centrosCostos.value === 'Seleccione una opción' ||
        nivelesTres.value === '' || centrosCostos.value === '') {
        Swal.fire({
            icon: 'error',
            title: 'Campos incompletos',
            text: 'Por favor, complete todos los campos antes de agregar un elemento.',
        });
        return;
    }

    // Validación de longitud de la descripción
    if (descripcion.length > 255) {
        Swal.fire({
            icon: 'error',
            title: 'Descripción demasiado larga',
            text: 'La descripción no puede tener más de 255 caracteres.',
        });
        return;
    }

    // Validación adicional para valores numéricos (cantidad debe ser mayor que 0)
    if (parseInt(cantidad) <= 0) {
        Swal.fire({
            icon: 'error',
            title: 'Cantidad inválida',
            text: 'La cantidad debe ser un valor mayor que 0.',
        });
        return;
    }

    const nivelesTresText = nivelesTres.options[nivelesTres.selectedIndex].text;
    const centrosCostosText = centrosCostos.options[centrosCostos.selectedIndex].text;
    const nivelesTresValue = nivelesTres.value;
    const centrosCostosValue = centrosCostos.value;

    // Crear una clave única combinando nivel tres y centro de costos
    const uniqueKey = `${nivelesTresValue}-${centrosCostosValue}`;

    // Verificar si la combinación ya fue agregada
    if (nivelesTresSet.has(uniqueKey)) {
        Swal.fire({
            icon: 'warning',
            title: 'Elemento ya agregado',
            text: 'Ya existe un elemento con este nivel tres y centro de costo.',
        });
        return;
    }

    // Agregar la combinación única al Set
    nivelesTresSet.add(uniqueKey);

    // Agregar la fila a la tabla
    createRow(elementIndex, nivelesTresText, centrosCostosText, cantidad, nivelesTresValue, centrosCostosValue, descripcion);
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
});

function createRow(elementIndex, nivelesTresText, centrosCostosText, cantidad, nivelesTresValue, centrosCostosValue, descripcion) {
    const tableBody = document.getElementById('elementsTableBody');
    const newRow = document.createElement('tr');
    newRow.id = `element-${elementIndex}`;
    
    const cellData = [nivelesTresText, centrosCostosText, cantidad, descripcion];
    cellData.forEach(text => {
        const cell = document.createElement('td');
        cell.textContent = text;
        newRow.appendChild(cell);
    });

    const cell4 = document.createElement('td');
    const deleteButton = document.createElement('button');
    deleteButton.textContent = 'Eliminar';
    deleteButton.className = 'btn btn-danger';
    deleteButton.addEventListener('click', () => removeElement(elementIndex, nivelesTresValue, centrosCostosValue));
    cell4.appendChild(deleteButton);
    newRow.appendChild(cell4);

    // Crear inputs ocultos
    const hiddenInputs = [
        { name: `elements[${elementIndex}][id_niveles_tres]`, value: nivelesTresValue },
        { name: `elements[${elementIndex}][id_centros_costos]`, value: centrosCostosValue },
        { name: `elements[${elementIndex}][cantidad]`, value: cantidad },
        { name: `elements[${elementIndex}][descripcion]`, value: descripcion }
    ];
    
    hiddenInputs.forEach(({ name, value }) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        newRow.appendChild(input);
    });

    tableBody.appendChild(newRow);
}

function removeElement(index, nivelesTresValue, centrosCostosValue) {
    const row = document.getElementById(`element-${index}`);

    // Eliminar la combinación única del Set
    const uniqueKey = `${nivelesTresValue}-${centrosCostosValue}`;
    nivelesTresSet.delete(uniqueKey);

    row.remove();
    updateTableMessage();
}

document.getElementById('submitForm').addEventListener('click', function (event) {
    event.preventDefault(); // Prevenir el comportamiento por defecto del botón

    const elementsCount = document.querySelectorAll('#elementsTableBody tr:not(#noElementsRow)').length;
    if (elementsCount === 0) {
        Swal.fire({
            icon: 'error',
            title: 'No hay elementos',
            text: 'Debe agregar al menos un elemento antes de enviar el formulario.',
        });
        return; // Salir de la función si no hay elementos
    }

    this.disabled = true; // Desactivar el botón al hacer clic
    this.innerHTML = 'Enviando...'; // Cambiar texto del botón

    // Enviar el formulario
    const form = document.getElementById('solicitudesCompras'); // Obtener el formulario
    form.submit(); 
});

updateTableMessage();

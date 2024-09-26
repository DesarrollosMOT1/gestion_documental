let elementIndex = 0;
const noElementsRow = document.getElementById('noElementsRow');
const nivelesTresSet = new Set(); // Crear un Set para almacenar los niveles tres agregados

function updateTableMessage() {
    const tableBody = document.getElementById('elementsTableBody');
    const rows = tableBody.querySelectorAll('tr:not(#noElementsRow)');
    noElementsRow.style.display = rows.length === 0 ? '' : 'none';
}

document.getElementById('addElement').addEventListener('click', function() {
    const nivelesTres = document.getElementById('select_niveles_tres');
    const centrosCostos = document.getElementById('select_id_centros_costos');
    const cantidad = document.getElementById('input_cantidad').value;
    const resetOption = document.getElementById('reset_options').value;

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

    // Verificar si el nivel tres ya fue agregado
    if (nivelesTresSet.has(nivelesTresValue)) {
        Swal.fire({
            icon: 'warning',
            title: 'Elemento ya agregado',
            text: 'Ya hay un elemento agregado, cambialo',
        });
        return; // Salir de la función si el nivel tres ya existe
    }

    // Agregar el nivel tres al conjunto
    nivelesTresSet.add(nivelesTresValue);

    // Agregar la fila a la tabla
    createRow(elementIndex, nivelesTresText, centrosCostosText, cantidad, nivelesTresValue, centrosCostosValue);
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

function createRow(elementIndex, nivelesTresText, centrosCostosText, cantidad, nivelesTresValue, centrosCostosValue) {
    const tableBody = document.getElementById('elementsTableBody');
    const newRow = document.createElement('tr');
    newRow.id = `element-${elementIndex}`;
    
    const cellData = [nivelesTresText, centrosCostosText, cantidad];
    cellData.forEach(text => {
        const cell = document.createElement('td');
        cell.textContent = text;
        newRow.appendChild(cell);
    });

    const cell4 = document.createElement('td');
    const deleteButton = document.createElement('button');
    deleteButton.textContent = 'Eliminar';
    deleteButton.className = 'btn btn-danger';
    deleteButton.addEventListener('click', () => removeElement(elementIndex));
    cell4.appendChild(deleteButton);
    newRow.appendChild(cell4);

    // Crear inputs ocultos
    const hiddenInputs = [
        { name: `elements[${elementIndex}][id_niveles_tres]`, value: nivelesTresValue },
        { name: `elements[${elementIndex}][id_centros_costos]`, value: centrosCostosValue },
        { name: `elements[${elementIndex}][cantidad]`, value: cantidad }
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

function removeElement(index) {
    const row = document.getElementById(`element-${index}`);
    const nivelesTresValue = row.querySelector(`input[name="elements[${index}][id_niveles_tres]"]`).value;

    // Eliminar el nivel tres del conjunto
    nivelesTresSet.delete(nivelesTresValue);

    row.remove();
    updateTableMessage();
}

document.getElementById('submitForm').addEventListener('click', async function(event) {
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

    try {
        const form = document.getElementById('solicitudesCompras'); // Obtener el formulario
        const formData = new FormData(form); // Crear un objeto FormData con los datos del formulario

        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        });

        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Solicitud enviada',
                text: 'La solicitud se ha enviado correctamente.',
            }).then(() => {
                window.location.href = '/solicitudes-compras'; // Redirigir a la página de solicitudes
            });
        } else {
            const error = await response.json();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Ocurrió un error al enviar la solicitud.',
            });
        }
    } catch (error) {
        console.error('Error en la solicitud:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al enviar la solicitud.',
        });
    } finally {
        this.disabled = false; // Reactivar el botón al finalizar
        this.innerHTML = 'Enviar'; // Restablecer texto del botón
    }
});

updateTableMessage();

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
    const descripcionElemento = document.getElementById('input_descripcion').value;

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
    if (descripcionElemento.length > 255) {
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
    createRow(elementIndex, nivelesTresText, centrosCostosText, cantidad, nivelesTresValue, centrosCostosValue, descripcionElemento);
    elementIndex++;

    // Lógica para limpiar campos basada en la opción seleccionada
    if (resetOption === 'all') {
        $('#select_niveles_uno').val(null).trigger('change');
        $('#select_niveles_dos').val(null).trigger('change');
        $('#select_niveles_tres').val(null).trigger('change');
        $('#select_id_centros_costos').val(null).trigger('change');
        document.getElementById('input_cantidad').value = '';
        document.getElementById('input_descripcion').value = '';
    } else if (resetOption === 'partial') {
        $('#select_id_centros_costos').val(null).trigger('change');
        document.getElementById('input_cantidad').value = '';
        document.getElementById('input_descripcion').value = '';
    }

    updateTableMessage();
});

// Función para configurar el contador de caracteres
function configurarContadorCaracteres(textareaId, contadorId) {
    const textarea = document.getElementById(textareaId);
    const contador = document.getElementById(contadorId);

    textarea.addEventListener('input', function() {
        const maxLength = textarea.getAttribute('maxlength');
        const currentLength = textarea.value.length;
        contador.textContent = `${currentLength} / ${maxLength}`;

        if (currentLength > maxLength) {
            contador.classList.add('text-danger');
        } else {
            contador.classList.remove('text-danger');
        }
    });
}

function createRow(elementIndex, nivelesTresText, centrosCostosText, cantidad, nivelesTresValue, centrosCostosValue, descripcionElemento) {
    const tableBody = document.getElementById('elementsTableBody');
    const newRow = document.createElement('tr');
    newRow.id = `element-${elementIndex}`;
    
    // Obtener la información de equivalencias del select actual
    const selectedOption = document.querySelector('#select_niveles_tres option:checked');
    const unidadPrincipal = selectedOption.dataset.unidad;
    const equivalencias = JSON.parse(selectedOption.dataset.equivalencias || '[]');
    
    // Calcular equivalencias
    const equivalenciasCalculadas = equivalencias.map(eq => {
        const cantidadCalculada = parseFloat(cantidad) * parseFloat(eq.cantidad);
        // Redondear a 2 decimales y eliminar decimales si son cero
        const cantidadFormateada = Number(cantidadCalculada.toFixed(2))
            .toString()
            .replace(/\.?0+$/, '');
        
        return {
            unidad: eq.unidad_equivalente,
            cantidad: cantidadFormateada
        };
    });
    
    // Formatear la cantidad principal también
    const cantidadPrincipalFormateada = Number(parseFloat(cantidad).toFixed(2))
        .toString()
        .replace(/\.?0+$/, '');
    
    // Crear texto de equivalencias
    const equivalenciasTexto = equivalenciasCalculadas.length > 0 
        ? `(${equivalenciasCalculadas.map(eq => `${eq.cantidad} ${eq.unidad}`).join(', ')})`
        : '';
    
    // Crear las celdas de la tabla
    const cantidadConEquivalencias = `${cantidadPrincipalFormateada} ${unidadPrincipal} ${equivalenciasTexto}`;
    
    const cellData = [nivelesTresText, centrosCostosText, cantidadConEquivalencias, descripcionElemento || ''];
    
    cellData.forEach(text => {
        const cell = document.createElement('td');
        cell.className = 'align-middle';
        cell.innerHTML = `<div class="text-break">${text}</div>`;
        newRow.appendChild(cell);
    });

    // Agregar botón de eliminar
    const cell4 = document.createElement('td');
    cell4.className = 'align-middle text-center';
    const deleteButton = document.createElement('button');
    deleteButton.innerHTML = '<i class="fas fa-trash"></i> Eliminar';
    deleteButton.className = 'btn btn-danger btn-sm';
    deleteButton.addEventListener('click', () => removeElement(elementIndex, nivelesTresValue, centrosCostosValue));
    cell4.appendChild(deleteButton);
    newRow.appendChild(cell4);

    // Crear inputs ocultos
    const hiddenInputs = [
        { name: `elements[${elementIndex}][id_niveles_tres]`, value: nivelesTresValue },
        { name: `elements[${elementIndex}][id_centros_costos]`, value: centrosCostosValue },
        { name: `elements[${elementIndex}][cantidad]`, value: cantidad },
        { name: `elements[${elementIndex}][descripcion_elemento]`, value: descripcionElemento || '' }
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
configurarContadorCaracteres('input_descripcion', 'contador_caracteres');
configurarContadorCaracteres('descripcion', 'contador_caracteres_descripcion');
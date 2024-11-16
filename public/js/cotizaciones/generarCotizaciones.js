document.addEventListener('DOMContentLoaded', function () {
    const solicitudOfertaId = document.getElementById('solicitud_oferta_id').value;
    const elementosContainer = document.getElementById('elementos_container');
    const loadingSpinner = document.getElementById('loading-spinner');
    const selectTerceros = document.getElementById('id_terceros');
    const inputNombre = document.getElementById('nombre');

    // Función para mostrar u ocultar el spinner de carga
    const toggleLoadingSpinner = (show) => {
        loadingSpinner.style.display = show ? 'block' : 'none';
    };

    // Función para generar opciones del select de impuestos
    const generateImpuestosOptions = (impuestosData, selectedId) => {
        const options = [
            '<option value="" disabled selected>Seleccione una opción</option>',
            ...impuestosData.map(impuesto => 
                `<option value="${impuesto.id}" ${selectedId === impuesto.id ? 'selected' : ''}>
                    ${impuesto.tipo} (${impuesto.porcentaje}%)
                </option>`
            )
        ].join('');
        return options;
    };

    // Función para generar HTML dinámico para los elementos
    const generateElementHtml = (elemento, index, impuestosOptions) => {
        const nivelesTres = elemento.solicitudes_elemento.niveles_tres.nombre;
        const cantidad = elemento.consolidacione.cantidad;
        return `
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Elemento: ${nivelesTres}</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="cantidad_${index}">Cantidad</label>
                            <input type="number" name="elementos[${index}][cantidad]" id="cantidad_${index}" class="form-control" value="${cantidad}" required readonly>
                            <div class="invalid-feedback">La cantidad es requerida y debe ser un número.</div>
                        </div>
                        <div class="col-md-3">
                            <label for="cantidad_${index}">Descuento</label>
                            <input type="number" name="elementos[${index}][descuento]" id="descuento_${index}" class="form-control" value="0" required>
                            <div class="invalid-feedback">El descuento es requerido y debe ser un número.</div>
                        </div>
                        <div class="col-md-3">
                            <label for="impuesto_${index}">Impuesto</label>
                            <select name="elementos[${index}][id_impuestos]" id="impuesto_${index}" class="form-control" required>
                                ${impuestosOptions}
                            </select>
                            <div class="invalid-feedback">Debe seleccionar un impuesto.</div>
                        </div>
                        <div class="col-md-3">
                            <label for="precio_${index}">Precio</label>
                            <input type="text" name="elementos[${index}][precio]" id="precio_${index}" class="form-control" placeholder="Precio" required>
                            <div class="invalid-feedback">El precio es requerido y debe ser un número.</div>
                        </div>
                    </div>
                    <input type="hidden" name="elementos[${index}][id_solicitudes_compras]" value="${elemento.id_solicitudes_compras}">
                    <input type="hidden" name="elementos[${index}][id_solicitud_elemento]" value="${elemento.id_solicitud_elemento}">
                    <input type="hidden" name="elementos[${index}][id_consolidaciones_oferta]" value="${elemento.id}">
                </div>
            </div>
        `;
    };

    // Función para manejar la validación del formulario
    const validateForm = (form) => {
        let isValid = true;
        form.querySelectorAll('[name^="elementos["]').forEach((input) => {
            if (!input.value || (input.type === 'number' && isNaN(input.value))) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });
        return isValid;
    };

    // Función para actualizar el campo de nombre
    const updateNombre = () => {
        const selectedOption = selectTerceros.options[selectTerceros.selectedIndex];
        if (selectedOption) {
            const optionText = selectedOption.text;
            
            // Usamos una expresión regular para extraer el NIT del texto
            const nitMatch = optionText.match(/\(NIT: ([\d]+)\)/);
            const nit = nitMatch ? nitMatch[1] : '';
            
            // Obtenemos el nombre del texto después del NIT
            const nombre = optionText.split(') - ')[1] || '';

            inputNombre.value = 'Cotización para ' + nombre + ' (NIT: ' + nit + ')';
        }
    };

    // Función principal para cargar datos y renderizar
    const loadData = async () => {
        toggleLoadingSpinner(true); // Mostrar spinner de carga

        try {
            const [elementosResponse, impuestosResponse] = await Promise.all([
                fetch(`/api/solicitudes-oferta/${solicitudOfertaId}/elementos`),
                fetch('/api/impuestos')
            ]);

            if (!elementosResponse.ok || !impuestosResponse.ok) {
                throw new Error('Error en la respuesta de la API');
            }

            const elementosData = await elementosResponse.json();
            const impuestosData = await impuestosResponse.json();

            elementosContainer.innerHTML = ''; // Limpiar contenedor

            elementosData.forEach((elemento, index) => {
                const impuestosOptions = generateImpuestosOptions(impuestosData, elemento.id_impuestos);
                const html = generateElementHtml(elemento, index, impuestosOptions);
                elementosContainer.insertAdjacentHTML('beforeend', html);
            });

            // Agregar validación del formulario
            const form = document.querySelector('form');
            form.addEventListener('submit', function (event) {
                if (!validateForm(form)) {
                    event.preventDefault();
                }
            });

        } catch (error) {
            console.error('Error al cargar los elementos o impuestos:', error);
            // Aquí podrías agregar una notificación o mensaje al usuario sobre el error
        } finally {
            toggleLoadingSpinner(false); // Ocultar spinner en cualquier caso
        }
    };

    // Inicializar datos
    loadData();

    // Agregar un event listener al select para detectar cambios
    selectTerceros.addEventListener('change', updateNombre);

    // Actualizar el nombre al cargar el modal si ya hay una selección
    if (selectTerceros.value) {
        updateNombre();
    }

    // Agregar SweetAlert2 para confirmación antes de enviar
    $('#btnEnviar').on('click', function(e) {
        e.preventDefault(); // Evitar el envío inmediato del formulario
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas crear esta cotizacion?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, crear',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, enviar el formulario
                $(this).closest('form').submit();
            }
        });
    });
});

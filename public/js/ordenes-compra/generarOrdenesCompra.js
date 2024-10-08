document.addEventListener('DOMContentLoaded', function () {
    const agrupacionId = document.getElementById('agrupaciones_consolidaciones_id').value;
    const formularioOrdenesCompra = document.getElementById('formularioOrdenesCompra');
    const btnEnviar = document.getElementById('btnEnviarOrden');
    const formularioOrden = document.getElementById('formularioOrden');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Función para habilitar/deshabilitar el botón de enviar
    const toggleGenerateButton = (enable) => {
        btnEnviar.disabled = !enable;
    };

    // Inicializar el botón deshabilitado
    toggleGenerateButton(false);

    // Función para obtener las cotizaciones desde la API
    const fetchCotizaciones = async () => {
        try {
            const response = await fetch(`/cotizaciones-precio/estado-jefe/${agrupacionId}`);
            const data = await response.json();
            
            if (data.success && data.data.length > 0) {
                mostrarCotizaciones(data.data);
                // Habilitar el botón solo después de que las cotizaciones sean mostradas correctamente
                toggleGenerateButton(document.querySelectorAll('#formularioOrdenesCompra .card').length > 0);
            } else {
                mostrarError('No hay cotizaciones disponibles.');
                toggleGenerateButton(false);
            }
        } catch (error) {
            console.error('Error al hacer la solicitud:', error);
            mostrarError('Error al obtener las cotizaciones.');
            toggleGenerateButton(false);
        }
    };

    // Función para mostrar las cotizaciones en el formulario
    const mostrarCotizaciones = (cotizaciones) => {
        formularioOrdenesCompra.innerHTML = ''; // Limpiar el div antes de mostrar nuevas cotizaciones
        cotizaciones.forEach((cotizacion, index) => {
            const tarjeta = document.createElement('div');
            tarjeta.classList.add('col-md-4', 'mb-3');
            tarjeta.innerHTML = generarCotizacionHTML(cotizacion, index);
            formularioOrdenesCompra.appendChild(tarjeta);
        });
    };

    // Función para generar el HTML de una cotización
    const generarCotizacionHTML = (cotizacion, index) => {
        return `
            <div class="card rounded-lg mb-3 bg-light">
                <div class="card-body p-4">
                    <h5 class="card-title text-primary">${cotizacion.consolidacione.solicitudes_elemento.niveles_tres.nombre}</h5>
                    <input type="hidden" name="cotizaciones[${index}][id]" value="${cotizacion.id}">
                    <input type="hidden" name="cotizaciones[${index}][id_solicitudes_cotizaciones]" value="${cotizacion.solicitudes_cotizacione.id}">
                    <input type="hidden" name="cotizaciones[${index}][id_consolidaciones_oferta]" value="${cotizacion.solicitudes_cotizacione.id_consolidaciones_oferta}">
                    <input type="hidden" name="cotizaciones[${index}][id_solicitud_elemento]" value="${cotizacion.solicitudes_cotizacione.id_solicitud_elemento}">
                    <input type="hidden" name="cotizaciones[${index}][id_cotizaciones_precio]" value="${cotizacion.id}">
                    <input type="hidden" name="cotizaciones[${index}][id_terceros]" value="${cotizacion.solicitudes_cotizacione.cotizacione.id_terceros}">
                    <p class="card-text"><strong>Precio:</strong> ${cotizacion.solicitudes_cotizacione.precio}</p>
                    <p class="card-text"><strong>Cantidad:</strong> ${cotizacion.solicitudes_cotizacione.cantidad}</p>
                    <p class="card-text"><strong>Cotización:</strong> ${cotizacion.solicitudes_cotizacione.cotizacione.nombre}</p>
                </div>
            </div>
        `;
    };    

    // Función para mostrar errores
    const mostrarError = (mensaje) => {
        formularioOrdenesCompra.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Atención!</strong> ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    };

    // Función para contar los terceros únicos
    const contarTercerosUnicos = () => {
        const cotizaciones = Array.from(document.querySelectorAll('#formularioOrdenesCompra .card'));
        const idTerceros = new Set();

        cotizaciones.forEach(cotizacion => {
            const idTercero = cotizacion.querySelector('input[name^="cotizaciones"][name$="[id_terceros]"]').value;
            idTerceros.add(idTercero);
        });

        return idTerceros.size; // Devuelve la cantidad de terceros únicos
    };

    // Función para mostrar la alerta de confirmación antes de enviar el formulario
    const confirmarEnvio = (e) => {
        e.preventDefault(); // Prevenir el envío por defecto

        // Validar que haya al menos una cotización
        if (document.querySelectorAll('#formularioOrdenesCompra .card').length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe haber al menos una cotización para crear la orden de compra.',
            });
            return;
        }

        const numOrdenes = contarTercerosUnicos();

        Swal.fire({
            title: `¿Deseas crear ${numOrdenes} orden${numOrdenes === 1 ? '' : 'es'} de compra?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, crear',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                formularioOrden.submit(); // Enviar el formulario si el usuario confirma
            }
        });
    };

    // Asociar la función de confirmación al evento submit del formulario
    formularioOrden.addEventListener('submit', confirmarEnvio);

    // Llamar a la función para obtener las cotizaciones al cargar el modal
    fetchCotizaciones();
});

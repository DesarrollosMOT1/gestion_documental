@if (session('updateClave'))
    <script>
        Swal.fire({
            title: 'Éxito',
            text: '{{ session('updateClave') }}',
            icon: 'success',
            timer: 3500, // La alerta se cerrará automáticamente después de 3.5 segundos
            showConfirmButton: false // Ocultar el botón "Aceptar"
        });
    </script>
@endif

@if (session('updateName'))
    <script>
        Swal.fire({
            title: 'Éxito',
            text: '{{ session('updateName') }}',
            icon: 'success',
            timer: 3500, // La alerta se cerrará automáticamente después de 3.5 segundos
            showConfirmButton: false // Ocultar el botón "Aceptar"
        });
    </script>
@endif

@if (session('updateEmail'))
    <script>
        Swal.fire({
            title: 'Éxito',
            text: '{{ session('updateEmail') }}',
            icon: 'success',
            timer: 3500, // La alerta se cerrará automáticamente después de 3.5 segundos
            showConfirmButton: false // Ocultar el botón "Aceptar"
        });
    </script>
@endif

@if (session('claveIncorrecta'))
    <script>
        Swal.fire({
            title: 'Error',
            text: '{{ session('claveIncorrecta') }}',
            icon: 'error',
            timer: 3500, // La alerta se cerrará automáticamente después de 3.5 segundos
            showConfirmButton: false // Ocultar el botón "Aceptar"
        });
    </script>
@endif

@if (session('clavemenor'))
    <script>
        Swal.fire({
            title: 'Advertencia',
            text: '{{ session('clavemenor') }}',
            icon: 'warning',
            timer: 3500, // La alerta se cerrará automáticamente después de 3.5 segundos
            showConfirmButton: false // Ocultar el botón "Aceptar"
        });
    </script>
@endif
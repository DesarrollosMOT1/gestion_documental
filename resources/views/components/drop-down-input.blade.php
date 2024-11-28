@props(['name', 'route'])

<div class="form-group mb-3">
    <!-- Usamos el valor de $name para el id y el name del select -->
    <label for="{{ $name }}Select" class="form-label">{{ ucfirst($name) }}</label>
    <select name="{{ $name }}" id="{{ $name }}Select" class="form-control select2" required>
        <option value="">{{ __('Seleccione una opción') }}</option>
    </select>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectElement = document.getElementById('{{ $name }}Select');

        fetch('{{ $route }}')
            .then(response => response.json())
            .then(data => {
                // Limpiar las opciones previas
                selectElement.innerHTML = '<option value="">{{ __('Seleccione una opción') }}</option>';

                // Agregar nuevas opciones
                data.forEach(item => {
                    let option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.id + " - " + item.name;
                    selectElement.appendChild(option);
                });

            })
            .catch(error => console.error('Error al cargar las opciones:', error));
    });
</script>

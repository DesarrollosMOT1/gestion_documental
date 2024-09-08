@props(['name', 'route'])

<div class="form-group mb-3">
    <label for="{{ $name }}Select" class="form-label">{{ ucfirst($name) }}</label>
    <select name="{{ $name }}" id="{{ $name }}Select" class="form-control" required>
        <option value="">{{ __('Seleccione una opción') }}</option>
    </select>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ $route }}')
            .then(response => response.json())
            .then(data => {
                let selectElement = document.getElementById('{{ $name }}Select');
                    data.forEach(item => {
                        let option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.id + " - "+ item.name;
                        selectElement.appendChild(option);
                    });
            })
            .catch(error => console.error('Error al cargar las opciones:', error));
    });
</script>

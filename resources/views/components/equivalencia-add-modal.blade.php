<!-- Modal -->
<a class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#equivalenciaModal">
    {{ __('Crear Equivalencia') }}
</a>
<div class="modal fade" id="equivalenciaModal" tabindex="-1" aria-labelledby="equivalenciaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="equivalenciaModalLabel">{{ __('Crear Equivalencia') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="equivalenciaForm" method="POST"
                    action="{{ route('equivalencias.store-request-equivalencia') }}" role="form"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="unidad_principal" id="unidad_principal"
                        value="{{ $idUnidadPrincipal }}">

                    <div class="form-group mb-2 mb20">
                        <label for="unidad_equivalente" class="form-label">{{ __('Unidad Equivalente') }}</label>
                        <select id="unidad_equivalente" name="unidad_equivalente" onchange="handleUnidadChange()"
                            class="form-control" required>
                            <option value="">Seleccione una unidad equivalente</option>
                        </select>
                        {!! $errors->first(
                            'unidad_equivalente',
                            '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
                        ) !!}
                    </div>

                    <div class="form-group mb-3">
                        <label for="cantidad" class="form-label">{{ __('Cantidad') }}</label>
                        <input type="number" name="cantidad" class="form-control" id="cantidad" required
                            min="1" step="1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                <button type="submit" class="btn btn-primary" id="crearEquivalenciaBtn"
                    form="equivalenciaForm">{{ __('Crear') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar las unidades equivalentes
        fetch('{{ route('unidades.get-all') }}')
            .then(response => response.json())
            .then(data => {
                const unidadSelect = document.getElementById('unidad_equivalente');
                unidadSelect.innerHTML =
                    '<option value="">Seleccione una unidad equivalente</option>'; // Resetear las opciones

                if (data.length > 0) {
                    data.forEach(option => {
                        const opt = document.createElement('option');
                        opt.value = option.id;
                        opt.textContent = option.name;
                        unidadSelect.appendChild(opt);
                    });
                } else {
                    console.log('No se encontraron unidades equivalentes');
                }

                handleUnidadChange(); // Llamar a esta función para actualizar el campo de cantidad
            })
            .catch(error => console.error('Error al cargar las unidades equivalentes:', error));
    });

    // Actualizar el campo de cantidad según la selección de unidad
    function handleUnidadChange() {
        const unidadSelect = document.getElementById('unidad_equivalente');
        const cantidadInput = document.getElementById('cantidad');

        if (unidadSelect.value === 'base') {
            cantidadInput.value = 1;
            cantidadInput.setAttribute('readonly', true);
        } else {
            cantidadInput.removeAttribute('readonly');
        }
    }
</script>

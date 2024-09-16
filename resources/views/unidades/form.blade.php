<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $unidades?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="unidad" class="form-label">{{ __('Unidad Equivalente') }}</label>
            <select id="unidad" name="unidad" onchange="fetchClases(this.value)" class="form-control">
                <option value="">Seleccione una unidad equivalente</option>
            </select>
            {!! $errors->first('unidad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="cantidad" class="form-label">{{ __('Cantidad') }}</label>
            <input type="number" name="cantidad" class="form-control" id="cantidad" required min="1"
                step="1">
        </div>
    </div>

    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Crear') }}</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('{{ route('unidades.get-all') }}')
            .then(response => response.json())
            .then(data => {
                const tipoSelect = document.getElementById('unidad');
                const opt = document.createElement('option');
                opt.value = "base";
                opt.textContent = "base";
                tipoSelect.appendChild(opt);
                data.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option.id;
                    opt.textContent = option.name;
                    tipoSelect.appendChild(opt);
                });
            })
            .catch(error => console.error('Error al cargar las unidades equivalentes:', error));
    });
</script>

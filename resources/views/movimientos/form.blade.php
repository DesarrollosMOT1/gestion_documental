<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="tipoSelect" class="form-label">{{ __('Tipo de Movimiento') }}</label>
            <select id="tipoSelect" name="tipo" onchange="fetchClases(this.value)" class="form-control">
                <option value="">Seleccione un tipo de movimiento</option>
            </select>
            {!! $errors->first('tipo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="claseSelect" class="form-label">{{ __('Clase de Movimiento') }}</label>
            <select id="claseSelect" name="clase" class="form-control">
                <option value="">Seleccione una clase de movimiento</option>
            </select>
            {!! $errors->first('clase', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <x-drop-down-input name="almacen" route="{{ route('almacenes.get-all') }}" />
            {!! $errors->first('almacen', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha" class="form-label">{{ __('Fecha') }}</label>
            <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', $movimiento?->fecha) }}" id="fecha" placeholder="Fecha">
            {!! $errors->first('fecha', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="descripcion" class="form-label">{{ __('Descripcion') }}</label>
            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" placeholder="Descripcion">{{ old('descripcion', $movimiento?->descripcion) }}</textarea>
            {!! $errors->first('descripcion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ route("tiposMovimientos.get-all") }}')
            .then(response => response.json())
            .then(data => {
                const tipoSelect = document.getElementById('tipoSelect');
                data.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option.id;
                    opt.textContent = option.id + " - " + option.name;
                    tipoSelect.appendChild(opt);
                });
            })
            .catch(error => console.error('Error al cargar los tipos de movimientos:', error));
    });

    function fetchClases(tipoId) {
        const claseSelect = document.getElementById('claseSelect');
        claseSelect.innerHTML = '<option value="">Seleccione una clase de movimiento</option>';

        if (tipoId) {
            const url = `{{ route('clases-movimientos.get-all-by-typeid', ['typeId' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', tipoId);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    data.forEach(option => {
                        const opt = document.createElement('option');
                        opt.value = option.id;
                        opt.textContent = option.id + " - " + option.name;
                        claseSelect.appendChild(opt);
                    });
                })
                .catch(error => console.error('Error al cargar las clases de movimientos:', error));
        }
    }
</script>

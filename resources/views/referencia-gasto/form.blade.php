@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="codigo" class="form-label">{{ __('Codigo') }}</label>
            <input type="text" name="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo', $referenciaGasto?->codigo) }}" id="codigo" placeholder="Codigo">
            {!! $errors->first('codigo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $referenciaGasto?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="linea" class="form-label">{{ __('Linea') }}</label>
            <select name="linea" id="linea" class="form-control @error('linea') is-invalid @enderror">
                <option value="">{{ __('Seleccione una linea') }}</option>
                @foreach($lineas as $linea)
                    <option value="{{ $linea->codigo }}" {{ old('linea', $referenciaGasto?->linea) == $linea->codigo ? 'selected' : '' }}>
                        {{ $linea->nombre }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('linea', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>        
    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


<script>
    $(document).ready(function() {
        // Inicializar select2 
        $('#linea').selectpicker({
            theme: 'bootstrap-5',
            liveSearch: true,
            allowClear: true,
            placeholder: 'Seleccione una opcion',
        });
    });
</script>

@endsection
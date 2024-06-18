@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="fecha_solicitud" class="form-label">{{ __('Fecha Solicitud') }}</label>
            <input type="date" name="fecha_solicitud" class="form-control @error('fecha_solicitud') is-invalid @enderror" value="{{ old('fecha_solicitud', $solicitudCompra?->fecha_solicitud) }}" id="fecha_solicitud" placeholder="Fecha Solicitud">
            {!! $errors->first('fecha_solicitud', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre del solicitante') }}</label>
            <select name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre">
                <option value="">Seleccione Nombre del Solicitante</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('nombre', $solicitudCompra?->nombre) == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="area">Área</label>
            <select name="area" id="area" class="form-control @error('area') is-invalid @enderror">
                <option value="">Seleccione Área</option>
                <option value="Administrativa" {{ old('area', $solicitudCompra->area) == 'Administrativa' ? 'selected' : '' }}>Administrativa</option>
                <option value="Financiera" {{ old('area', $solicitudCompra->area) == 'Financiera' ? 'selected' : '' }}>Financiera</option>
                <option value="Comercial" {{ old('area', $solicitudCompra->area) == 'Comercial' ? 'selected' : '' }}>Comercial</option>
                <option value="Operaciones" {{ old('area', $solicitudCompra->area) == 'Operaciones' ? 'selected' : '' }}>Operaciones</option>
            </select>
            @error('area')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="tipo_factura">Tipo Factura</label>
            <select name="tipo_factura" id="tipo_factura" class="form-control @error('tipo_factura') is-invalid @enderror">
                <option value="">Seleccione Tipo de Factura</option>
                <option value="CFC02" {{ old('tipo_factura' , $solicitudCompra->tipo_factura) == 'CFC02' ? 'selected' : '' }}>CFC02</option>
                <option value="CFC04" {{ old('tipo_factura', $solicitudCompra->tipo_factura) == 'CFC04' ? 'selected' : '' }}>CFC04</option>
                <option value="CFC06" {{ old('tipo_factura', $solicitudCompra->tipo_factura) == 'CFC06' ? 'selected' : '' }}>CFC06</option>
            </select>
            @error('tipo_factura')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="prefijo" class="form-label">{{ __('Prefijo') }}</label>
            <input type="text" name="prefijo" class="form-control @error('prefijo') is-invalid @enderror" value="{{ old('prefijo', $solicitudCompra?->prefijo) }}" id="prefijo" placeholder="Prefijo">
            {!! $errors->first('prefijo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="cantidad" class="form-label">{{ __('Cantidad') }}</label>
            <input type="text" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad', $solicitudCompra?->cantidad) }}" id="cantidad" placeholder="Cantidad">
            {!! $errors->first('cantidad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nota" class="form-label">{{ __('Nota') }}</label>
            <input type="text" name="nota" class="form-control @error('nota') is-invalid @enderror" value="{{ old('nota', $solicitudCompra?->nota) }}" id="nota" placeholder="Nota">
            {!! $errors->first('nota', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group">
            <label for="id_centro_costo">Centro de Costo</label>
            <select name="id_centro_costo" id="id_centro_costo" class="form-control @error('id_centro_costo') is-invalid @enderror">
                <option value="">Seleccione Centro de Costo</option>
                @foreach ($centro_costo as $cc)
                    <option value="{{ $cc->codigo }}" {{ old('id_centro_costo', $solicitudCompra->id_centro_costo) == $cc->codigo ? 'selected' : '' }}>
                        {{ $cc->codigo }} => {{ $cc->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_centro_costo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_referencia_gastos">Referencia de Gastos</label>
            <select name="id_referencia_gastos" id="id_referencia_gastos" class="form-control bootstrap-select @error('id_referencia_gastos') is-invalid @enderror">
                <option value="">Seleccione Referencia de Gastos</option>
                @foreach ($referencia_gasto as $rg)
                    <option value="{{ $rg->codigo }}" {{ old('id_referencia_gastos', $solicitudCompra->id_referencia_gastos) == $rg->codigo ? 'selected' : '' }}>
                        {{ $rg->codigo }} => {{ $rg->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_referencia_gastos')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
        $('#nombre').selectpicker({
            theme: 'bootstrap-5',
            liveSearch: true,
            allowClear: true,
            placeholder: 'Seleccione una opcion',
        });
        $('#area').selectpicker({
            theme: 'bootstrap-5',
            liveSearch: true,
            allowClear: true,
            placeholder: 'Seleccione una opcion',
        });
    
        // Inicializar select2 para el select de identificación de usuario
        $('#tipo_factura').selectpicker({
            theme: 'bootstrap-5',
            liveSearch: true,
            allowClear: true,
            placeholder: 'Seleccione una opcion',
        });

        $('#id_centro_costo').selectpicker({
            theme: 'bootstrap-5',
            liveSearch: true,
            allowClear: true,
            placeholder: 'Seleccione una opcion',
        });

        $('#id_referencia_gastos').selectpicker({
          theme: 'bootstrap-5',
          liveSearch: true,
          allowClear: true,
          placeholder: 'Seleccione una opcion',
        });
    });
</script>

@endsection
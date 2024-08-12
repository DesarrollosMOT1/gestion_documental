<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="fecha_emision" class="form-label"></i>{{ __('Fecha Emisión') }}</label>
            <input type="date" name="fecha_emision" class="form-control @error('fecha_emision') is-invalid @enderror" value="{{ old('fecha_emision', $ordenesCompra?->fecha_emision) }}" id="fecha_emision" placeholder="Fecha Emisión">
            {!! $errors->first('fecha_emision', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-3">
            <label for="subtotal" class="form-label">{{ __('Subtotal') }}
            </label>
            <input type="text" name="subtotal" class="form-control @error('subtotal') is-invalid @enderror" value="{{ old('subtotal', $ordenesCompra?->subtotal) }}" id="subtotal" placeholder="Subtotal">
            {!! $errors->first('subtotal', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-3">
            <label for="total" class="form-label">{{ __('Total') }}
            </label>
            <input type="text" name="total" class="form-control @error('total') is-invalid @enderror" value="{{ old('total', $ordenesCompra?->total) }}" id="total" placeholder="Total">
            {!! $errors->first('total', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="cantidad_total" class="form-label">{{ __('Cantidad Total') }}
            </label>
            <input type="text" name="cantidad_total" class="form-control @error('cantidad_total') is-invalid @enderror" value="{{ old('cantidad_total', $ordenesCompra?->cantidad_total) }}" id="cantidad_total" placeholder="Cantidad Total">
            {!! $errors->first('cantidad_total', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-3">
            <label for="nota" class="form-label">{{ __('Nota') }}
            </label>
            <textarea name="nota" class="form-control @error('nota') is-invalid @enderror" id="nota" rows="4" placeholder="Nota">{{ old('nota', $ordenesCompra?->nota) }}</textarea>
            {!! $errors->first('nota', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>
</div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
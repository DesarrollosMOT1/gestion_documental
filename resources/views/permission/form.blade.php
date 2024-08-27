<div class="row padding-1 p-1">
    <div class="col-md-12">
        <div class="form-group mb-4">
            <label for="name" class="form-label">{{ __('Nombre del Permiso') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $permission?->name) }}" id="name" 
                   placeholder="Ingrese el nombre del permiso">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-12 mt-4">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
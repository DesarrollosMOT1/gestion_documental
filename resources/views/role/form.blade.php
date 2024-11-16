<div class="row padding-1 p-1">
    <div class="col-md-12">
        <div class="form-group mb-4">
            <label for="name" class="form-label">{{ __('Nombre del Rol') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role?->name) }}" id="name" placeholder="Ingrese el nombre del rol">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="permisos">{{ __('Permisos') }}</label>
            <div class="border p-3 rounded">
                <!-- Llamada al componente PermissionsAccordion -->
                <x-permissions-accordion :permissionsGrouped="$permissionsGrouped" :permissions="$permisos" :role="$role ?? null" />
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-12 mt-4">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
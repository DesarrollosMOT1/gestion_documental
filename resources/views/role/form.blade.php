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
                <div class="row">
                    @foreach ($permisos->chunk(ceil($permisos->count() / 3)) as $chunk)
                        <div class="col-md-4">
                            @foreach ($chunk as $permiso)
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" 
                                        value="{{ $permiso->id }}" id="permiso{{ $permiso->id }}"
                                        {{ (isset($role) && $role->permissions->contains($permiso->id)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permiso{{ $permiso->id }}">
                                        {{ $permiso->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-4">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
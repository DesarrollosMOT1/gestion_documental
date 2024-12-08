<div class="row">
    <!-- Información General -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title m-0"><i class="fas fa-user mr-2"></i>Información del Usuario</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ isset($user) ? 'Nueva contraseña' : 'Contraseña' }}</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" {{ !isset($user) ? 'required' : '' }}>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" {{ !isset($user) ? 'required' : '' }}>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_area">Área</label>
                    <select class="form-control @error('id_area') is-invalid @enderror" id="id_area" name="id_area">
                        <option value="">Seleccione un área</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ (old('id_area', $user->id_area ?? '') == $area->id) ? 'selected' : '' }}>
                                {{ $area->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_area')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Información de Roles y Permisos -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title m-0"><i class="fas fa-user-tag mr-2"></i>Roles y Permisos</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Roles</label>
                    @foreach ($roles as $role)
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                {{ (isset($user) && $user->roles->contains($role)) || (is_array(old('roles')) && in_array($role->id, old('roles'))) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $role->name }}</label>
                        </div>
                    @endforeach
                </div>
            
                <div class="form-group">
                    <label>Permisos</label>
                    <!-- Llamada al componente PermissionsAccordion -->
                    <x-permissions-accordion :permissionsGrouped="$permissionsGrouped" :permissions="$permissions" :role="$user ?? null"/>
                </div>               
            </div> 
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ isset($user) ? 'Actualizar' : 'Crear' }}</button>

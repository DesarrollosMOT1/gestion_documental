<!-- Pestañas -->
<ul class="nav nav-tabs" id="formTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Información General</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Solicitudes Consolidadas</a>
    </li>
</ul>

<!-- Contenido de las pestañas -->
<div class="tab-content" id="formTabsContent">
    <!-- Información General -->
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        <div class="form-group mb-2 mb20">
            <label for="user_id" class="form-label">{{ __('Usuario') }}</label>
            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                <option value="">Seleccionar Usuario</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $consolidacione?->user_id ?? Auth::id()) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('user_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_solicitudes_compras" class="form-label">{{ __('Id Solicitudes Compras') }}</label>
            <input type="text" name="id_solicitudes_compras" class="form-control @error('id_solicitudes_compras') is-invalid @enderror" value="{{ old('id_solicitudes_compras', $consolidacione?->id_solicitudes_compras) }}" id="id_solicitudes_compras" placeholder="Id Solicitudes Compras">
            {!! $errors->first('id_solicitudes_compras', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_solicitud_elemento" class="form-label">{{ __('Id Solicitud Elemento') }}</label>
            <input type="text" name="id_solicitud_elemento" class="form-control @error('id_solicitud_elemento') is-invalid @enderror" value="{{ old('id_solicitud_elemento', $consolidacione?->id_solicitud_elemento) }}" id="id_solicitud_elemento" placeholder="Id Solicitud Elemento">
            {!! $errors->first('id_solicitud_elemento', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="estado" class="form-label">{{ __('Estado') }}</label>
            <input type="text" name="estado" class="form-control @error('estado') is-invalid @enderror" value="{{ old('estado', $consolidacione?->estado) }}" id="estado" placeholder="Estado">
            {!! $errors->first('estado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="cantidad" class="form-label">{{ __('Cantidad') }}</label>
            <input type="text" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad', $consolidacione?->cantidad) }}" id="cantidad" placeholder="Cantidad">
            {!! $errors->first('cantidad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <!-- Solicitudes Consolidadas -->
    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
        <div class="col-md-12 mt-4">
            <h6>Solicitudes consolidadas:</h6>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Solicitud</th>
                        <th>Descripción</th>
                        <th>Fecha de Solicitud</th>
                    </tr>
                </thead>
                <tbody id="solicitudes_consolidadas_tabla">
                    <!-- Aquí se cargarán dinámicamente las solicitudes consolidadas -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Botón de envío -->
<div class="col-md-12 mt20 mt-2">
    <button id="btnEnviar" type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
</div>
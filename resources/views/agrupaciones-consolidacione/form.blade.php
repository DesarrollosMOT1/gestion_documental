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
        <br>
        <h4 class="mb-3">Información General</h4>
        <div class="form-group mb-2 mb20">
            <label for="user_id" class="form-label">{{ __('Usuario') }}</label>
            <x-select-user nombre="user_id" :errores="$errors" />
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha_consolidacion" class="form-label">{{ __('Fecha Consolidacion') }}</label>
            <x-campo-fecha nombre="fecha_consolidacion" :valor="$agrupacionesConsolidacione?->fecha_consolidacion" :errores="$errors" />
        </div>
        <br>
        <h4 class="mb-3">Elementos a consolidar</h4>
        <div id="formularioConsolidacionContainer" class="row g-3">
            <!-- Aquí se cargarán dinámicamente los formularios -->
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
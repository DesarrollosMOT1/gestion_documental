<div class="row">
    <div class="col-md-3">
        <label for="fecha_inicio">Fecha de inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control"
               value="{{ request('fecha_inicio') ?? \Carbon\Carbon::now()->subDays(14)->toDateString() }}">
    </div>
    <div class="col-md-3">
        <label for="fecha_fin">Fecha de fin:</label>
        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control"
               value="{{ request('fecha_fin') ?? \Carbon\Carbon::now()->toDateString() }}">
    </div>
    <div class="col-md-3 align-self-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </div>
</div>

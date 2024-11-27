<x-modal :id="'terceroModal' . $tercero->id" :title="'Gestionar Email - ' . $tercero->nombre" size="lg">
    <form id="updateEmailForm{{ $tercero->id }}" method="POST" action="{{ route('terceros.updateEmail', $tercero->id) }}" class="mb-4">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="email">Correos Electrónicos (separados por comas)</label>
            <input type="text" class="form-control" id="email" name="email" 
                   value="{{ $tercero->email }}" placeholder="email1@ejemplo.com, email2@ejemplo.com">
            <small class="form-text text-muted">Puede ingresar múltiples correos separados por comas</small>
        </div>
        <button type="submit" class="btn btn-primary mt-2">
            <i class="fas fa-save"></i> Actualizar Emails
        </button>
    </form>

    <form action="{{ route($tipo . '.send-emails', ['id' => $modelo->id, 'terceroId' => $tercero->id]) }}" 
            method="POST">
        @csrf
        <div class="form-group">
            <label for="emails">Enviar a estos correos:</label>
            <input type="text" class="form-control" id="emails" name="emails" 
                    value="{{ $tercero->email }}" readonly>
        </div>
        <button type="submit" class="btn btn-success mt-2">
            <i class="fas fa-paper-plane"></i> Enviar Correos
        </button>
    </form>
</x-modal>
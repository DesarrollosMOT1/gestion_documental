{{-- resources/views/tercero/tercero-email.blade.php --}}
<div class="modal fade" id="terceroModal{{ $tercero->id }}" tabindex="-1" aria-labelledby="terceroModalLabel{{ $tercero->id }}" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="terceroModalLabel{{ $tercero->id }}">Gestionar Email - {{ $tercero->nombre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateEmailForm{{ $tercero->id }}" method="POST" action="{{ route('terceros.updateEmail', $tercero->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $tercero->email }}">
                    </div>
                    <div class="d-flex justify-content-start gap-2">
                    <button type="submit" class="btn btn-primary">Actualizar Email</button>
                </form>
                <div class="float-right">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-envelope"></i> Enviar PDF por correo
                    </button>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<div>
    <input 
        type="date" 
        name="{{ $nombre }}" 
        class="form-control @error($nombre) is-invalid @enderror" 
        value="{{ old($nombre, $valor) }}" 
        id="{{ $nombre }}" 
        placeholder="Fecha {{ ucfirst(str_replace('_', ' ', $nombre)) }}"
        required
        readonly
    >
    {!! $errors->first($nombre, '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>

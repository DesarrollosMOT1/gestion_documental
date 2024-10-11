<div>
    <select 
        name="{{ $nombre }}" 
        id="{{ $nombre }}" 
        class="form-control @error($nombre) is-invalid @enderror" 
        required 
        readonly
    >
        <option value="{{ $valor }}" selected>{{ Auth::user()->name }}</option>
    </select>

    {!! $errors->first($nombre, '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>
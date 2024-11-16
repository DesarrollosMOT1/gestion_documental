<div class="accordion" id="permissionsAccordion">
    @foreach ($permissionsGrouped as $category => $permissionsCategory)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading-{{ $loop->index }}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}" aria-expanded="true" aria-controls="collapse-{{ $loop->index }}">
                    {{ $category }}
                </button>
            </h2>
            <div id="collapse-{{ $loop->index }}" class="accordion-collapse collapse @if($loop->first) show @endif" aria-labelledby="heading-{{ $loop->index }}" data-bs-parent="#permissionsAccordion">
                <div class="accordion-body">
                    @foreach ($permissions as $permission)
                        @if (in_array($permission->name, $permissionsCategory))
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                    {{ (isset($role) && $role->permissions->contains($permission)) || (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $permission->name }}</label>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>

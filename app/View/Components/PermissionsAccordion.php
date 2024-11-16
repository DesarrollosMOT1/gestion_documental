<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class PermissionsAccordion extends Component
{

    public $permissionsGrouped;
    public $permissions;
    public $role;

    /**
     * Create a new component instance.
     */
    public function __construct($permissionsGrouped, $permissions, $role = null)
    {
        $this->permissionsGrouped = $permissionsGrouped;
        $this->permissions = $permissions;
        $this->role = $role;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.permissions-accordion');
    }
}

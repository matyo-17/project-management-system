<?php

namespace App\View\Components\Modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ModalRole extends Component
{
    public array $permissions;

    /**
     * Create a new component instance.
     */
    public function __construct(Collection $permissions)
    {
        $permission_list = $others = [];
        foreach ($permissions as $p) {
            $p_data = [
                "id" => str_replace("_", "-", $p->name),
                "value" => $p->id,
                "name" => str_replace("_", " ", $p->name),
            ];

            if ($p->group === null) {
                $others[] = $p_data;
            } else {
                $permission_list[$p->group][] = $p_data;
            }
        }
        $permission_list["Others"] = $others;


        $this->permissions = $permission_list;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.modal-role');
    }
}

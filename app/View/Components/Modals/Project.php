<?php

namespace App\View\Components\Modals;

use App\Lib\Clearance;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Project extends Component
{
    public array $users;
    public bool $is_admin;

    /**
     * Create a new component instance.
     */
    public function __construct(Clearance $clearance)
    {
        $users = [];
        if ($clearance->admin) {
            $users = User::normal_users()->toArray(); 
        }

        $this->users = $users;
        $this->is_admin = $clearance->admin;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.project');
    }
}

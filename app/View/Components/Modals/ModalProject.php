<?php

namespace App\View\Components\Modals;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalProject extends Component
{
    public array $users;
    public User $user;

    /**
     * Create a new component instance.
     */
    public function __construct(User $user)
    {
        $users = [];
        if ($user->is_admin()) {
            $users = User::normal_users()->toArray(); 
        }

        $this->users = $users;
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.modal-project');
    }
}

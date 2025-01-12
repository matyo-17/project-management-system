<?php

namespace App\View\Components\Common;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Navbar extends Component
{
    public array $menu;
    public string $route;

    /**
     * Create a new component instance.
     */
    public function __construct(User $user)
    {
        $menu = [];

        if ($user->has_permission("read_project")) {
            $menu[] = [
                "name" => "Projects",
                "route" => "projects",
            ];
        }

        if ($user->has_permission("read_invoice")) {
            $menu[] = [
                "name" => "Invoices",
                "route" => "invoices",
            ];
        }

        if ($user->has_permission("read_expense")) {
            $menu[] = [
                "name" => "Expenses",
                "route" => "expenses",
            ];
        }

        $this->menu = $menu;
        $this->route = Route::currentRouteName();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.navbar');
    }
}

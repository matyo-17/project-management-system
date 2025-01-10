<?php

namespace App\View\Components\Common;

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
    public function __construct()
    {
        $menu = [];

        $menu[] = [
            "name" => "Projects",
            "route" => "projects",
        ];

        $menu[] = [
            "name" => "Expenses",
            "route" => "expenses",
        ];

        $menu[] = [
            "name" => "Invoices",
            "route" => "invoices",
        ];

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

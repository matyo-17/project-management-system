<?php

namespace App\View\Components\Modals;

use App\Models\Projects;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalProjectInvoice extends Component
{
    public Projects $project;

    /**
     * Create a new component instance.
     */
    public function __construct(Projects $project)
    {
        $this->project = $project;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.modal-project-invoice');
    }
}

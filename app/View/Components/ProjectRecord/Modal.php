<?php

namespace App\View\Components\ProjectRecord;

use App\Models\Project;
use App\Models\ProjectSop;
use Illuminate\View\Component;

class Modal extends Component
{
    public $project;
    public $sopList;

    /**
     * Create a new component instance.
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->sopList = ProjectSop::where('project_type_id', $project->project_type_id)
            ->where('company_id', $project->company_id)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.project-record.modal');
    }
}

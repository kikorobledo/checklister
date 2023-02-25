<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Checklist;

class HeaderTotalsCount extends Component
{

    public $checklist_group_id;

    protected $listeners = ['task_complete' => 'render'];

    public function render()
    {

        $checklists = Checklist::where('checklist_group_id', $this->checklist_group_id)
                                    ->whereNull('user_id')
                                    ->withCount(['tasks' => function($q){ return $q->whereNull('user_id'); }])
                                    ->withCount(['user_tasks' => function($q){ return $q->whereNotNull('compleated_at'); }])
                                    ->get();

        return view('livewire.header-totals-count', compact('checklists'));
    }
}

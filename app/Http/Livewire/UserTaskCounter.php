<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UserTaskCounter extends Component
{

    public string $task_type;
    public int $tasks_counter;

    protected $listeners = ['user_tasks_counter_change' => 'recalculate_tasks'];

    public function recalculate_tasks($task_type, $count_chage = 1){

        if($this->task_type == $task_type){

            $this->tasks_counter += $count_chage;

        }
    }

    public function render()
    {
        return view('livewire.user-task-counter');
    }
}

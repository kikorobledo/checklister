<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Checklist;
use App\Models\ChecklistGroup;

class MenuService{

    public function get_menu(){

        $menu = ChecklistGroup::with(
                                    [
                                        'checklists' => function($q){ $q->whereNull('user_id'); },
                                        'checklists.tasks' => function($q){ $q->whereNull('tasks.user_id'); },
                                        'checklists.user_completed_tasks'
                                    ])
                                    ->get();

        $groups = [];

        $user_checklists = Checklist::where('user_id', auth()->user()->id)->get();

        foreach ($menu->toArray() as $group) {

            if(count($group['checklists']) > 0){

                $group_updated_at = $user_checklists->where('checklist_group_id', $group['id'])->max('updated_at');

                $group['is_new'] = $group_updated_at && Carbon::create($group['created_at'])->greaterThan($group_updated_at);
                $group['is_updated'] = !($group['is_new']) && $group_updated_at && Carbon::create($group['updated_at'])->greaterThan($group_updated_at);

                foreach ($group['checklists'] as &$checklist) {

                    $checklist_updated_at = $user_checklists->where('checklist_id', $checklist['id'])->max('updated_at');

                    $checklist['is_new'] = !($group['is_new']) && $checklist_updated_at && Carbon::create($checklist['created_at'])->greaterThan($checklist_updated_at);
                    $checklist['is_updated'] = !($group['is_new']) && !($group['is_updated']) && $checklist_updated_at && !($checklist['is_new']) && Carbon::create($checklist['updated_at'])->greaterThan($checklist_updated_at);
                    $checklist['tasks_count'] = count($checklist['tasks']);
                    $checklist['completed_tasks_count'] = count($checklist['user_completed_tasks']);

                }

                $groups [] = $group;

            }

        }

        $user_task_menu = [];

        if(!auth()->user()->is_admin){

            $user_tasks = Task::where('user_id', auth()->user()->id)->get();

            $user_task_menu = [

                'my_day' => [
                    'name'=> __('My Day'),
                    'icon' => 'sun',
                    'task_count' => $user_tasks->whereNotNull('added_to_my_day_at')->count()
                ],
                'important' => [
                    'name'=> __('Important'),
                    'icon' => 'star',
                    'task_count' => $user_tasks->where('is_important', 1)->count()
                ],
                'planned' => [
                    'name'=> __('Planned'),
                    'icon' => 'star',
                    'task_count' => $user_tasks->whereNotNull('due_date')->count()
                ]

            ];

        }

        return [
            'admin_menu' => $menu,
            'user_menu' => $groups,
            'user_task_menu' => $user_task_menu
        ];

    }

}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Services\ChecklistService;
use Illuminate\Contracts\View\View;

class ChecklistController extends Controller
{
    public function show(Checklist $checklist):View
    {

        (new ChecklistService())->sync_checklist($checklist, auth()->user()->id);

        return view('users.checklists.show', compact('checklist'));

    }

    public function taskList($list_type){

        return view('users.checklists.tasklist', compact('list_type'));

    }
}

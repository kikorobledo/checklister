<?php

namespace App\Http\Controllers\Admin;

use App\Models\Checklist;

use App\Models\ChecklistGroup;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreChecklistRequest;

class ChecklistController extends Controller
{

    public function create(ChecklistGroup $checklistGroup): View
    {
        return view('admin.checklists.create', compact('checklistGroup'));
    }

    public function store(StoreChecklistRequest $request, ChecklistGroup $checklistGroup): RedirectResponse
    {
        $checklistGroup->checklists()->create($request->validated());

        return redirect()->route('welcome');
    }

    public function edit(ChecklistGroup $checklistGroup, Checklist $checklist): View
    {

        return view('admin.checklists.edit', compact('checklistGroup', 'checklist'));

    }

    public function update(StoreChecklistRequest $request, ChecklistGroup $checklistGroup, Checklist $checklist): RedirectResponse
    {
        $checklist->update($request->validated());

        return redirect()->route('welcome');
    }

    public function destroy(ChecklistGroup $checklistGroup, Checklist $checklist): RedirectResponse
    {
        $checklist->delete();

        return redirect()->route('welcome');

    }
}

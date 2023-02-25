<?php

namespace App\Http\Controllers\Admin;

use App\Models\ChecklistGroup;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreChecklistGroupRequest;
use App\Http\Requests\UpdateRequestChecklistGroup;

class ChecklistGroupController extends Controller
{

    public function create(): View
    {

        return view('admin.checklist_group.create');
    }

    public function store(StoreChecklistGroupRequest $request): RedirectResponse
    {

        ChecklistGroup::create($request->validated());

        return redirect()->route('welcome');
    }

    public function edit(ChecklistGroup $checklistGroup): View
    {
        return view('admin.checklist_group.edit', compact('checklistGroup'));
    }

    public function update(UpdateRequestChecklistGroup $request, ChecklistGroup $checklistGroup): RedirectResponse
    {
        $checklistGroup->update($request->validated());

        return redirect()->route('welcome');
    }

    public function destroy(ChecklistGroup $checklistGroup): RedirectResponse
    {
        $checklistGroup->delete();

        return redirect()->route('welcome');
    }
}

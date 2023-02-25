<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Http\Livewire\ChecklistShow;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserChecklistTest extends TestCase
{

    use RefreshDatabase;

    public $user;

    public function setUp():void
    {

        parent::setUp();

        $this->actingAs(User::factory()->create());

    }

    public function test_can_load_checklist_page():void
    {

        $checklist_group = ChecklistGroup::factory()->create();

        $checklist = Checklist::factory()->create(['checklist_group_id' => $checklist_group->id]);

        Task::factory()->create(['checklist_id' => $checklist->id, 'position' => 1]);

        $response = $this->get('checklists/' . $checklist->id);

        $response->assertStatus(200);

        /* Test checklist is "cloned" to user's checklists */

        $user_checklist = Checklist::where('checklist_id', $checklist->id)->where('user_id', auth()->user()->id)->first();

        $this->assertNotNull($user_checklist);

        Livewire::test(ChecklistShow::class, ['checklist' => $checklist])->assertCount('checklist.tasks', 1);

    }

    public function test_can_complete_task():void
    {

        $checklist_group = ChecklistGroup::factory()->create();

        $checklist = Checklist::factory()->create(['checklist_group_id' => $checklist_group->id]);

        $task = Task::factory()->create(['checklist_id' => $checklist->id, 'position' => 1]);

        Livewire::test(ChecklistShow::class, ['checklist' => $checklist])->call('complete_task', $task->id);

        $user_task = Task::where('task_id', $task->id)->where('user_id', auth()->user()->id)->whereNotNull('completed_at');

        $this->assertNotNull($user_task);

    }
}

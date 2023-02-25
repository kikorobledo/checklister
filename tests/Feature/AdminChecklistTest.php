<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Checklist;
use App\Services\MenuService;
use App\Models\ChecklistGroup;
use App\Http\Livewire\TaskTable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminChecklistTest extends TestCase
{

    use RefreshDatabase;

    public function setUp():void
    {

        parent::setUp();

        $admin = User::factory()->create(['is_admin' => 1]);

        $this->actingAs($admin);

    }

    public function test_manage_checklist_groups():void
    {

        $response = $this->post('admin/checklist_groups', ['name' => 'First Group']);

        $response->assertRedirect('welcome');

        $group = ChecklistGroup::where('name', 'First Group')->first();

        $this->assertNotNull($group);

        $response = $this->get('admin/checklist_groups/' . $group->id  . '/edit');

        $response->assertStatus(200);

        $response = $this->put('admin/checklist_groups/' . $group->id, ['name' => 'The first Group']);

        $response->assertRedirect('welcome');

        $group = ChecklistGroup::where('name', 'The first Group')->first();

        $this->assertNotNull($group);

        $menu = (new MenuService())->get_menu();

        $this->assertEquals($menu['admin_menu']->where('name', 'The first Group')->count(), 1);

    }

    public function test_manage_checklists():void
    {

        $checklist_group = ChecklistGroup::factory()->create();

        $checklist_url = 'admin/checklist_groups/' . $checklist_group->id . '/checklists';

        /* Test creating the checklists */

        $response = $this->post($checklist_url, ['name' => 'First Checklist']);

        $response->assertRedirect('welcome');

        $checklist = Checklist::where('name', 'First Checklist')->first();

        $this->assertNotNull($checklist);

        /* Test editing the checklist */

        $response = $this->get($checklist_url . '/' . $checklist->id . '/edit');

        $response->assertStatus(200);

        $response = $this->put($checklist_url . '/' . $checklist->id, ['name' => 'Updated Checklist']);

        $response->assertRedirect('welcome');

        $checlist = Checklist::where('name', 'Updated Checklist')->first();

        $this->assertNotNull($checlist);

        $menu = (new MenuService())->get_menu();

        $this->assertTrue($menu['admin_menu']->first()->checklists->contains($checklist));

        /* Test deleting checklist */

        $response = $this->delete($checklist_url . '/' . $checklist->id);

        $response->assertRedirect('welcome');

        $deleted_checklist = Checklist::where('name', 'Updated Checklist')->first();

        $this->assertNull($deleted_checklist);

        $menu = (new MenuService())->get_menu();

        $this->assertFalse($menu['admin_menu']->first()->checklists->contains($checklist));

    }

    public function test_manage_tasks():void
    {

        $checklist_group = ChecklistGroup::factory()->create();

        $checklist = Checklist::factory()->create(['checklist_group_id' => $checklist_group->id]);

        $task_url = 'admin/checklists/' . $checklist->id . '/tasks';

        /* Test creating the task */

        $response = $this->post($task_url, ['name' => 'Some Task', 'description' => 'Some Description']);

        $response->assertRedirect('admin/checklist_groups/' . $checklist_group->id . '/checklists/'. $checklist->id . '/edit');

        $task = Task::where('name', 'Some Task')->first();

        $this->assertNotNull($task);

        $this->assertEquals(1, $task->position);

        /* Test updating the task */

        $response = $this->put($task_url . '/' . $task->id, ['name' => 'Updated task', 'description' => $task->description]);

        $response->assertRedirect('admin/checklist_groups/' . $checklist_group->id . '/checklists/'. $checklist->id . '/edit');

        $task = Task::where('name', 'Updated task')->first();

        $this->assertNotNull($task);

    }

    public function test_task_with_position_reordered():void
    {

        $checklist_group = ChecklistGroup::factory()->create();

        $checklist = Checklist::factory()->create(['checklist_group_id' => $checklist_group->id]);

        $task1 = Task::factory()->create(['checklist_id' => $checklist->id, 'position' => 1]);

        $task2 = Task::factory()->create(['checklist_id' => $checklist->id, 'position' => 2]);

        $task_url = 'admin/checklists/' . $checklist->id . '/tasks';

        $response = $this->delete($task_url . '/' . $task1->id);

        $response->assertRedirect('admin/checklist_groups/' . $checklist_group->id . '/checklists/' . $checklist->id . '/edit');

        $task = Task::where('name', $task1->name)->first();

        $this->assertNull($task);

        $task = Task::where('name', $task2->name)->first();

        $this->assertNotNull($task);

        $this->assertEquals(1, $task->position);

    }

    public function test_reordering_task_with_livewire():void
    {

        $checklist_group = ChecklistGroup::factory()->create();

        $checklist = Checklist::factory()->create(['checklist_group_id' => $checklist_group->id]);

        $task1 = Task::factory()->create(['checklist_id' => $checklist->id, 'position' => 1]);

        $task2 = Task::factory()->create(['checklist_id' => $checklist->id, 'position' => 2]);

        Livewire::test(TaskTable::class, ['checklist' => $checklist])->call('task_up', $task2->id);

        $task = Task::find($task2->id);

        $this->assertEquals(1, $task->position);

        Livewire::test(TaskTable::class, ['checklist' => $checklist])->call('task_down', $task2->id);

        $task = Task::find($task2->id);

        $this->assertEquals(2, $task->position);

    }

}

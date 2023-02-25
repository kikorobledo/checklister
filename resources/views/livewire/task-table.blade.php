<table class="table table-responsive-sm">

    <tbody>

        @foreach ($tasks as $task)

            <tr >

                <td>

                    @if ($task->position > 1)
                        <a href="#*" wire:click.prevent="task_up({{ $task->id }})">&uarr;</a>
                    @endif

                    @if($task->position < $tasks->max('position'))
                        <a href="#*" wire:click.prevent="task_down({{ $task->id }})">&darr;</a>
                    @endif

                </td>
                <td>{{ $task->name }}</td>
                <td>

                    <a class="btn btn-sm btn-info  mb-2 ml-3 " href="{{ route('admin.checklists.tasks.edit', [$checklist, $task]) }}">{{__('Edit')}}</a>

                    <form action="{{ route('admin.checklists.tasks.destroy', [$checklist, $task]) }}" method="POST" style="display: inline-block">
                        @csrf
                        @method('DELETE')

                        <button onclick="return confirm('{{ __('Are you sure?') }}')" type="submit" class="btn btn-sm btn-danger  mb-2 ml-3 ">{{ __('Delete') }}</button>

                    </form>

                </td>

            </tr>

        @endforeach

    </tbody>

</table>

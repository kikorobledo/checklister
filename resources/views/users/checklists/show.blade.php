@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="fade-in">

            @livewire('header-totals-count', ['checklist_group_id' => $checklist->checklist_group_id])

            @livewire('checklist-show', ['checklist' => $checklist])

        </div>

    </div>

@endsection

{{-- @section('scripts')

    <script>

        $(function (){

            $('.task-description-toggle').click(function(){

                $('#task-description-' + $(this).data('id')).toggleClass('d-none');

                $('#task-caret-top-' + $(this).data('id')).toggleClass('d-none');

                $('#task-caret-bottom-' + $(this).data('id')).toggleClass('d-none');

            });

        });

    </script>

@endsection --}}

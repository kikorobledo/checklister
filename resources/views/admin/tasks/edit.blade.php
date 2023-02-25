@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="fade-in">

            <div class="row">

                <div class="col-md-12">

                    <div class="card">

                        @if($errors->storetask->any())

                            <div class="alert alert-danger">

                                <ul>

                                    @foreach ($errors->storetask->all() as $error)

                                        <li>{{ $error }}</li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif

                        <form action="{{ route('admin.checklists.tasks.update', [$checklist, $task]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-header">{{ __('Edit task') }}</div>

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-sm-12">

                                        <div class="form-group">

                                            <label for="name">{{ __('Name') }}</label>

                                            <input type="text" id="name" name="name" value="{{ $task->name }}" class="form-control">

                                        </div>

                                        <div class="form-group">

                                            <label for="name">{{ __('Description') }}</label>

                                            <div>

                                                <textarea name="description" id="task-textarea" rows="3" class="form-control">{!! $task->description !!}</textarea>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="card-footer">

                                <button class="btn btn-sm btn-primary" type="submit">{{ __('Save') }}</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('scripts')

    @include('admin.ckeditor')

@endsection


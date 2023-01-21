@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="fade-in">

            <div class="row">

                <div class="col-md-12">

                    <div class="card">

                        @if($errors->any())

                            <div class="alert alert-danger">

                                <ul>

                                    @foreach ($errors->all() as $error)

                                        <li>{{ $error }}</li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif

                        <form action="{{ route('admin.checklist_groups.update', $checklistGroup) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-header">{{ __('Edit checklist group') }}</div>

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-sm-12">

                                        <div class="form-group">

                                            <label for="name">{{ __('Name') }}</label>

                                            <input type="text" id="name" name="name" class="form-control" value="{{ $checklistGroup->name }}">

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="card-footer">

                                <button class="btn btn-sm btn-primary" type="submit">{{ __('Save') }}</button>

                            </div>

                        </form>

                        <form action="{{ route('admin.checklist_groups.destroy', $checklistGroup) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('{{ __('Are you sure?') }}')" type="submit" class="btn btn-sm btn-danger  mb-2 ml-3 ">{{ __('Delete this checklist group') }}</button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

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

                        @if(session('message'))

                            <div class="alert alert-success">

                                {{ session('message') }}

                            </div>

                        @endif

                        <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-header">{{ __('Edit page') }}</div>

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-sm-12">

                                        <div class="form-group">

                                            <label for="title">{{ __('title') }}</label>

                                            <input type="text" id="title" name="title" value="{{ $page->title }}" class="form-control">

                                        </div>

                                        <div class="form-group">

                                            <label for="content">{{ __('Content') }}</label>

                                            <div>

                                                <textarea name="content" id="task-textarea" rows="3" class="form-control">{{ $page->content }}</textarea>

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


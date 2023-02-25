@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <div class="fade-in">

            <div class="row">

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header"><i class="fa fa-aling-justify"></i>{{ __('List of users') }}</div>

                        <div class="card-body">

                            <table class="table table-responsive-sm" >

                                <thead>

                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Website') }}</th>
                                        <th>{{ __('Register Time') }}</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($users as $user)

                                        <tr wire:sortable.item="{{ $user->id }}" wire:key="task-{{ $user->id }}">

                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->website }}</td>
                                            <td>{{ $user->created_at }}</td>

                                        </tr>

                                    @endforeach

                                </tbody>

                                <tfoot>

                                    <tr>
                                        <td>{{ $users->links() }}</td>
                                    </tr>

                                </tfoot>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

    <div class="text-center mt-2">

        <img src="{{ asset('img/logo.png') }}" />

    </div>

    <ul class="c-sidebar-nav">

        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">

            <a class="c-sidebar-nav-link" href="{{ route('home') }}">

                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-library-add') }}"></use>
                </svg>

                {{ __('Dashboard') }}

            </a>

        </li>

        @if (auth()->user()->is_admin)

            <li class="c-sidebar-nav-title">{{ __('Admin') }}</li>

            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">

                <a class="c-sidebar-nav-link"
                    href="{{ route('admin.pages.index') }}">

                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-puzzle') }}"></use>
                    </svg>

                    Pages

                </a>

            </li>

            <li class="c-sidebar-nav-title">{{ __('Manage Checklist') }}</li>

            @foreach (\App\Models\ChecklistGroup::with('checklists')->get() as $group)

                <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">

                    <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toogle"
                        href="{{ route('admin.checklist_groups.edit', $group->id) }}">

                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-puzzle') }}"></use>
                        </svg>

                        {{ $group->name }}

                    </a>

                    <ul class="c-sidebar-nav-dropdown-items">

                        @foreach ($group->checklists as $checklist)

                            <li class="c-sidebar-nav-item">

                                <a href="{{ route('admin.checklist_groups.checklists.edit', [$group, $checklist->id]) }}" class="c-sidebar-nav-link">

                                    <span class="c-sidebar-nav-icon"></span>

                                    {{ $checklist->name }}

                                </a>

                            </li>

                        @endforeach

                        <li class="c-sidebar-nav-item">

                            <a class="c-sidebar-nav-link" href="{{ route('admin.checklist_groups.checklists.create', $group) }}">{{ __('Create new checklist') }}</a>

                        </li>

                    </ul>

                </li>

            @endforeach

            <li class="c-sidebar-nav-item">

                <a class="c-sidebar-nav-link" href="{{ route('admin.checklist_groups.create') }}">{{ __('Create new checklist group') }}</a>

            </li>

        @else

        @endif

    </ul>

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized">
    </button>

</div>

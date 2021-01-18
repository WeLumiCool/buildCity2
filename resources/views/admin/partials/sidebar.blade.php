<div class="sidebar-fixed position-fixed">
    <div class="list-group list-group-flush ">


        <a href="{{ route('admin.desks.index') }}"
           class="list-group-item list-group-item-action waves-effect {{ request()->is('admin/desks*') ? 'active' : '' }}">
            <i class="fas fa-building mr-3"></i>{{ __('Столы') }}</a>

        <a href="{{ route('admin.programs.index') }}"
           class="list-group-item list-group-item-action waves-effect {{ request()->is('admin/programs*') ? 'active' : '' }}">
            <i class="fas fa-building mr-3"></i>{{ __('Программы') }}</a>


    </div>
</div>

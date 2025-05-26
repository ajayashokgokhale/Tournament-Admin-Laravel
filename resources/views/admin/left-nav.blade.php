<!-- Left Sidebar -->
<nav class="col-md-2 sidebar p-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}" href="{{ route('admin.home') }}">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.events') ? 'active' : '' }}"
               href="{{ route('admin.events') }}">Events (Tournament)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.franchises') ? 'active' : '' }}"
               href="{{ route('admin.franchises') }}">Franchises (Teams)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.players') ? 'active' : '' }}"
               href="{{ route('admin.players') }}">Players</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.contests') ? 'active' : '' }}"
               href="{{ route('admin.contests') }}">Contests (Matches)</a>
        </li>

    </ul>
</nav>

<div class="wn__sidebar">

    <!-- Start Single Widget -->
    <aside class="widget recent_widget">
        <ul>
            <li class="list-group-item">
                <img src="{{ asset('assets/users/nehal.png') }}" alt="{{ auth()->user()->name }}">
            </li>
            <li class="list-group-item"><a href="{{ route('frontend.dashboard') }}">My Posts</a></li>
            <li class="list-group-item"><a href="{{ route('users.post.create') }}">Create Posts</a></li>
            <li class="list-group-item"><a href="{{ route('users.comments') }}">Manage Comments</a></li>
            <li class="list-group-item"><a href="{{ route('users.edit_info') }}">Update Info</a></li>
            <li class="list-group-item"><a href="{{ route('frontend.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        </ul>
    </aside>
    <!-- End Single Widget -->
</div>

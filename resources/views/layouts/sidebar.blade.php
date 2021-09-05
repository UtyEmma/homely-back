<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="/"><img src="{{asset('/images/logo/logo.png')}}" alt="Bayof logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{$page === 'dashboard' ? 'active' : null }}">
                    <a href="/" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{$page === 'profile' ? 'active' : null }}">
                    <a href="/profile" class='sidebar-link'>
                        <i class="bi bi-person-fill"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <li class="sidebar-title">Main</li>

                <li class="sidebar-item {{$page === 'tenants' ? 'active' : null }}">
                    <a href="/tenants" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Tenants</span>
                    </a>
                </li>

                <li class="sidebar-item {{$page === 'listings' ? 'active' : null }}">
                    <a href="/listings" class='sidebar-link'>
                        <i class="bi bi-house-fill"></i>
                        <span>Listings</span>
                    </a>
                </li>

                <li class="sidebar-item {{$page === 'agents' ? 'active' : null }}">
                    <a href="/agents" class='sidebar-link'>
                        <i class="bi bi-person-square"></i>
                        <span>Agents</span>
                    </a>
                </li>

                {{-- <li class="sidebar-item {{$page === 'wishlists' ? 'active' : null }}">
                    <a href="/wishlists" class='sidebar-link'>
                        <i class="bi bi-heart-fill"></i>
                        <span>Wishlists</span>
                    </a>
                </li> --}}


                <li class="sidebar-item {{$page === 'reviews' ? 'active' : null }}">
                    <a href="/reviews" class='sidebar-link'>
                        <i class="bi bi-bookmark-star-fill"></i>
                        <span>Reviews</span>
                    </a>
                </li>

                <li class="sidebar-item {{$page === 'properties' ? 'active' : null }}">
                    <a href="/properties" class='sidebar-link'>
                        <i class="bi bi-house-door-fill"></i>
                        <span>Property Info</span>
                    </a>
                </li>

                <li class="sidebar-title">Actions</li>
                
                <li class="sidebar-item  {{$page === 'admins' ? 'active' : null }}">
                    <a href="/admins" class='sidebar-link'>
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Admins</span>
                    </a>
                </li>

                <li class="sidebar-item  {{$page === 'support' ? 'active' : null }}">
                    <a href="/support" class='sidebar-link'>
                        <i class="bi bi-headset"></i>
                        <span>Support</span>
                    </a>
                </li>

                <li class="sidebar-item ">
                    <a href="/logout" class='sidebar-link'>
                        <i class="bi bi-door-open"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
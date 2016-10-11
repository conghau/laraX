<nav class="admin-navbar" id="headerAdminBar">
    <div class="container">
        <div class="logo">
            <a class="navbar-brand" href="/{{ $adminPath }}">
                <img src="/admin/theme/images/logo.png" alt="logo" class="logo-default"/>
            </a>
        </div>
        <ul class="admin-navbar-nav">
            <li class="dropdown">
                <a href="/{{ $adminPath }}" data-target="#" class="dropdown-toggle"
                   data-toggle="dropdown">Appearance
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a target="_blank" href="/{{ $adminPath }}/menus">
                            Menus
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="/{{ $adminPath }}/settings">
                            Settings
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="/{{ $adminPath }}/settings/languages">
                            Languages
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="/{{ $adminPath }}" data-target="#" class="dropdown-toggle"
                   data-toggle="dropdown">Add new
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a target="_blank" href="/{{ $adminPath }}/pages/edit/0/{{ $currentLanguageId }}">
                            Page
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="/{{ $adminPath }}/posts/edit/0/{{ $currentLanguageId }}">
                            Post
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="/{{ $adminPath }}/categories/edit/0/{{ $currentLanguageId }}">
                            Category
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="/{{ $adminPath }}/products/edit/0/{{ $currentLanguageId }}">
                            Product
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="/{{ $adminPath }}/product-categories/edit/0/{{ $currentLanguageId }}">
                            Product category
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a target="_blank" href="/{{ $adminPath }}/users/edit/0">
                            User
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="/{{ $adminPath }}/admin-users/edit/0">
                            Admin user
                        </a>
                    </li>
                </ul>
            </li>
            @if(isset($currentFrontEditLink) && sizeof($currentFrontEditLink) > 0)
                <li>
                    <a target="_blank" href="{{ $currentFrontEditLink['link'] or '' }}" title="{{ $currentFrontEditLink['title'] or '' }}">
                        {{ $currentFrontEditLink['title'] or '' }}
                    </a>
                </li>
            @endif
        </ul>
        <ul class="admin-navbar-nav-right admin-navbar-nav">
            <li class="dropdown">
                <a href="/{{ $adminPath }}" data-target="#" class="dropdown-toggle"
                   data-toggle="dropdown">{{ $loggedInAdminUser->username }}
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a target="_blank" href="/{{ $adminPath }}/admin-users/edit/{{ $loggedInAdminUser->id }}">
                            Change your password
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="/{{ $adminPath }}/auth/logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

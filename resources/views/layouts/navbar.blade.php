<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand">
            <router-link to="/" class="d-inline-flex align-items-center">
                <img src="/global_assets/images/logo_text.svg" alt="">
            </router-link>
        </div>

        <div class="d-lg-none ms-2">
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-mobile" aria-expanded="false">
                <i class="ph-squares-four"></i>
            </button>
        </div>

        <div class="navbar-collapse order-2 order-lg-1 collapse" id="navbar-mobile" style="">
            <ul class="navbar-nav mt-2 mt-lg-0">
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link rounded">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link rounded dropdown-toggle" data-bs-toggle="dropdown">Dropdown</a>
                    <div class="dropdown-menu">
                        <a href="#" @click="logout" class="dropdown-item">Logout</a>
                        <a href="#" class="dropdown-item">Another action</a>
                        <a href="#" class="dropdown-item">Something else here</a>
                        <a href="#" class="dropdown-item">One more line</a>
                    </div>
                </li>
            </ul>
        </div>

        <ul class="nav gap-sm-2 order-1 order-lg-2 ms-auto">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded">
                    <i class="ph-bell"></i>
                    <span class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">2</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded">
                    <i class="ph-chats"></i>
                </a>
            </li>
            <li class="nav-item nav-item-dropdown-lg dropdown">
                <a href="#" class="navbar-nav-link align-items-center rounded p-1" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="status-indicator-container">
                        <img src="/global_assets/images/demo/logos/2.svg" class="w-32px h-32px rounded" alt="">
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">Victoria</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{URL('/logout')}}" class="dropdown-item">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</div>

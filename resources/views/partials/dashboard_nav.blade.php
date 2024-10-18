    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <div class="d-flex justify-content-end align-items-center ms-auto">
                <button id="sidebarToggle" class="btn btn-secondary me-2" style="padding: 0;">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="h3 text-dark mb-0 me-3" style="padding-left: 10px;">Dashboard Overview</h1>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="adminDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>
                <div class="dropdown-menu" aria-labelledby="adminDropdown">
                    <a class="dropdown-item" href="#">Edit Profile</a>
                    <a class="dropdown-item" href="#">Logout</a>
                </div>
            </div>
        </div>
    </nav>

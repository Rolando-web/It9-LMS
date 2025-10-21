 <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center p-4 header-border">
                <div class="d-flex align-items-center">
                    <button class="btn btn-sm text-light d-md-none me-3" id="openSidebar">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    {{$slot}}
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="d-none d-sm-block text-end me-3">
                            <div class="text-light">
                               <h2>Rolando Luayon</h2>
                            </div>
                            <small class="text-white opacity-50">Admin</small>
                        </div>
                        <!-- Mobile Dropdown -->
                        <div class="dropdown d-sm-none">
                            <a
                                href="#"
                                class="d-flex align-items-center"
                                id="profileDropdown"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img
                                    src="../image/willan.jpg"
                                    alt="Profile"
                                    class="rounded-circle"
                                    width="40"
                                    height="40" />
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><span class="dropdown-item-text fw-bold">
                                         <h2>Rolando Luayon</h2>
                                    </span></li>
                                <li><span class="dropdown-item-text text-muted">Admin</span></li>
                            </ul>
                        </div>
                        <img
                            src="../image/willan.jpg"
                            alt="Profile"
                            class="rounded-circle d-none d-sm-block"
                            width="40"
                            height="40" />
                    </div>
                </div>
            </div>
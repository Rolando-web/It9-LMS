        <!-- Mobile Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-light p-0" id="sidebar">
          <div class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h4 class="mb-0 fw-bold text-light text-2xl">
                ADMIN<span class="font-light">CONTROL</span>
              </h4>
              <button class="btn btn-sm d-md-none text-light" id="closeSidebar">
                <i class="bi bi-x-lg"></i>
              </button>
            </div>

            <nav class="nav flex flex-col gap-1">
              <!-- Dashboard -->
              <a class="{{ request()->is('dashboard') ? 'bg-white/10 shadow-sm rounded-lg':'text-white' }} nav-link flex items-center p-3 text-white transition-all duration-300
                        hover:bg-white/10 hover:pl-4 hover:-translate-x-0.5 hover:shadow-sm rounded-lg"
                href="{{route('dashboard')}}">
                <i class="bi bi-speedometer2 mr-2 transition-transform duration-300 hover:scale-110"></i>
                Dashboard
              </a>
              
              <a class="{{ request()->is('categories') ? 'bg-white/10 shadow-sm rounded-lg':'text-white' }} nav-link flex items-center p-3 text-white transition-all duration-300
                        hover:bg-white/10 hover:pl-4 hover:-translate-x-0.5 hover:shadow-sm rounded-lg"
                href="{{route('categories')}}">
                <i class="bi bi-collection mr-2 transition-transform duration-300 hover:scale-110"></i>
                Category
              </a>

              <a class=" {{ request()->is('books') ? 'bg-white/10 shadow-sm rounded-lg':'text-white' }}  nav-link flex items-center p-3 text-white transition-all duration-300
                        hover:bg-white/10 hover:pl-4 hover:-translate-x-0.5 hover:shadow-sm rounded-lg"
                href="{{route('books')}}">
                <i class="bi bi-book mr-2 transition-transform duration-300 hover:scale-110"></i>
                Books
              </a>

              <a href="/transaction" class="{{ request()->is('transaction') ? 'bg-white/10 shadow-sm rounded-lg':'text-white' }} nav-link flex items-center p-3 text-white transition-all duration-300
                        hover:bg-white/10 hover:pl-4 hover:-translate-x-0.5 hover:shadow-sm rounded-lg">
                <i class="bi bi-cash-coin mr-2 transition-transform duration-300 hover:scale-110"></i>
                Transaction
              </a>

              <a class="{{ request()->is('activity-log') ? 'bg-white/10 shadow-sm rounded-lg':'text-white' }} nav-link flex items-center p-3 text-white transition-all duration-300
                        hover:bg-white/10 hover:pl-4 hover:-translate-x-0.5 hover:shadow-sm rounded-lg"
                href="{{ route('activity-log') }}">
                <i class="bi bi-journal-text mr-2 transition-transform duration-300 hover:scale-110"></i>
                Activity Log
              </a>

              <!-- Users - Only visible to Super Admin -->
              @auth
                @if(auth()->user()->role === 'super_admin')
                  <a class="{{ request()->is('user-admin') ? 'bg-white/10 shadow-sm rounded-lg':'text-white' }} nav-link flex items-center p-3 text-white transition-all duration-300
                            hover:bg-white/10 hover:pl-4 hover:-translate-x-0.5 hover:shadow-sm rounded-lg"
                    href="{{ route('user-admin') }}">
                    <i class="bi bi-people mr-2 transition-transform duration-300 hover:scale-110"></i>
                    Users
                  </a>
                @endif
              @endauth

            </nav>
          </div>

          <div class="position-absolute bottom-0 p-4 w-100">
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
              @csrf
              <button type="submit" class="nav-link flex items-center p-3 text-white transition-all duration-300 hover:text-red-500 bg-transparent border-0 w-100 text-start">
                <i class="bi bi-box-arrow-right me-2"></i>
                Logout
              </button>
            </form>
          </div>
        </div>


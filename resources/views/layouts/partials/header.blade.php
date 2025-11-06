
<header class="relative z-10 px-4 py-4 bg-[#101929]">
<nav class="flex items-center md:justify-between mx-auto">

        <div class="text-xl font-bold flex-1 lg:text-center">
          <span class="text-white">HOME</span><span class="text-gray-300">LIBRARY</span>
        </div>


        <button id="mobileMenuBtn" class="md:hidden text-white hover:text-gray-300 transition-colors mx-2">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>

       {{-- Navigation Links  --}}
        <div class="hidden md:flex items-start space-x-5 sm:flex-1 justify-center">
          <a href="{{route('home')}}" class="flex items-center space-x-1 text-white hover:text-gray-300 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10" />
            </svg>
            <span>Home</span>
          </a>
          <a href="{{route('book')}}" class="flex items-center space-x-1 text-gray-300 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 6v12a1 1 0 001 1h6a1 1 0 011 1V6a1 1 0 00-1-1H4a1 1 0 00-1 1zm18-1h-6a1 1 0 00-1 1v14a1 1 0 011-1h6a1 1 0 001-1V6a1 1 0 00-1-1z" />
            </svg>
            <span>Books</span>
          </a>
          <a href="{{route('collection')}}" class="flex items-center space-x-1 text-gray-300 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 19V5a1 1 0 011-1h2a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1zm6 0V5a1 1 0 011-1h2a1 1 0 011 1v14a1 1 0 01-1 1h-2a1 1 0 01-1-1zm6 0V5a1 1 0 011-1h2a1 1 0 011 1v14a1 1 0 01-1 1h-2a1 1 0 01-1-1z" />
            </svg>
            <span>Collection</span>
          </a>
          <a href="{{route('user-transaction')}}" class="flex items-center space-x-1 text-gray-300 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 21">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l3 3 5-5m0 6l6-6L21 13" />
              <text x="10" y="15" font-size="12" font-family="sans-serif">$</text>
            </svg>
            <span>Transaction</span>
          </a>
        </div>

        @php $user = auth()->user(); @endphp
        <div class="hidden md:flex items-center flex-1 md:justify-end lg:justify-center text-white">
          <div class="relative flex items-center space-x-2">
            
            <!-- Notification Icon -->
            <div class="relative mr-4">
              <button id="notificationBtn" class="text-white hover:text-gray-300 transition-colors-p-2 rounded-full hover:bg-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span id="notificationBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
              </button>

              <!-- Notification Dropdown -->
              <div id="notificationDropdown" class="absolute right-0 mt-2 w-80 bg-gray-800 rounded-lg shadow-xl hidden" style="top: 100%;">
                <div class="p-4 border-b border-gray-700">
                  <h3 class="text-lg font-semibold text-white">Notifications</h3>
                </div>
                <div id="notificationList" class="max-h-96 overflow-y-auto">
                  <!-- Notifications will be loaded here -->
                </div>
              </div>
            </div>
            
            <div class="text-right">
              <div class="text-sm font-medium hidden lg:block">
                <p>{{ $user ? ($user->firstName . ' ' . ($user->lastName ?? '')) : 'Guest' }}</p>
              </div>

              <div class="text-xs text-gray-400 hidden lg:block">{{ $user ? ucfirst($user->role) : 'Visitor' }}</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 flex items-center ">
              <img src="{{ $user && $user->image ? asset($user->image) : asset('image/willan.jpg') }}" alt="profile" class="w-full h-full object-cover rounded-full">
            </div>

            <button id="dropdownButton" class="ml-2 p-1 rounded-full hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-white">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>

            <div id="dropdownMenu" class="absolute w-20 lg:w-40 rounded-lg shadow-lg bg-gray-800 ring-1 ring-opacity-5 hidden" style="margin-top: 90px;">
              <div role="menu" aria-orientation="vertical" aria-labelledby="dropdownButton">
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-start block px-4 w-20 lg:w-40 py-2 rounded-lg text-sm text-white hover:bg-gray-700">
                      Logout
                    </button>
                  </form>
              </div>
            </div>
          </div>

        </div>

        <div class="md:hidden flex items-center">
          <div class="w-8 h-8 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 flex items-center justify-center">
            <img src="../image/willan.jpg" alt="profile" class="w-full h-full object-cover rounded-full">
          </div>
        </div>
      </nav>

      <div id="mobileMenu" class="fixed inset-0 bg-red bg-opacity-50 z-50 hidden">
        <div class="fixed top-0 right-0 h-full w-80 bg-gray-900 shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out" id="mobileMenuPanel">
          <div class="flex items-center justify-between p-6 border-b border-gray-800">
            <div class="text-lg font-bold">
              <span class="text-white">HOME</span><span class="text-gray-300">LIBRARY</span>
            </div>
            <button id="closeMobileMenu" class="text-white hover:text-gray-300 transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <div class="p-6">
            <div class="flex items-center space-x-3 mb-4 pb-6 border-b border-gray-800">
              <div class="w-12 h-12 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 flex items-center justify-center">
                <img src="{{ $user && $user->image ? asset($user->image) : asset('image/willan.jpg') }}" alt="profile" class="w-full h-full object-cover rounded-full">
              </div>
              <div>
                <div class="text-white font-medium">
                  <p>{{ $user ? ($user->firstName . ' ' . ($user->lastName ?? '')) : 'Guest' }}</p>
                </div>
                <div class="text-gray-400 text-sm">{{ $user ? ucfirst($user->role) : 'Visitor' }}</div>
              </div>
            </div>
            <div class="p-4">
              <form method="POST" action="{{ route('logout') }}" class="text-decoration-none">
                @csrf
                <button type="submit" class="btn text-light d-flex align-items-center" style="font-size: 16px;">
                  <i class="bi bi-box-arrow-right me-2"></i>
                  Log Out
                </button>
              </form>
            </div>

            <nav class="space-y-">
              <a href="#" class="flex items-center space-x-3 text-white hover:text-gray-300 transition-colors py-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10" />
              </svg>
                <span class="text-lg">Home</span>
              </a>
              <a href="#" class="flex items-center space-x-3 text-gray-300 hover:text-white transition-colors py-3">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 6v12a1 1 0 001 1h6a1 1 0 011 1V6a1 1 0 00-1-1H4a1 1 0 00-1 1zm18-1h-6a1 1 0 00-1 1v14a1 1 0 011-1h6a1 1 0 001-1V6a1 1 0 00-1-1z" />
            </svg>
                <span class="text-lg">Books</span>
              </a>
              <a href="#" class="flex items-center space-x-3 text-gray-300 hover:text-white transition-colors py-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 19V5a1 1 0 011-1h2a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1zm6 0V5a1 1 0 011-1h2a1 1 0 011 1v14a1 1 0 01-1 1h-2a1 1 0 01-1-1zm6 0V5a1 1 0 011-1h2a1 1 0 011 1v14a1 1 0 01-1 1h-2a1 1 0 01-1-1z" />
            </svg>
                <span class="text-lg">Collection</span>
              </a>
              <a href="#" class="flex items-center space-x-3 text-gray-300 hover:text-white transition-colors py-3">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 21">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l3 3 5-5m0 6l6-6L21 13" />
              <text x="10" y="15" font-size="12" font-family="sans-serif">$</text>
            </svg>
                <span class="text-lg">Transaction</span>
              </a>
            </nav>
          </div>
        </div>
      </div>
  </header>
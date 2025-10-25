<x-import>
  <title>Categories - Book Management System</title>
</x-import>

  <div class="d-flex min-vh-100 bg-[#1a1b1e]">
    
    @include('components.sidebar')
    <x-header>
      <h1 class="text-light mb-0 text-3xl flex items-center gap-2">
        <i class="bi bi-tags-fill text-emerald-500"></i>
        Book Categories
      </h1>
    </x-header>

      <!-- Categories Section -->
      <div class="p-6 w-100">
        <!-- Header with count -->
        <div class="mb-6">
          <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg px-6 py-4 flex items-center justify-between">
            <div>
              <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                <i class="bi bi-collection text-emerald-500"></i>
                Browse Categories
              </h2>
              <p class="text-gray-400 text-sm mt-1">Explore books by category</p>
            </div>
            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
              <i class="bi bi-grid-3x3-gap-fill me-2"></i>8 Categories
            </span>
          </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <!-- Arts Category -->
          <a href="{{ route('books') }}" class="group relative overflow-hidden cursor-pointer rounded-xl border border-[#373a40] bg-[#2c2e33] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:border-purple-500/50">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/arts.jpg')}}" 
                   alt="Arts & Culture"
                   class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110 brightness-75 group-hover:brightness-90">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
              <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-palette-fill text-purple-500 text-xl"></i>
                <h3 class="text-2xl font-bold text-white">Arts & Culture</h3>
              </div>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </a>

          <!-- Biology Category -->
          <a href="{{ route('books') }}" class="group relative overflow-hidden cursor-pointer rounded-xl border border-[#373a40] bg-[#2c2e33] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:border-green-500/50">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/biology.jpg')}}" 
                   alt="Biology"
                   class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110 brightness-75 group-hover:brightness-90">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
              <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-flower1 text-green-500 text-xl"></i>
                <h3 class="text-2xl font-bold text-white">Biology</h3>
              </div>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </a>

          <!-- Business Category -->
          <a href="{{ route('books') }}" class="group relative overflow-hidden cursor-pointer rounded-xl border border-[#373a40] bg-[#2c2e33] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:border-blue-500/50">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/business.jpg')}}" 
                   alt="Business"
                   class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110 brightness-75 group-hover:brightness-90">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
              <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-briefcase-fill text-blue-500 text-xl"></i>
                <h3 class="text-2xl font-bold text-white">Business</h3>
              </div>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </a>

          <!-- Fiction Category -->
          <a href="{{ route('books') }}" class="group relative overflow-hidden cursor-pointer rounded-xl border border-[#373a40] bg-[#2c2e33] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:border-pink-500/50">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/fiction.jpg')}}" 
                   alt="Fiction"
                   class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110 brightness-75 group-hover:brightness-90">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
              <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-stars text-pink-500 text-xl"></i>
                <h3 class="text-2xl font-bold text-white">Fiction</h3>
              </div>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </a>

          <!-- History Category -->
          <a href="{{ route('books') }}" class="group relative overflow-hidden cursor-pointer rounded-xl border border-[#373a40] bg-[#2c2e33] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:border-amber-500/50">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/history.jpg')}}" 
                   alt="History"
                   class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110 brightness-75 group-hover:brightness-90">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
              <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-clock-history text-amber-500 text-xl"></i>
                <h3 class="text-2xl font-bold text-white">History</h3>
              </div>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </a>

          <!-- Technology Category -->
          <a href="{{ route('books') }}" class="group relative overflow-hidden cursor-pointer rounded-xl border border-[#373a40] bg-[#2c2e33] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:border-cyan-500/50">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/technology.jpg')}}" 
                   alt="Technology"
                   class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110 brightness-75 group-hover:brightness-90">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
              <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-cpu-fill text-cyan-500 text-xl"></i>
                <h3 class="text-2xl font-bold text-white">Technology</h3>
              </div>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </a>

          <!-- Philosophy Category -->
          <a href="{{ route('books') }}" class="group relative overflow-hidden cursor-pointer rounded-xl border border-[#373a40] bg-[#2c2e33] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:border-indigo-500/50">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/philosophy.jpg')}}" 
                   alt="Philosophy"
                   class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110 brightness-75 group-hover:brightness-90">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
              <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-lightbulb-fill text-indigo-500 text-xl"></i>
                <h3 class="text-2xl font-bold text-white">Philosophy</h3>
              </div>
              <p class="text-sm text-gray-300">3 books</p>
            </div>
          </a>

          <!-- Science Category -->
          <a href="{{ route('books') }}" class="group relative overflow-hidden cursor-pointer rounded-xl border border-[#373a40] bg-[#2c2e33] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:border-emerald-500/50">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/science.jpg')}}" 
                   alt="Science"
                   class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110 brightness-75 group-hover:brightness-90">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
              <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-rocket-takeoff-fill text-emerald-500 text-xl"></i>
                <h3 class="text-2xl font-bold text-white">Science</h3>
              </div>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </a>
        </div>
      </div>
  </div>
  </div>

<x-import-footer/>
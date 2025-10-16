
<main class="relative z-0 flex-1 flex items-center justify-center">
  <div class="absolute inset-0 z-0 opacity-50" style="background-image: url({{ asset('image/wew.png') }}); background-size: cover; background-position: center;"></div>

  <div class="relative z-10 text-center max-w-3xl mx-auto mt-16 mb-29">
    <h1 class="text-5xl md:text-7xl lg:text-8xl font-light mb-6 leading-tight">
      <div class="text-gray-300 mb-2">Welcome to</div>
      <div class="font-normal">
        <span class="text-white">Home</span><span class="text-gray-300">Library</span>
      </div>
    </h1>

    <p class="text-gray-300 text-sm md:text-xl mb-8 max-w-2xl mx-auto leading-relaxed">
      Discover thousands of books, explore new genres, and embark on endless literary adventures. Your next great read awaits.
    </p>

    <a href="{{ route('collection') }}">
      <button class="bg-white text-gray-900 px-8 py-3 rounded-lg font-medium hover:bg-black hover:text-white hover:shadow-white hover:shadow-2xl transition-colors inline-flex items-center space-x-2 group cursor-pointer">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
        <span>Book Collection</span>
        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
        </svg>
      </button>
    </a>
  </div>
</main>

    <div class="relative z-0 px-6 py-12 bg-[#0C121F]">
      <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-teal-600 bg-opacity-20 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
              </svg>
            </div>
            <div class="text-4xl font-light text-white mb-2">
              <h1>2</h1>
            </div>
            <div class="text-gray-400">Books Available</div>
          </div>

          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-blue-600 bg-opacity-20 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </div>
            <div class="text-4xl font-light text-white mb-2">
             <h1>2</h1>
            </div>
            <div class="text-gray-400">Active Members</div>
          </div>

          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-amber-600 bg-opacity-20 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 2l7 4v5c0 5.25-3.5 9.75-7 11-3.5-1.25-7-5.75-7-11V6l7-4z" />
              </svg>
            </div>
            <div class="text-4xl font-light text-white mb-2">
              <h1>2</h1></div>
            <div class="text-gray-400">Admin Available</div>
          </div>
        </div>
      </div>
    </div>
  </div>
<x-import>
  <title>Categories - Book Management System</title>
</x-import>

  <div class="d-flex min-vh-100 bg-[#1a1b1e]">
    
    @include('components.sidebar')
    <x-header>
      <h1 class="text-light mb-0 text-2xl flex items-center gap-2 md:text-3xl">
        Book Categories
      </h1>
    </x-header>

      <!-- Categories Section -->
      <div class="p-6 w-100">
        <!-- Header with count -->
        <div class="mb-6">
          <div class="bg-[#2c2e33] rounded-lg px-6 py-4 flex items-center justify-between">
            <div>
              <h2 class="text-xl font-semibold text-white flex items-center gap-2 md:text-2xl">
                <i class="bi bi-collection text-emerald-500"></i>
                Browse Categories
              </h2>
              <p class="text-gray-400 text-sm mt-1">Explore books by category</p>
            </div>
            <span class="inline-flex items-center p-1 md:px-4 py-2 rounded-lg text-sm font-semibold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
              <i class="bi bi-grid-3x3-gap-fill me-2"></i>{{ $totalCategories }} Categories
            </span>
          </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          @foreach($categories as $category)
          <a href="{{ route('books', ['category' => $category['key']]) }}" class="group relative overflow-hidden cursor-pointer rounded-xl bg-[#2c2e33] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:border-{{ $category['color'] }}-500/50">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{ asset('category/' . $category['image']) }}" 
                   alt="{{ $category['name'] }}"
                   class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110 brightness-75 group-hover:brightness-90">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
              <div class="flex items-center gap-2 mb-2">
                <i class="bi {{ $category['icon'] }} text-{{ $category['color'] }}-500 text-xl"></i>
                <h3 class="text-2xl font-bold text-white">{{ $category['name'] }}</h3>
              </div>
              <p class="text-sm text-gray-300">{{ $category['count'] }} {{ Str::plural('book', $category['count']) }}</p>
            </div>
          </a>
          @endforeach
        </div>
      </div>
  </div>
  </div>

<x-import-footer/>
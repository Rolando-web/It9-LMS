@php
$categoryList = [
    'Fiction' => ['description' => 'Novels, short stories, and imaginative literature', 'color' => 'indigo'],
    'Technology' => ['description' => 'Computers, programming, and digital innovation', 'color' => 'blue'],
    'History' => ['description' => 'Historical events, biographies, and civilizations', 'color' => 'emerald'],
    'Business' => ['description' => 'Entrepreneurship, management, and economics', 'color' => 'amber'],
    'Philosophy' => ['description' => 'Ideas, thinking, and existential questions', 'color' => 'purple'],
    'Arts' => ['description' => 'Visual arts, music, and creative expression', 'color' => 'pink'],
    'Biology' => ['description' => 'Life sciences, organisms, and ecosystems', 'color' => 'green'],
    'Science' => ['description' => 'Physics, chemistry, and scientific discoveries', 'color' => 'cyan'],
];
@endphp

<section class="bg-gray-900 py-8 px-6 mb-10">
    <div class="max-w-7xl mx-auto">
      <!-- Section Header -->
      <div class="text-center mb-12">
        <h2 class="text-3xl font-light text-white mb-4">Explore by Category</h2>
        <p class="text-gray-400 text-lg">From fiction to science, discover books across every genre and subject</p>
      </div>

      <!-- Categories Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categoryList as $categoryName => $categoryInfo)
        @php
          $count = $categories[$categoryName] ?? 0;
          $color = $categoryInfo['color'];
          $index = $loop->iteration;
        @endphp
        <!-- {{ $categoryName }} Category -->
        <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-750 transition-colors group">
          <div class="flex items-start justify-between mb-4">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-{{ $color }}-600 bg-opacity-20 rounded-full flex items-center justify-center">
                <span class="text-{{ $color }}-400 font-semibold text-sm">{{ str_pad($index, 2, '0', STR_PAD_LEFT) }}</span>
              </div>
              <div>
                <h3 class="text-white font-medium text-lg">{{ $categoryName }}</h3>
                <p class="text-gray-400 text-sm">{{ $categoryInfo['description'] }}</p>
              </div>
            </div>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-{{ $color }}-400 font-medium">{{ $count }} {{ $count == 1 ? 'book' : 'books' }}</span>
            <a href="{{ route('collection') }}?category={{ $categoryName }}">
              <button class="text-{{ $color }}-400 hover:text-{{ $color }}-300 transition-colors inline-flex items-center space-x-1 text-sm cursor-pointer">
                <span>Explore</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
              </button>
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
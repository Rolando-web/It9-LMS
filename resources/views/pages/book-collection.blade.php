<x-page-header>
  Book Collection
</x-page-header>
 @include('layouts.partials.header')

  <main class="max-w-7xl mx-auto px-6 py-8">
    <div class="mb-8">
      <h1 class="text-4xl font-light text-white mb-2">Book Collection</h1>
      <p class="text-gray-400 text-lg">Discover and borrow from our extensive collection of books</p>
    </div>


    <div class="bg-gray-800 rounded-xl p-6 mb-8">
      <form id="filterForm" method="GET">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
          <div class="flex flex-wrap gap-2">
            <button type="button" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ (request('category') === null || request('category') === '' || request('category') === 'all') ? 'bg-gray-600 text-white' : 'bg-gray-700 text-gray-300' }}" data-category="all" onclick="submitForm('all')">
              All Books
            </button>
            <button type="button" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('category') === 'fiction' ? 'bg-gray-600 text-white' : 'bg-gray-700 text-gray-300' }} hover:bg-gray-600" data-category="fiction" onclick="submitForm('fiction')">Fiction</button>
            <button type="button" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('category') === 'technology' ? 'bg-gray-600 text-white' : 'bg-gray-700 text-gray-300' }} hover:bg-gray-600" data-category="technology" onclick="submitForm('technology')">Technology</button>
            <button type="button" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('category') === 'history' ? 'bg-gray-600 text-white' : 'bg-gray-700 text-gray-300' }} hover:bg-gray-600" data-category="history" onclick="submitForm('history')">History</button>
            <button type="button" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('category') === 'business' ? 'bg-gray-600 text-white' : 'bg-gray-700 text-gray-300' }} hover:bg-gray-600" data-category="business" onclick="submitForm('business')">Business</button>
            <button type="button" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('category') === 'philosophy' ? 'bg-gray-600 text-white' : 'bg-gray-700 text-gray-300' }} hover:bg-gray-600" data-category="philosophy" onclick="submitForm('philosophy')">Philosophy</button>
            <button type="button" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('category') === 'arts' ? 'bg-gray-600 text-white' : 'bg-gray-700 text-gray-300' }} hover:bg-gray-600" data-category="arts" onclick="submitForm('arts')">Arts</button>
            <button type="button" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('category') === 'science' ? 'bg-gray-600 text-white' : 'bg-gray-700 text-gray-300' }} hover:bg-gray-600" data-category="science" onclick="submitForm('science')">Science</button>
            <button type="button" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('category') === 'biology' ? 'bg-gray-600 text-white' : 'bg-gray-700 text-gray-300' }} hover:bg-gray-600" data-category="biology" onclick="submitForm('biology')">Biology</button>
          </div>

          <div>
            <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Search by Title ..." class="bg-gray-700 text-white mx-4 px-3 py-2 rounded-lg text-sm border border-gray-600 focus:border-gray-400 focus:outline-none">
          </div>
          <input type="hidden" name="category" id="categoryInput" value="{{ request('category') ?? '' }}">
          <div class="flex items-center space-x-4">
            <label class="text-gray-400 text-sm">Sort by:</label>
            <select name="sort" id="sortSelect" class="bg-gray-700 text-white px-3 py-2 rounded-lg text-sm border border-gray-600 focus:border-gray-400 focus:outline-none"
              onchange="submitForm()">
              <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title A-Z</option>
              <option value="year" {{ request('sort') === 'year' ? 'selected' : '' }}>Publication Year</option>
            </select>
          </div>
        </div>
      </form>
    </div>


    <div id="booksGrid" 
         class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8"
         data-current-page="{{ $books->currentPage() }}"
         data-last-page="{{ $books->lastPage() }}"
         data-per-page="{{ $books->perPage() }}">
        @foreach($books as $book)
          <div class="book-card bg-gray-800 rounded-xl p-2 hover:bg-gray-750 transition-colors group" data-book-id="{{ $book->id }}" data-title="{{ e($book->title) }}" data-author="{{ e($book->author) }}" data-image="{{ asset($book->image ?? 'image/default-book.jpg') }}">
            <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-750 transition-colors group ">
              <div class="mb-4">
                <div class="w-full h-48 bg-gradient-to-br from-slate-600 to-slate-800 rounded-lg flex items-center justify-center mb-4 relative overflow-hidden">
                  <img src="{{ asset($book->image ?? 'image/default-book.jpg') }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded-lg">
                </div>
              </div>

              <div class="space-y-2">
                <h3 class="text-white font-medium text-lg leading-tight">{{ $book->title }}</h3>
                <p class="text-gray-400 text-sm">{{ $book->author }}</p>
                <div class="flex items-center space-x-2">
                  <div class="flex items-center space-x-1">
                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-yellow-400 text-sm font-medium">4.8</span>
                    <span class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($book->publish_date)->format('Y') }}</span>
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="user_id" value="{{ auth()->id() ?? 0 }}">
            <input type="hidden" name="book_id" value="{{ $book->id }}">
            
            @php
              $isAlreadyBorrowed = in_array($book->id, $borrowedBookIds ?? []);
              $isOutOfStock = $book->copies <= 0;
            @endphp
            
            <div class="flex justify-center">
              @if($isAlreadyBorrowed)
                <button type="button" disabled class="w-full bg-gray-600 text-gray-400 py-2 px-3 rounded-lg text-sm font-medium mb-2 cursor-not-allowed">
                  Already Borrowed
                </button>
              @elseif($isOutOfStock)
                <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors mb-2">
                  Find Similar Book
                </button>
              @else
                <button type="button" class="openBorrowModal w-full bg-gray-700 hover:bg-gray-600 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors mb-2">
                  Borrow Book
                </button>
              @endif
            </div>
          </div>
        @endforeach
    </div>

    <div id="emptyState" class="{{ $books->count() ? 'hidden' : '' }} text-center py-12">
      <p class="text-gray-400">No books found for your search or filters.</p>
    </div>

    <div class="text-center">
      <button id="loadMoreBtn" class="bg-white text-gray-900 px-8 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors inline-flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        <span>Load More Books</span>
      </button>
    </div>
  </main>

  @include('components.borrow-modal')
  
  <script src="{{ asset('js/collection.js') }}"></script>
  <script src="{{ asset('js/user.js') }}"></script>
  <script src="{{ asset('js/notification.js') }}"></script>
  </body>
</html>

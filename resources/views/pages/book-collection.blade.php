<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/svg+xml" href="/vite.svg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="../image/willan.jpg" type="image/jpeg">
 @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <title>Home Library</title>
</head>
<body class="bg-gray-900 text-white font-sans w-full">

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
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-700 text-gray-300" data-category="all" onclick="submitForm('all')">
              All Books
            </button>
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-700 text-gray-300 hover:bg-gray-600 " data-category="fiction" onclick="submitForm('fiction')">Fiction</button>
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-700 text-gray-300 hover:bg-gray-600 " data-category="technology" onclick="submitForm('technology')">Technology</button>
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-700 text-gray-300 hover:bg-gray-600 " data-category="history" onclick="submitForm('history')">History</button>
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-700 text-gray-300 hover:bg-gray-600" data-category="business" onclick="submitForm('business')">Business</button>
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-700 text-gray-300 hover:bg-gray-600" data-category="philosophy" onclick="submitForm('philosophy')">Philosophy</button>
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-700 text-gray-300 hover:bg-gray-600" data-category="arts" onclick="submitForm('arts')">Arts</button>
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-700 text-gray-300 hover:bg-gray-600 " data-category="science" onclick="submitForm('science')">Science</button>
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-700 text-gray-300 hover:bg-gray-600" data-category="biology" onclick="submitForm('biology')">Biology</button>
          </div>

          <div>
            <input type="text" name="search" id="searchInput" value="" placeholder="Search by Title ..." class="bg-gray-700 text-white mx-4 px-3 py-2 rounded-lg text-sm border border-gray-600 focus:border-gray-400 focus:outline-none">
          </div>
          <input type="hidden" name="category" id="categoryInput" value="">
          <div class="flex items-center space-x-4">
            <label class="text-gray-400 text-sm">Sort by:</label>
            <select name="sort" id="sortSelect" class="bg-gray-700 text-white px-3 py-2 rounded-lg text-sm border border-gray-600 focus:border-gray-400 focus:outline-none"
              onchange="submitForm()">
              <option value="title" >Title A-Z</option>
              <option value="author">Author A-Z</option>
              <option value="year">Publication Year</option>
            </select>
          </div>
        </div>
      </form>
    </div>


    <div id="booksGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">

        <div class="bg-gray-800 rounded-xl p-2 hover:bg-gray-750 transition-colors group">
          <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-750 transition-colors group ">
            <div class="mb-4">
              <div class="w-full h-48 bg-gradient-to-br from-slate-600 to-slate-800 rounded-lg flex items-center justify-center mb-4 relative overflow-hidden">
                <img src="#" alt="image" class="w-full h-full object-cover rounded-lg">
              </div>
            </div>

            <div class="space-y-2">
              <h3 class="text-white font-medium text-lg leading-tight">11</h3>
              <p class="text-gray-400 text-sm">wew</p>
              <div class="flex items-center space-x-2">
                <div class="flex items-center space-x-1">
                  <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-yellow-400 text-sm font-medium">4.8</span>
                </div>
                <span class="text-gray-500 text-sm">wew</span>
              </div>
            </div>
          </div>
              <input type="hidden" name="user_id" value="1">
              <input type="hidden" name="book_id" value="1">
              <button type="button" class="openBorrowModal w-full bg-gray-700 hover:bg-gray-600 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors mb-4">
                Borrow Book
              </button>
            {{-- <button type="button" class="w-full bg-white hover:bg-gray-300 text-black py-2 px-3 rounded-lg text-sm font-medium transition-colors mb-4"
             >
              Find Similar
            </button> --}}
        </div>
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



   <script src="{{ asset('js/user.js') }}"></script>
  </body>
</html>

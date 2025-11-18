<x-import>
  <title>Manage Books - Book Management System</title>
</x-import>
    <div class="d-flex min-vh-100 bg-[#1a1b1e]">
    @include('components.sidebar')
    <x-header>
  <h1 class="text-light mb-0 text-3xl pl-2 flex items-center gap-2">
       <i class="bi bi-book-fill text-cyan-500"></i>Manage Books
      </h1>
    </x-header>
            <div class="p-6 w-100">
                @if(session('success'))
                    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 rounded-lg px-4 py-3 mb-4 flex items-center gap-3" role="alert">
                        <i class="bi bi-check-circle-fill text-xl"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="ml-auto text-emerald-500 hover:text-emerald-400" data-bs-dismiss="alert" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-500/10 border border-red-500/20 text-red-500 rounded-lg px-4 py-3 mb-4 flex items-center gap-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="ml-auto text-red-500 hover:text-red-400" data-bs-dismiss="alert" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/20 text-red-500 rounded-lg px-4 py-3 mb-4" role="alert">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                            <strong>Validation Errors:</strong>
                        </div>
                        <ul class="ml-7 list-disc">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-6">
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-2 rounded-lg font-semibold transition-colors shadow-lg"
                        data-bs-toggle="modal"
                        data-bs-target="#addBookModal">
                        <i class="bi bi-plus-circle text-xl"></i>
                        Add New Book
                    </button>
                </div>

                <!-- Table -->
                <div class="bg-[#2c2e33] rounded-xl shadow-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-[#373a40]">
                        <div class="flex items-center justify-between gap-4 flex-wrap">
                            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                <i class="bi bi-collection text-cyan-500"></i>
                                All Books ({{ $books->total() }})
                            </h3>
                            <!-- Category Filter -->
                            <div class="flex items-center gap-3">
                                <label for="categoryFilter" class="text-gray-400 text-sm font-medium flex items-center gap-2">
                                    <i class="bi bi-funnel"></i>
                                    Filter:
                                </label>
                                <form method="GET" action="{{ route('books') }}" class="flex items-center gap-2">
                                    <!-- Category select -->
                                    <div class="relative">
                                        <select name="category" id="categoryFilter" class="bg-[#1a1b1e] border border-opacity-50 border-[#373a40] text-white rounded-lg px-5 py-2 pr-10 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all cursor-pointer appearance-none" onchange="this.form.submit()">
                                            <option value="all" {{ (!$selectedCategory || $selectedCategory === 'all') ? 'selected' : '' }}>All Categories</option>
                                            @isset($categories)
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat }}" {{ ($selectedCategory === $cat) ? 'selected' : '' }}>{{ $cat }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                    </div>

                                    <!-- Search input -->
                                    <div class="flex items-center gap-2">
                                        <div class="relative">
                                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search by Title or ID" class="bg-[#1a1b1e] border border-[#373a40] text-white rounded-lg px-4 py-2 pr-10 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all w-64" />
                                            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-cyan-500">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                        @if(!empty($search))
                                            <a href="{{ route('books', ($selectedCategory && $selectedCategory !== 'all') ? ['category' => $selectedCategory] : []) }}" class="text-gray-400 hover:text-red-500 transition-colors" title="Clear search">
                                                <i class="bi bi-x-circle text-xl"></i>
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Clear category keeps search if present -->
                                    @if(!empty($selectedCategory) && $selectedCategory !== 'all')
                                        <a href="{{ route('books', !empty($search) ? ['search' => $search] : []) }}" class="text-gray-400 hover:text-red-500 transition-colors" title="Clear category">
                                            <i class="bi bi-x-circle text-xl"></i>
                                        </a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div id="booksListContainer">
                        @include('Admin.partials.books-table', ['books' => $books])
                    </div>
            </div>
                {{-- Modal --}}
                @include('components.book-modal')
                {{-- Modal --}}

            </div>
              </div>

  {{-- Toast Notification --}}
  <div id="adminToast" class="fixed top-6 right-6 z-50 hidden">
    <div id="adminToastInner" class="bg-green-600 text-white px-4 py-3 rounded shadow max-w-xs">
      <div id="adminToastMsg" class="font-medium">Action completed</div>
      <div id="adminToastSub" class="text-sm opacity-80"></div>
    </div>
  </div>

   {{-- Footer --}}
<x-import-footer/>

<script>
    // Toast notification function
    function showAdminToast(message, sub, isError = false) {
        const t = document.getElementById("adminToast");
        const inner = document.getElementById("adminToastInner");
        const msg = document.getElementById("adminToastMsg");
        const subEl = document.getElementById("adminToastSub");

        if (!t || !msg || !subEl || !inner) return;

        // Set colors based on success or error
        if (isError) {
            inner.className = "bg-red-600 text-white px-4 py-3 rounded-lg shadow-lg max-w-xs border border-red-500";
        } else {
            inner.className = "bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg max-w-xs border border-green-500";
        }

        msg.innerText = message;
        subEl.innerText = sub || "";
        t.classList.remove("hidden");
        t.style.opacity = "0";
        requestAnimationFrame(() => {
            t.style.transition = "opacity 200ms";
            t.style.opacity = "1";
        });
        setTimeout(() => {
            t.style.opacity = "0";
            setTimeout(() => t.classList.add("hidden"), 220);
        }, 4000);
    }

    // Show toast on page load if there's a session message
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('error'))
            showAdminToast("{{ session('error') }}", "This book cannot be deleted", true);
        @endif

        @if(session('success'))
            showAdminToast("{{ session('success') }}", "Operation completed successfully", false);
        @endif
    });
</script>
<script src="{{ asset('js/admin-books.js') }}"></script>
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
                <div class="bg-[#2c2e33] border border-[#373a40] rounded-xl shadow-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-[#373a40]">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="bi bi-collection text-cyan-500"></i>
                            All Books ({{ $books->count() }})
                        </h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-[#25262b] border-b border-[#373a40]">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Image</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Title</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400 d-none d-sm-table-cell">Author</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Category</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400 d-none d-lg-table-cell">ISBN</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400 d-none d-md-table-cell">Publish Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400 d-none d-lg-table-cell">Copies</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400 d-none d-lg-table-cell">Added By</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($books as $index => $book)
                                <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 {{ $index % 2 == 0 ? 'bg-[#2c2e33]' : 'bg-[#272931]' }}">
                                    <!-- Image Column -->
                                    <td class="px-4 py-4">
                                        @if($book->image)
                                            <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" 
                                                 class="rounded-lg w-16 h-16 object-cover border border-[#373a40]" />
                                        @else
                                            <div class="flex items-center justify-center bg-[#1a1b1e] rounded-lg w-16 h-16 border border-[#373a40]">
                                                <i class="bi bi-book text-gray-500 text-2xl"></i>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <!-- ID Column -->
                                    <td class="px-4 py-4">
                                        <span class="text-white font-semibold text-base">{{ $book->id }}</span>
                                    </td>
                                    
                                    <!-- Title Column -->
                                    <td class="px-4 py-4">
                                        <div>
                                            <div class="text-white font-semibold text-sm">{{ $book->title }}</div>
                                            <small class="text-gray-500 text-xs">{{ Str::limit($book->title, 40) }}</small>
                                        </div>
                                    </td>
                                    
                                    <!-- Author Column -->
                                    <td class="px-4 py-4 d-none d-sm-table-cell">
                                        <span class="text-gray-300 text-sm">{{ $book->author }}</span>
                                    </td>
                                    
                                    <!-- Category Column -->
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-500 border border-blue-500/20">
                                            <i class="bi bi-tag-fill me-1.5"></i>{{ $book->category }}
                                        </span>
                                    </td>
                                    
                                    <!-- ISBN Column -->
                                    <td class="px-4 py-4 d-none d-lg-table-cell">
                                        <span class="text-gray-400 text-sm font-mono">{{ $book->isbn }}</span>
                                    </td>
                                    
                                    <!-- Publish Date Column -->
                                    <td class="px-4 py-4 d-none d-md-table-cell">
                                        <span class="text-gray-300 text-sm">{{ \Carbon\Carbon::parse($book->publish_date)->format('M d, Y') }}</span>
                                    </td>
                                    
                                    <!-- Copies Column -->
                                    <td class="px-4 py-4 d-none d-lg-table-cell">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                                            <i class="bi bi-stack me-1.5"></i>{{ $book->copies }}
                                        </span>
                                    </td>

                                    <!-- Added By Column -->
                                    <td class="px-4 py-4 d-none d-lg-table-cell">
                                        @if($book->user)
                                        <div>
                                            <div class="text-white font-medium text-sm">{{ $book->user->firstName }}</div>
                                            <small class="text-gray-500 text-xs">{{ ucfirst(str_replace('_', ' ', $book->user->role)) }}</small>
                                        </div>
                                        <div class="text-gray-400 text-xs mt-1">
                                            {{ $book->created_at->format('M d, Y') }}
                                        </div>
                                        @else
                                        <span class="text-gray-500 text-xs">N/A</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Actions Column -->
                                    <td class="px-4 py-4 text-end">
                                        <div class="flex gap-2 justify-end">
                                            <button class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-cyan-500/20 text-cyan-500 hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200 editBtn" 
                                                    title="Edit Book"
                                                    data-id="{{ $book->id }}"
                                                    data-title="{{ $book->title }}"
                                                    data-author="{{ $book->author }}"
                                                    data-category="{{ $book->category }}"
                                                    data-isbn="{{ $book->isbn }}"
                                                    data-publish_date="{{ $book->publish_date }}"
                                                    data-copies="{{ $book->copies }}"
                                                    data-image="{{ $book->image ? asset($book->image) : '' }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editBookModal">
                                                <i class="bi bi-pencil-square text-base"></i>
                                            </button>
                                            <form method="POST" action="{{ route('delete-book', $book->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-red-500/20 text-red-500 hover:bg-red-500/10 hover:border-red-500/40 transition-all duration-200" 
                                                        title="Delete Book">
                                                    <i class="bi bi-trash text-base"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-12">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="bi bi-inbox text-6xl text-gray-600 mb-4"></i>
                                            <h5 class="text-white text-lg font-semibold mb-2">No Books Yet</h5>
                                            <p class="text-gray-400 mb-4">Click "Add New Book" to get started.</p>
                                            <button
                                                type="button"
                                                class="inline-flex items-center gap-2 bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-2 rounded-lg font-semibold transition-colors"
                                                data-bs-toggle="modal"
                                                data-bs-target="#addBookModal">
                                                <i class="bi bi-plus-circle"></i>
                                                Add Your First Book
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-[#373a40] bg-[#25262b] flex items-center justify-between">
                        <div class="text-sm text-gray-400">
                            Showing <span class="font-semibold text-white">1-{{ min(5, $books->count()) }}</span> of <span class="font-semibold text-white">{{ $books->count() }}</span> books
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <!-- Previous Button -->
                            <button class="px-3 py-2 rounded-lg bg-[#2c2e33] border border-[#373a40] text-gray-400 hover:border-cyan-500/50 hover:text-cyan-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            
                            <!-- Page Numbers -->
                            <button class="px-4 py-2 rounded-lg bg-cyan-500 text-white font-semibold">
                                1
                            </button>
                            @if($books->count() > 5)
                            <button class="px-4 py-2 rounded-lg bg-[#2c2e33] border border-[#373a40] text-gray-400 hover:border-cyan-500/50 hover:text-white transition-all">
                                2
                            </button>
                            @endif
                            @if($books->count() > 10)
                            <button class="px-4 py-2 rounded-lg bg-[#2c2e33] border border-[#373a40] text-gray-400 hover:border-cyan-500/50 hover:text-white transition-all">
                                3
                            </button>
                            @endif
                            
                            <!-- Next Button -->
                            <button class="px-3 py-2 rounded-lg bg-[#2c2e33] border border-[#373a40] text-gray-400 hover:border-cyan-500/50 hover:text-cyan-500 transition-all {{ $books->count() <= 5 ? 'disabled:opacity-50 disabled:cursor-not-allowed' : '' }}" {{ $books->count() <= 5 ? 'disabled' : '' }}>
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Modal --}}
                @include('components.book-modal')
                {{-- Modal --}}

            </div>
              </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/book-modal.js') }}"></script>
         <script src="{{ asset('js/admin.js') }}"></script>
        <script src="{{ asset('js/active.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>
     
</body>

</html>
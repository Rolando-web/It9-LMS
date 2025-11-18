<x-import>
  <title>Dashboard - Book Management System</title>
</x-import>


  <div class="d-flex min-vh-100 bg-[#1a1b1e]">

    @include('components.sidebar')

    <x-header>
  <h1 class="text-light mb-0 text-3xl">
       Dashboard
      </h1>
    </x-header>

        <!-- Dashboard Content -->
        <div class="px-8 py-6">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-[#2c2e33]  rounded-xl p-6 hover:shadow-xl hover:border-blue-500/50 transition-all duration-300 hover:-translate-y-1">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                  <i class="bi bi-book-fill text-blue-500 text-2xl"></i>
                </div>
                <span class="px-3 py-1 bg-green-500/10 text-green-500 text-xs font-semibold rounded-full">+12%</span>
              </div>
              <p class="text-3xl font-bold text-white mb-1">{{ $totalBooks }}</p>
              <p class="text-sm text-gray-400 font-medium">Total Books</p>
            </div>

            <!-- Categories Card -->
            <div class="bg-[#2c2e33]  rounded-xl p-6 hover:shadow-xl hover:border-emerald-500/50 transition-all duration-300 hover:-translate-y-1">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                  <i class="bi bi-tags-fill text-emerald-500 text-2xl"></i>
                </div>
                <span class="px-3 py-1 bg-green-500/10 text-green-500 text-xs font-semibold rounded-full">+8%</span>
              </div>
              <p class="text-3xl font-bold text-white mb-1">{{ $categoriesCount }}</p>
              <p class="text-sm text-gray-400 font-medium">Categories</p>
            </div>

            <!-- Available Copies Card -->
            <div class="bg-[#2c2e33]  rounded-xl p-6 hover:shadow-xl hover:border-purple-500/50 transition-all duration-300 hover:-translate-y-1">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center">
                  <i class="bi bi-stack text-purple-500 text-2xl"></i>
                </div>
                <span class="px-3 py-1 bg-yellow-500/10 text-yellow-500 text-xs font-semibold rounded-full">0%</span>
              </div>
              <p class="text-3xl font-bold text-white mb-1">{{ $availableCopies }}</p>
              <p class="text-sm text-gray-400 font-medium">Available Copies</p>
            </div>

            <!-- Authors Card -->
            <div class="bg-[#2c2e33]  rounded-xl p-6 hover:shadow-xl hover:border-orange-500/50 transition-all duration-300 hover:-translate-y-1">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-500/10 rounded-xl flex items-center justify-center">
                  <i class="bi bi-people-fill text-orange-500 text-2xl"></i>
                </div>
                <span class="px-3 py-1 bg-green-500/10 text-green-500 text-xs font-semibold rounded-full">+5%</span>
              </div>
              <p class="text-3xl font-bold text-white mb-1">{{ $authorsCount }}</p>
              <p class="text-sm text-gray-400 font-medium">Authors</p>
            </div>
          </div>

          <!-- Books Table -->
          <div class="bg-[#2c2e33]  rounded-xl shadow-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-[#373a40]">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                  <i class="bi bi-clock-history text-cyan-500"></i>
                  Recently Added Books
                </h3>
                <a href="{{ route('books') }}" class="text-sm text-cyan-500 hover:text-cyan-400 transition-colors">
                  View All <i class="bi bi-arrow-right ms-1"></i>
                </a>
              </div>
            </div>

            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-[#25262b] border-b border-[#373a40]">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Book</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Author</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">ISBN</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Copies</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentBooks as $index => $book)
                  <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 {{ $index % 2 == 0 ? 'bg-[#2c2e33]' : 'bg-[#272931]' }}">
                    <td class="px-6 py-4">
                      <span class="text-white font-semibold text-base">{{ $book->id }}</span>
                    </td>
                    <td class="px-4 py-4">
                      <div class="flex items-center gap-3">
                        @if($book->image)
                          <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" 
                               class="rounded-lg w-12 h-12 object-cover " />
                        @else
                          <div class="flex items-center justify-center bg-[#1a1b1e] rounded-lg w-12 h-12 ">
                            <i class="bi bi-book text-gray-500 text-xl"></i>
                          </div>
                        @endif
                        <div>
                          <div class="text-white font-semibold text-sm">{{ Str::limit($book->title, 30) }}</div>
                          <small class="text-gray-500 text-xs">ID: {{ $book->id }}</small>
                        </div>
                      </div>
                    </td>
                    <td class="px-4 py-4">
                      <span class="text-gray-300 text-sm">{{ $book->author }}</span>
                    </td>
                    <td class="px-4 py-4">
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-500 border-blue-500/20">
                        <i class="bi bi-tag-fill me-1.5"></i>{{ $book->category }}
                      </span>
                    </td>
                    <td class="px-4 py-4">
                      <span class="text-gray-400 text-sm font-mono">{{ $book->isbn }}</span>
                    </td>
                    <td class="px-4 py-4">
                      <div class="text-gray-300 text-sm">{{ \Carbon\Carbon::parse($book->publish_date)->format('M d, Y') }}</div>
                      <small class="text-gray-500 text-xs">{{ $book->created_at->diffForHumans() }}</small>
                    </td>
                    <td class="px-4 py-4">
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-500/10 text-emerald-500 border-emerald-500/20">
                        <i class="bi bi-stack me-1.5"></i>{{ $book->copies }}
                      </span>
                    </td>
                    
                    <td class="px-4 py-4 text-end">
                      <div class="flex gap-2 justify-end">
                       <div class="hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200 rounded-md">
                         <button class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent  border-cyan-500/20 text-cyan-500 editBtn" 
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
                       </div>
                        <form method="POST" action="{{ route('delete-book', $book->id) }}" class="inline delete-book-form">
                          @csrf
                          @method('DELETE')
                     <div class="hover:bg-red-500/10 hover:border-red-500/40 transition-all duration-200 rounded-md">
                           <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent  border-red-500/20 text-red-500" 
                                  title="Delete Book">
                            <i class="bi bi-trash text-base"></i>
                          </button>
                     </div>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="8" class="text-center py-12">
                      <div class="flex flex-col items-center justify-center">
                        <i class="bi bi-inbox text-6xl text-gray-600 mb-4"></i>
                        <h5 class="text-white text-lg font-semibold mb-2">No Books Yet</h5>
                        <p class="text-gray-400 mb-4">Start building your library by adding your first book.</p>
                        <a href="{{ route('books') }}" class="inline-flex items-center px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors">
                          <i class="bi bi-plus-circle me-2"></i>Add Your First Book
                        </a>
                      </div>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            @if($recentBooks->hasPages())
            <div class="px-6 py-4 border-t border-[#373a40] bg-[#25262b] flex items-center justify-between">
              <div class="text-sm text-gray-400">
                Showing <span class="font-semibold text-white">{{ $recentBooks->firstItem() }}-{{ $recentBooks->lastItem() }}</span> of <span class="font-semibold text-white">{{ $recentBooks->total() }}</span> books
              </div>
              <div class="flex items-center gap-2">
                @if ($recentBooks->onFirstPage())
                  <span class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-600 cursor-not-allowed"><i class="bi bi-chevron-left"></i></span>
                @else
                  <a href="{{ $recentBooks->previousPageUrl() }}" class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-300 hover:text-cyan-500 transition-all"><i class="bi bi-chevron-left"></i></a>
                @endif
                @foreach ($recentBooks->getUrlRange(1, $recentBooks->lastPage()) as $page => $url)
                  @if ($page == $recentBooks->currentPage())
                    <span class="px-4 py-2 rounded-lg bg-cyan-500 text-white font-semibold">{{ $page }}</span>
                  @else
                    <a href="{{ $url }}" class="px-4 py-2 rounded-lg bg-[#2c2e33] text-gray-300 hover:text-white transition-all">{{ $page }}</a>
                  @endif
                @endforeach
                @if ($recentBooks->hasMorePages())
                  <a href="{{ $recentBooks->nextPageUrl() }}" class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-300 hover:text-cyan-500 transition-all"><i class="bi bi-chevron-right"></i></a>
                @else
                  <span class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-600 cursor-not-allowed"><i class="bi bi-chevron-right"></i></span>
                @endif
              </div>
            </div>
            @endif

          </div>
        </div>
      </main>

      <!-- Include Book Modal Component -->
      <x-book-modal />

      <!-- Bootstrap JS Bundle -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/book-modal.js') }}"></script>
        <script src="{{ asset('js/sidebar.js') }}"></script>

<script>
// Handle delete book confirmation
document.addEventListener('submit', async function(e) {
  if (e.target.classList.contains('delete-book-form')) {
    e.preventDefault();
    const confirmed = await showConfirm(
      'Are you sure you want to delete this book? This action cannot be undone.',
      'Delete Book'
    );
    if (confirmed) {
      e.target.submit();
    }
  }
});
</script>
</body>

</html>
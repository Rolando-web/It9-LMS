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
                    <td class="px-4 py-4">
                        @if($book->image)
                            <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" class="rounded-lg w-16 h-16 object-cover border border-[#373a40]" />
                        @else
                            <div class="flex items-center justify-center bg-[#1a1b1e] rounded-lg w-16 h-16 border border-[#373a40]">
                                <i class="bi bi-book text-gray-500 text-2xl"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        <span class="text-white font-semibold text-base">{{ $book->id }}</span>
                    </td>
                    <td class="px-4 py-4">
                        <div>
                            <div class="text-white font-semibold text-sm">{{ $book->title }}</div>
                            <small class="text-gray-500 text-xs">{{ Str::limit($book->title, 40) }}</small>
                        </div>
                    </td>
                    <td class="px-4 py-4 d-none d-sm-table-cell">
                        <span class="text-gray-300 text-sm">{{ $book->author }}</span>
                    </td>
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-500">
                            <i class="bi bi-tag-fill me-1.5"></i>{{ $book->category }}
                        </span>
                    </td>
                    <td class="px-4 py-4 d-none d-lg-table-cell">
                        <span class="text-gray-400 text-sm font-mono">{{ $book->isbn }}</span>
                    </td>
                    <td class="px-4 py-4 d-none d-md-table-cell">
                        <span class="text-gray-300 text-sm">{{ \Carbon\Carbon::parse($book->publish_date)->format('M d, Y') }}</span>
                    </td>
                    <td class="px-4 py-4 d-none d-lg-table-cell">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-500/10 text-emerald-500 border-emerald-500/20">
                            <i class="bi bi-stack me-1.5"></i>{{ $book->copies }}
                        </span>
                    </td>
                    <td class="px-4 py-4 d-none d-lg-table-cell">
                        @if($book->user)
                            <div>
                                <div class="text-white font-medium text-sm">{{ $book->user->firstName }}</div>
                                <small class="text-gray-500 text-xs">{{ ucfirst(str_replace('_', ' ', $book->user->role)) }}</small>
                            </div>
                            <div class="text-gray-400 text-xs mt-1">{{ $book->created_at->format('M d, Y') }}</div>
                        @else
                            <span class="text-gray-500 text-xs">N/A</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-end">
                        <div class="flex gap-2 justify-end">
                            <div class="rounded-md hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200">
                                <button class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border-cyan-500/20 text-cyan-500 editBtn"
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
                            <form method="POST" action="{{ route('delete-book', $book->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                @csrf
                                @method('DELETE')
                                <div class="hover:bg-red-500/10 hover:border-red-500/40 transition-all rounded-md">
                                    <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border-red-500/20 text-red-500" title="Delete Book">
                                        <i class="bi bi-trash text-base"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center py-12">
                        <div class="flex flex-col items-center justify-center">
                            <i class="bi bi-inbox text-6xl text-gray-600 mb-4"></i>
                            <h5 class="text-white text-lg font-semibold mb-2">No Books Found</h5>
                            <p class="text-gray-400 mb-4">Try adjusting your search or filter criteria.</p>
                            <button type="button" class="inline-flex items-center gap-2 bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-2 rounded-lg font-semibold transition-colors" data-bs-toggle="modal" data-bs-target="#addBookModal">
                                <i class="bi bi-plus-circle"></i> Add New Book
                            </button>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($books->hasPages())
    <div class="px-6 py-4 border-t border-[#373a40] bg-[#25262b] flex items-center justify-between">
        <div class="text-sm text-gray-400">
            Showing <span class="font-semibold text-white">{{ $books->firstItem() }}-{{ $books->lastItem() }}</span> of <span class="font-semibold text-white">{{ $books->total() }}</span> books
        </div>
        <div class="flex items-center gap-2">
            @if ($books->onFirstPage())
                <span class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-600 cursor-not-allowed"><i class="bi bi-chevron-left"></i></span>
            @else
                <a href="{{ $books->previousPageUrl() }}" class="page-link px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-300 hover:text-cyan-500 transition-all" data-page="{{ $books->currentPage() - 1 }}"><i class="bi bi-chevron-left"></i></a>
            @endif
            @foreach ($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                @if ($page == $books->currentPage())
                    <span class="px-4 py-2 rounded-lg bg-cyan-500 text-white font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-link px-4 py-2 rounded-lg bg-[#2c2e33] text-gray-300 hover:text-white transition-all" data-page="{{ $page }}">{{ $page }}</a>
                @endif
            @endforeach
            @if ($books->hasMorePages())
                <a href="{{ $books->nextPageUrl() }}" class="page-link px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-300 hover:text-cyan-500 transition-all" data-page="{{ $books->currentPage() + 1 }}"><i class="bi bi-chevron-right"></i></a>
            @else
                <span class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-600 cursor-not-allowed"><i class="bi bi-chevron-right"></i></span>
            @endif
        </div>
    </div>
@endif

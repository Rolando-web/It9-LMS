@forelse($recentBooks as $index => $book)
<tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 {{ $index % 2 == 0 ? 'bg-[#2c2e33]' : 'bg-[#272931]' }}">
  <td class="px-6 py-4">
    <span class="text-white font-semibold text-base">{{ $book->id }}</span>
  </td>
  <td class="px-4 py-4">
    <div class="flex items-center gap-3">
      @if($book->image)
        <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" class="rounded-lg w-12 h-12 object-cover" />
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
        <div class="hover:bg-red-500/10 hover:border-red-500/40 transition-all duration-200 rounded-md">
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
  <td colspan="8" class="text-center py-12">
    <div class="flex flex-col items-center justify-center">
      <i class="bi bi-inbox text-6xl text-gray-600 mb-4"></i>
      <h5 class="text-white text-lg font-semibold mb-2">No Books Added on this Date</h5>
      <p class="text-gray-400 mb-4">Select another date to view recent books.</p>
    </div>
  </td>
</tr>
@endforelse

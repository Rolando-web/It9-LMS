<x-page-header>
  Transaction Overview
</x-page-header>
 @include('layouts.partials.header')


<!-- Main Content -->
  <main class="max-w-7xl mx-auto px-6 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="bg-[#1E2939] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium ">Active Borrowings</h3>
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
          </svg>
        </div>
        <div class="text-3xl font-bold mb-2">{{ $active->total() ?? 0 }}</div>
        <div class="text-sm opacity-80">Currently borrowed books</div>
      </div>

      <!-- Overdue Books -->
      <div class="bg-[#1E2939] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-white">Overdue Books</h3>
          <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
        </div>
        <div class="flex items-center space-x-2 mb-2">
          <div class="text-3xl font-bold">{{ $overdueCount ?? 0 }}</div>
        </div>
        <div class="text-sm text-white">Books past due date</div>
      </div>

      <!-- Outstanding Fees -->
      <div class="bg-[#1E2939] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-white">Total Fees</h3>
          <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
        </div>
        <div class="text-3xl font-bold mb-2 {{ abs($outstandingFees ?? 0) > 0 ? 'text-red-400' : 'text-emerald-400' }}">
          ₱{{ number_format(abs($outstandingFees ?? 0), 2) }}
        </div>
        <div class="text-sm text-white opacity-80 mb-4">Total fees to pay</div>
        
        @if(abs($outstandingFees ?? 0) > 0)
          <button class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-3 py-2 rounded-lg transition-colors duration-200">
            <i class="bi bi-credit-card text-xs"></i>
            <span>Pay Now</span>
          </button>
        @else
          <div class="inline-flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium px-3 py-2 rounded-lg">
            <i class="bi bi-check-circle-fill text-xs"></i>
            <span>No Fees</span>
          </div>
        @endif
        
      </div>

      <!-- Total Transactions -->
      <div class="bg-[#1E2939] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-white">Total Transactions</h3>
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <div class="text-3xl font-bold mb-2">{{ $totalTransactions ?? 0 }}</div>
        <div class="text-sm text-white">All-time borrowings</div>
      </div>
    </div>

    <!-- Active Borrowings Table -->
    <div class="bg-[#1E2939] rounded-xl p-6 mb-8">
      <div class="flex items-center space-x-2 mb-6">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
        <h2 class="text-xl font-semibold text-white opacity-70">Active Borrowings 1</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-gray-200 border-opacity-20">
              <th class="text-left py-3 px-4 font-medium text-white">Transaction ID</th>
              <th class="text-left py-3 px-4 font-medium text-white">Book ID</th>
              <th class="text-left py-3 px-4 font-medium text-white">Title</th>
              <th class="text-left py-3 px-4 font-medium text-white">Author</th>
              <th class="text-left py-3 px-4 font-medium text-white">Borrowed Date</th>
              <th class="text-left py-3 px-4 font-medium text-white">Due Date</th>
              <th class="text-left py-3 px-4 font-medium text-white">Status</th>
              <th class="text-left py-3 px-4 font-medium text-white">Fee</th>
              <th class="text-left py-3 px-4 font-medium text-white">Cover</th>
            </tr>
          </thead>
          <tbody class="text-white">
            @forelse($active as $tx)
              <tr class="border-b border-gray-100 hover:bg-[#101929] border-opacity-10">
                <td class="py-4 px-4 font-medium">{{ $tx->id }}</td>
                <td class="py-4 px-4">{{ $tx->book_id }}</td>
                <td class="py-4 px-4 font-medium">{{ optional($tx->book)->title ?? '—' }}</td>
                <td class="py-4 px-4">{{ optional($tx->book)->author ?? '—' }}</td>
                <td class="py-4 px-4">{{ $tx->borrowed_at ? \Carbon\Carbon::parse($tx->borrowed_at)->format('M d, Y') : '' }}</td>
                <td class="py-4 px-4">{{ $tx->due_date ? \Carbon\Carbon::parse($tx->due_date)->format('M d, Y') : '' }}</td>
                <td class="py-4 px-4">
                  @php
                    $statusClasses = [
                      'borrowed' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                      'overdue' => 'bg-red-500/20 text-red-400 border-red-500/30',
                      'return_pending' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                      'damaged' => 'bg-orange-500/20 text-orange-400 border-orange-500/30',
                      'returned' => 'bg-green-500/20 text-green-400 border-green-500/30',
                    ];
                    $class = $statusClasses[$tx->status] ?? 'bg-gray-500/20 text-gray-400 border-gray-500/30';
                  @endphp
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium border {{ $class }}">
                    {{ ucfirst(str_replace('_', ' ', $tx->status)) }}
                  </span>
                </td>
                <td class="py-4 px-4 font-medium text-[#e24545]">₱{{ number_format(abs($tx->fee ?? 0), 2) }}</td>
                <td class="py-4 px-4">
                  @php
                    $img = optional($tx->book)->image ?? null;
                  @endphp
                  @if($img)
                    <img src="{{ asset($img) }}" alt="cover" class="w-12 h-16 object-cover rounded">
                  @else
                    <div class="w-12 h-16 bg-gray-700 rounded flex items-center justify-center text-xs text-gray-300">No Image</div>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="py-4 px-4 text-center text-gray-400">No active borrowings.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Transaction History -->
    <div class="bg-[#1E2939] rounded-xl p-6">
      <div class="flex items-center space-x-2 mb-6">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h2 class="text-xl font-semibold text-white opacity-70">Transaction History 1</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-gray-200 border-opacity-20">
              <th class="text-left py-3 px-4 font-medium text-white">Transaction ID</th>
              <th class="text-left py-3 px-4 font-medium text-white">Book ID</th>
              <th class="text-left py-3 px-4 font-medium text-white">Title</th>
              <th class="text-left py-3 px-4 font-medium text-white">Author</th>
              <th class="text-left py-3 px-4 font-medium text-white">Borrowed Date</th>
              <th class="text-left py-3 px-4 font-medium text-white">Return Date</th>
              <th class="text-left py-3 px-4 font-medium text-white">Final Fee</th>
              <th class="text-center py-3 px-4 font-medium text-white">Action</th>
            </tr>
          </thead>
          <tbody class="text-white">
            @forelse($history as $tx)
              <tr class="border-b border-gray-100 hover:bg-[#101929] border-opacity-10">
                <td class="py-4 px-4 font-medium">{{ $tx->id }}</td>
                <td class="py-4 px-4">{{ $tx->book_id }}</td>
                <td class="py-4 px-4 font-medium">{{ optional($tx->book)->title ?? '—' }}</td>
                <td class="py-4 px-4">{{ optional($tx->book)->author ?? '—' }}</td>
                <td class="py-4 px-4">{{ $tx->borrowed_at ? \Carbon\Carbon::parse($tx->borrowed_at)->format('M d, Y') : '' }}</td>
                <td class="py-4 px-4">{{ $tx->returned_at ? \Carbon\Carbon::parse($tx->returned_at)->format('M d, Y') : 'N/A' }}</td>
                <td class="py-4 px-4 font-medium text-[#e24545]">₱{{ number_format(abs($tx->fee ?? 0), 2) }}</td>
                <td class="py-4 px-4 text-center">
                  <button class="view-transaction-btn inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-cyan-500/20 text-cyan-500 hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200"
                          data-bs-toggle="modal" 
                          data-bs-target="#bookModal"
                          data-tx-id="{{ $tx->id }}"
                          data-book-title="{{ optional($tx->book)->title ?? 'N/A' }}"
                          data-book-author="{{ optional($tx->book)->author ?? 'N/A' }}"
                          data-book-image="{{ optional($tx->book)->image ? asset($tx->book->image) : asset('image/default-book.jpg') }}"
                          data-user-name="{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}"
                          data-borrow-date="{{ $tx->borrowed_at ? \Carbon\Carbon::parse($tx->borrowed_at)->format('M d, Y') : 'N/A' }}"
                          data-due-date="{{ $tx->due_date ? \Carbon\Carbon::parse($tx->due_date)->format('M d, Y') : 'N/A' }}"
                          data-return-date="{{ $tx->returned_at ? \Carbon\Carbon::parse($tx->returned_at)->format('M d, Y') : 'Not returned' }}"
                          data-status="{{ ucfirst($tx->status) }}"
                          data-fee="{{ number_format($tx->fee ?? 0, 2) }}">
                    <i class="bi bi-eye text-base"></i>
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="py-4 px-4 text-center text-gray-400">No transaction history.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </main>
      <x-transaction-modal/>
<x-import-footer/>

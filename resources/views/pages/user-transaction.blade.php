<x-page-header>
  Transaction Overview
</x-page-header>
 @include('layouts.partials.header')


<!-- Main Content -->
  <main class="max-w-7xl mx-auto px-6 py-8">
    @if(session('success') || session('error'))
      <div id="flash-data" class="hidden" 
           data-success="{{ session('success') }}" 
           data-error="{{ session('error') }}">
      </div>
    @endif
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

    <!-- Total Fees -->
    <div class="bg-[#1E2939] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-white">Total Fees</h3>
          <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
        </div>
        <div class="text-3xl font-bold mb-2 {{ ($outstandingFees ?? 0) > 0 ? 'text-red-400' : 'text-emerald-400' }}">
          <span id="outstandingFeesAmount" data-amount="{{ ($outstandingFees ?? 0) < 0 ? 0 : $outstandingFees }}">₱{{ number_format(($outstandingFees ?? 0) < 0 ? 0 : $outstandingFees, 2) }}</span>
        </div>
        <div class="text-sm text-white opacity-80">Total outstanding balance</div>
        @if(($outstandingFees ?? 0) == 0)
          <div class="inline-flex items-center gap-2 bg-emerald-500/10  border-emerald-500/20 text-emerald-400 text-sm font-medium px-3 py-2 rounded-lg mt-2">
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
              <tr class="border-b border-gray-100 hover:bg-[#101929] border-opacity-10" data-tx-id="{{ $tx->id }}">
                <td class="py-4 px-4 font-medium">{{ $tx->id }}</td>
                <td class="py-4 px-4">{{ $tx->book_id }}</td>
                <td class="py-4 px-4 font-medium">{{ optional($tx->book)->title ?? '—' }}</td>
                <td class="py-4 px-4">{{ optional($tx->book)->author ?? '—' }}</td>
                <td class="py-4 px-4">{{ $tx->borrowed_at ? \Carbon\Carbon::parse($tx->borrowed_at)->format('M d, Y') : '' }}</td>
                <td class="py-4 px-4">{{ $tx->due_date ? \Carbon\Carbon::parse($tx->due_date)->format('M d, Y') : '' }}</td>
                <td class="py-4 px-4">
                  @php
                    $statusClasses = [
                      'borrowed' => 'text-blue-400',
                      'overdue' => 'text-red-400',
                      'return_pending' => 'text-orange-500',
                      'damaged' => 'text-orange-400',
                      'returned' => 'text-green-400',
                    ];
                    $class = $statusClasses[$tx->status] ?? 'text-gray-400';
                  @endphp
                  <span class="status-label inline-flex items-center px-2.5 py-0.5 rounded-md text-small font-medium {{ $class }}">
                    {{ ucfirst(str_replace('_', ' ', $tx->status)) }}
                  </span>
                </td>
                @php
                  $rate = 50; // daily overdue rate
                  $due = $tx->due_date ? \Carbon\Carbon::parse($tx->due_date) : null;
                  $now = \Carbon\Carbon::now();
                  $daysOver = 0;
                  if ($due && $now->greaterThan($due)) {
                    $daysOver = $now->copy()->startOfDay()->diffInDays($due->copy()->startOfDay());
                  }
                  $computedLive = $daysOver * $rate;
                  $originalFee = max(0, (float) ($tx->original_fee ?? 0));
                  if ($tx->status === 'pending') {
                    $displayUserFee = 0;
                  } elseif ($tx->status === 'return_pending') {
                    $displayUserFee = $tx->fee ?? 0;
                  } elseif (in_array($tx->status, ['borrowed','overdue']) && is_null($tx->returned_at)) {
                    $displayUserFee = $computedLive;
                  } else {
                    $displayUserFee = $tx->fee ?? 0;
                  }
                @endphp
                <td class="py-4 px-4 font-medium">
                  @if($tx->status === 'pending')
                    <span class="text-[#e24545]">₱0.00</span>
                  @elseif($displayUserFee == 0 && $originalFee > 0 && in_array($tx->status, ['returned', 'damaged']))
                    <span class="text-gray-400">₱{{ number_format($originalFee, 2) }}/</span><span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-semibold">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                      PAID
                    </span>
                  @else
                    <span class="text-[#e24545] {{ $tx->status === 'return_pending' ? 'live-fee' : (in_array($tx->status,['borrowed','overdue']) && is_null($tx->returned_at) ? 'live-fee' : '') }}"
                          @if(in_array($tx->status,['borrowed','overdue']) && is_null($tx->returned_at))
                            data-due="{{ $tx->due_date ? \Carbon\Carbon::parse($tx->due_date)->toDateString() : '' }}"
                            data-rate="{{ $rate }}"
                            data-freeze="0"
                          @elseif($tx->status === 'return_pending')
                            data-due="{{ $tx->due_date ? \Carbon\Carbon::parse($tx->due_date)->toDateString() : '' }}"
                            data-rate="{{ $rate }}"
                            data-freeze="1"
                          @endif>
                      ₱{{ number_format(max(0,$displayUserFee),2) }}
                    </span>
                  @endif
                </td>
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
              @php
                $finalFee = max(0, (float) ($tx->fee ?? 0));
                $originalFee = max(0, (float) ($tx->original_fee ?? 0));
                $status = strtolower($tx->status ?? '');
              @endphp
              <tr class="border-b border-gray-100 hover:bg-[#101929] border-opacity-10">
                <td class="py-4 px-4 font-medium">{{ $tx->id }}</td>
                <td class="py-4 px-4">{{ $tx->book_id }}</td>
                <td class="py-4 px-4 font-medium">{{ optional($tx->book)->title ?? '—' }}</td>
                <td class="py-4 px-4">{{ optional($tx->book)->author ?? '—' }}</td>
                <td class="py-4 px-4">{{ $tx->borrowed_at ? \Carbon\Carbon::parse($tx->borrowed_at)->format('M d, Y') : '' }}</td>
                <td class="py-4 px-4">{{ $tx->returned_at ? \Carbon\Carbon::parse($tx->returned_at)->format('M d, Y') : 'N/A' }}</td>
                <td class="py-4 px-4 font-medium">
                   @if($finalFee == 0 && $originalFee > 0 && in_array($status, ['returned', 'overdue', 'damaged']) && !empty($tx->returned_at))
                    <span class="text-gray-400">₱{{ number_format($originalFee, 2) }}/</span><span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-emerald-500/10 border-emerald-500/20 text-emerald-400 text-xs font-semibold">PAID</span>
                  @elseif($finalFee > 0)
                    <span class="text-[#e24545]">₱{{ number_format($finalFee, 2) }}</span>
                  @else
                    <span class="text-gray-400">₱0.00</span>
                  @endif
                </td>
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
        data-due-raw="{{ $tx->due_date ? \Carbon\Carbon::parse($tx->due_date)->toDateString() : '' }}"
                          data-return-date="{{ $tx->returned_at ? \Carbon\Carbon::parse($tx->returned_at)->format('M d, Y') : 'Not returned' }}"
        data-status="{{ ucfirst($tx->status) }}"
        data-fee="{{ $finalFee < 0 ? 0 : $finalFee }}"
        data-original-fee="{{ $originalFee }}"
        data-is-paid="{{ $finalFee == 0 && $originalFee > 0 && in_array($status, ['returned', 'overdue', 'damaged']) && !empty($tx->returned_at) ? '1' : '0' }}">
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
  <script src="/js/user-transaction.js"></script>
  
        <x-transaction-modal/>
      <x-notification-modal/>
<x-import-footer/>

<x-page-header>
  Transaction Overview
</x-page-header>
 @include('layouts.partials.header')


<!-- Main Content -->
  <main class="max-w-7xl mx-auto px-6 py-8">
    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      <span>{{ session('error') }}</span>
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
          <div class="inline-flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium px-3 py-2 rounded-lg mt-2">
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
                  // Fee rules (user page):
                  // pending: always 0 (not yet active borrow)
                  // borrowed / overdue (no return request): live overdue days * rate
                  // return_pending: frozen stored fee (no escalation)
                  // damaged / returned / overdue with returned_at: stored fee
                  $computedLive = $daysOver * $rate;
                  if ($tx->status === 'pending') {
                    $displayUserFee = 0;
                  } elseif ($tx->status === 'return_pending') {
                    $displayUserFee = $tx->fee ?? 0; // frozen
                  } elseif (in_array($tx->status, ['borrowed','overdue']) && is_null($tx->returned_at)) {
                    $displayUserFee = $computedLive;
                  } else { // finalized states
                    $displayUserFee = $tx->fee ?? 0;
                  }
                @endphp
                <td class="py-4 px-4 font-medium text-[#e24545]">
                  @if($tx->status === 'pending')
                    <span>₱0.00</span>
                  @else
                    <span class="{{ $tx->status === 'return_pending' ? 'live-fee' : (in_array($tx->status,['borrowed','overdue']) && is_null($tx->returned_at) ? 'live-fee' : '') }}"
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
              @php
                // Compute finalized display fee for history rows
                // Prefer stored fee; fallback to live calculation for active overdue
                $finalFee = max(0, (float) ($tx->fee ?? 0));
                $status = strtolower($tx->status ?? '');
                
                // For active overdue transactions (not yet returned or return pending)
                if ($finalFee <= 0 && !empty($tx->due_date)) {
                  $dueDay = \Carbon\Carbon::parse($tx->due_date)->startOfDay();
                  $today = \Carbon\Carbon::now()->startOfDay();
                  
                  // If returned, use return date; otherwise use today
                  if (!empty($tx->returned_at)) {
                    $retDay = \Carbon\Carbon::parse($tx->returned_at)->startOfDay();
                    if ($retDay->greaterThan($dueDay)) {
                      $finalFee = max(0, $dueDay->diffInDays($retDay) * 50);
                    }
                  } elseif (in_array($status, ['borrowed', 'overdue', 'return_pending']) && $today->greaterThan($dueDay)) {
                    // Active overdue: calculate from due date to today
                    $finalFee = max(0, $dueDay->diffInDays($today) * 50);
                  }
                }
              @endphp
              <tr class="border-b border-gray-100 hover:bg-[#101929] border-opacity-10">
                <td class="py-4 px-4 font-medium">{{ $tx->id }}</td>
                <td class="py-4 px-4">{{ $tx->book_id }}</td>
                <td class="py-4 px-4 font-medium">{{ optional($tx->book)->title ?? '—' }}</td>
                <td class="py-4 px-4">{{ optional($tx->book)->author ?? '—' }}</td>
                <td class="py-4 px-4">{{ $tx->borrowed_at ? \Carbon\Carbon::parse($tx->borrowed_at)->format('M d, Y') : '' }}</td>
                <td class="py-4 px-4">{{ $tx->returned_at ? \Carbon\Carbon::parse($tx->returned_at)->format('M d, Y') : 'N/A' }}</td>
                <td class="py-4 px-4 font-medium">
                  @if($finalFee == 0 && in_array($status, ['returned', 'overdue', 'damaged']) && !empty($tx->returned_at))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-semibold">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                      Paid
                    </span>
                  @else
                    <span class="text-[#e24545]">₱{{ number_format($finalFee < 0 ? 0 : $finalFee, 2) }}</span>
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
        data-fee="{{ $finalFee < 0 ? 0 : $finalFee }}">
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
  <x-pay-modal/>
  <script src="/js/pay-modal.js"></script>
  <script src="/js/user-transaction.js"></script>
  <script>
    // Immediately reflect return request fee and status on the table without waiting for admin approval
    (function(){
      function findRowByTxId(txId){
        let row = document.querySelector(`tr[data-tx-id="${txId}"]`);
        if (row) return row;
        // Fallback: find by first cell text matching txId
        const rows = document.querySelectorAll('table tbody tr');
        for (const r of rows){
          const first = r.querySelector('td');
          if (first && first.textContent.trim() === String(txId)) return r;
        }
        return null;
      }

      function formatMoney(n){
        const v = Math.max(0, parseFloat(n||0));
        return `₱${v.toFixed(2)}`;
      }

      function updateOutstanding(delta){
        const amtEl = document.getElementById('outstandingFeesAmount');
        if (!amtEl) return;
        const current = parseFloat(amtEl.getAttribute('data-amount')||'0');
        const next = Math.max(0, current + (parseFloat(delta)||0));
        amtEl.setAttribute('data-amount', String(next));
        amtEl.textContent = `₱${next.toFixed(2)}`;
        const payBtn = document.getElementById('outstandingFeesPayBtn');
        if (payBtn) payBtn.setAttribute('data-fee', String(next));
      }

      // Listen for custom event dispatched after return success if present
      window.addEventListener('user:return-success', function(ev){
        const detail = ev.detail || {};
        const txId = detail.id;
        const fee = parseFloat(detail.fee||0);
        const row = findRowByTxId(txId);
        if (row){
          // Update status label
          const statusCell = row.children[6]; // Status column
          if (statusCell){
            statusCell.innerHTML = '<span class="status-label inline-flex items-center px-2.5 py-0.5 rounded-md text-small font-medium text-orange-500">Return pending</span>';
          }
          // Update fee and freeze it
          const feeCell = row.children[7];
          const feeSpan = feeCell ? feeCell.querySelector('.live-fee') : null;
          let prev = 0;
          if (feeSpan){
            const text = feeSpan.textContent || '';
            const m = text.replace(/[^\d.]/g,'');
            prev = parseFloat(m||'0')||0;
            feeSpan.setAttribute('data-freeze','1');
            feeSpan.textContent = formatMoney(fee);
          }
          // Update outstanding total by delta
          updateOutstanding(fee - prev);
        }
      });

      // Intercept clicks on .return-btn in this page to update UI immediately after fetch success
      document.addEventListener('click', function(e){
        const btn = e.target.closest && e.target.closest('.return-btn');
        if (!btn) return;
        const txId = btn.getAttribute('data-tx-id') || btn.dataset.txId;
        if (!txId) return;
        // Patch fetch response handling by listening to a marker set by the shared handler
        // If the global handler isn’t present, do nothing here.
        const handler = function(ev){
          if (!ev || !ev.detail) return;
          if (String(ev.detail.id) !== String(txId)) return;
          window.removeEventListener('user:return-success', handler);
        };
        window.addEventListener('user:return-success', handler);
      }, true);
    })();

    // Optional live updater: recalculate overdue fee in the browser for active borrowings
    (function(){
      function computeDaysOver(todayStr, dueStr){
        if(!dueStr) return 0;
        try {
          // normalize to local midnight to avoid partial-day issues
          const toMid = (d) => { const dt = new Date(d+"T00:00:00"); dt.setHours(0,0,0,0); return dt; };
          const due = toMid(dueStr);
          const today = new Date(); today.setHours(0,0,0,0);
          const diffMs = today.getTime() - due.getTime();
          const days = Math.floor(diffMs / (1000*60*60*24));
          return days > 0 ? days : 0;
        } catch { return 0; }
      }

      function updateFees(){
        const nodes = document.querySelectorAll('.live-fee');
        nodes.forEach(node => {
          const freeze = node.getAttribute('data-freeze') === '1';
          if (freeze) return; // do not update frozen (return_pending)
          const due = node.getAttribute('data-due');
          const rate = parseFloat(node.getAttribute('data-rate')||'50');
          const days = computeDaysOver(undefined, due);
          const raw = days * rate;
          const fee = (raw < 0 ? 0 : raw).toFixed(2);
          node.textContent = `₱${fee}`;
        });
      }

      updateFees();
      // Update periodically (every minute)
      setInterval(updateFees, 60000);
    })();
  </script>
      <x-transaction-modal/>
  <x-notification-modal/>
<x-import-footer/>

<x-import>
  <title>Transactions - Book Management System</title>
</x-import>


  <div class="d-flex min-vh-100 bg-[#1a1b1e]">
    @include('components.sidebar')
    
    <x-header>
      <h1 class="text-light mb-0 text-3xl flex items-center gap-2">
        <i class="bi bi-arrow-left-right text-orange-500"></i>
        Book Transactions
      </h1>
    </x-header>

    <div class="flex-grow-1 p-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-[#2c2e33] rounded-lg p-4 hover:border-blue-500/50 transition-all">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-400 text-sm mb-1">Total Borrowed</p>
              <p class="text-2xl font-bold text-white">{{ $totalBorrowed ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-book text-blue-500 text-xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-[#2c2e33] rounded-lg p-4 hover:border-emerald-500/50 transition-all">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-400 text-sm mb-1">Returned</p>
              <p class="text-2xl font-bold text-white">{{ $totalReturned ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-emerald-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-check-circle text-emerald-500 text-xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-[#2c2e33] rounded-lg p-4 hover:border-red-500/50 transition-all">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-400 text-sm mb-1">Overdue</p>
              <p class="text-2xl font-bold text-white">{{ $totalOverdue ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-red-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-exclamation-triangle text-red-500 text-xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-[#2c2e33] rounded-lg p-4 hover:border-amber-500/50 transition-all">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-400 text-sm mb-1">Total Fees</p>
              <p class="text-2xl font-bold text-white">₱{{ number_format($totalFees ?? 0, 2) }}</p>
            </div>
            <div class="w-12 h-12 bg-amber-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-currency-dollar text-amber-500 text-xl"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-[#2c2e33] rounded-xl shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-[#373a40]">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
              <i class="bi bi-list-ul text-orange-500"></i>
              Recent Transactions
            </h3>
            
            <!-- Filter Dropdown -->
            <div class="flex items-center gap-3">
              <label for="statusFilter" class="text-gray-400 text-sm font-medium flex items-center gap-2">
                <i class="bi bi-funnel"></i>
                Filter:
              </label>
              <div class="relative">
                <select id="statusFilter" class="bg-[#1a1b1e] border border-[#373a40] text-white rounded-lg px-4 py-2 pr-10 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all cursor-pointer appearance-none">
                  <option value="">All Statuses</option>
                  <option value="pending">Pending</option>
                  <option value="borrowed">Borrowed</option>
                  <option value="returned">Returned</option>
                  <option value="overdue">Overdue</option>
                  <option value="return_pending">Return Pending</option>
                  <option value="damaged">Damaged</option>
                  <option value="rejected">Rejected</option>
                </select>
                <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
              </div>
              <button id="clearFilter" class="hidden text-gray-400 hover:text-red-500 transition-colors" title="Clear filter">
                <i class="bi bi-x-circle text-xl"></i>
              </button>
            </div>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-[#25262b] border-b border-[#373a40]">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">ID</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">User Name</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Book Title</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Borrow Date</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Due Date</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Return Date</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Fee</th>
                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($transactions as $transaction)
                <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#2c2e33]">
                  <td class="px-4 py-4">
                    <span class="text-white font-semibold text-base">{{ $transaction->id }}</span>
                  </td>
                  <td class="px-4 py-4">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 bg-blue-500/10 rounded-full flex items-center justify-center">
                        <i class="bi bi-person-fill text-blue-500"></i>
                      </div>
                      <span class="text-white font-medium">{{ optional($transaction->user)->firstName }} {{ optional($transaction->user)->lastName }}</span>
                    </div>
                  </td>
                  <td class="px-4 py-4">
                    <span class="text-gray-300 text-sm">{{ optional($transaction->book)->title ?? 'N/A' }}</span>
                  </td>
                  <td class="px-4 py-4">
                    <span class="text-gray-300 text-sm">{{ $transaction->borrowed_at ? \Carbon\Carbon::parse($transaction->borrowed_at)->format('M d, Y') : 'N/A' }}</span>
                  </td>
                  <td class="px-4 py-4">
                    <span class="text-gray-300 text-sm">{{ $transaction->due_date ? \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') : 'N/A' }}</span>
                  </td>
                  <td class="px-4 py-4">
                    <span class="{{ $transaction->returned_at ? 'text-emerald-500' : 'text-gray-400' }} text-sm">
                      {{ $transaction->returned_at ? \Carbon\Carbon::parse($transaction->returned_at)->format('M d, Y') : 'Not returned' }}
                    </span>
                  </td>
                  <td class="px-4 py-4">
                    @if($transaction->status === 'returned')
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-500/10 text-emerald-500 border-emerald-500/20">
                        <i class="bi bi-check-circle-fill me-1.5"></i>Returned
                      </span>
                    @elseif($transaction->status === 'overdue')
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-500/10 text-red-500 border-red-500/20">
                        <i class="bi bi-exclamation-triangle-fill me-1.5"></i>Overdue
                      </span>
                    @elseif($transaction->status === 'borrowed')
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-500 border-blue-500/20">
                        <i class="bi bi-book-fill me-1.5"></i>Borrowed
                      </span>
                    @elseif($transaction->status === 'pending')
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-500/10 text-amber-500 border-amber-500/20">
                        <i class="bi bi-clock-fill me-1.5"></i>Pending
                      </span>
                    @elseif($transaction->status === 'return_pending')
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-orange-500/10 text-orange-500 border-purple-500/20">
                        <i class="bi bi-arrow-return-left me-1.5"></i>Return Pending
                      </span>
                    @elseif($transaction->status === 'damaged')
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-orange-500/10 text-orange-500 border-orange-500/20">
                        <i class="bi bi-exclamation-octagon-fill me-1.5"></i>Damaged
                      </span>
                    @elseif($transaction->status === 'rejected')
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-500/10 text-gray-500 border-gray-500/20">
                        <i class="bi bi-x-circle-fill me-1.5"></i>Rejected
                      </span>
                    @else
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-500/10 text-gray-500 border-gray-500/20">
                        {{ ucfirst(str_replace('_', ' ', $transaction->status)) }}
                      </span>
                    @endif
                  </td>
                  <td class="px-4 py-4">
                    <span class="text-gray-300 text-sm">₱{{ number_format($transaction->fee ?? 0, 2) }}</span>
                  </td>
                  <td class="px-4 py-4 text-end">
                    <div class="inline-flex items-center gap-2">
                      <div class="hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200 rounded-md">
                        <button class="view-transaction-btn inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border-cyan-500/20 text-cyan-500"
                              data-bs-toggle="modal" 
                              data-bs-target="#bookModal"
                              data-tx-id="{{ $transaction->id }}"
                              data-book-title="{{ optional($transaction->book)->title ?? 'N/A' }}"
                              data-book-author="{{ optional($transaction->book)->author ?? 'N/A' }}"
                              data-book-image="{{ optional($transaction->book)->image ? asset($transaction->book->image) : asset('image/default-book.jpg') }}"
                              data-user-name="{{ optional($transaction->user)->firstName }} {{ optional($transaction->user)->lastName }}"
                              data-borrow-date="{{ $transaction->borrowed_at ? \Carbon\Carbon::parse($transaction->borrowed_at)->format('M d, Y') : 'N/A' }}"
                              data-due-date="{{ $transaction->due_date ? \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') : 'N/A' }}"
                              data-return-date="{{ $transaction->returned_at ? \Carbon\Carbon::parse($transaction->returned_at)->format('M d, Y') : 'Not returned' }}"
                              data-status="{{ ucfirst(str_replace('_', ' ', $transaction->status)) }}"
                              data-fee="{{ number_format($transaction->fee ?? 0, 2) }}">
                        <i class="bi bi-eye text-base"></i>
                      </button>
                  </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="px-4 py-8 text-center text-gray-400">
                    <i class="bi bi-inbox text-4xl mb-2"></i>
                    <p>No transactions found</p>
                  </td>
                </tr>
              @endforelse          
            </tbody>
          </table>
        </div>


        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-[#373a40]">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-400">
              Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} transactions
            </div>
            <div class="flex gap-2">
              @if ($transactions->onFirstPage())
                <span class="px-4 py-2 text-sm font-medium text-gray-500 bg-[#25262b] border border-[#373a40] rounded-lg cursor-not-allowed">
                  <i class="bi bi-chevron-left"></i> Previous
                </span>
              @else
                <a href="{{ $transactions->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-white bg-[#25262b] border border-[#373a40] rounded-lg hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all">
                  <i class="bi bi-chevron-left"></i> Previous
                </a>
              @endif
              @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                @if ($page == $transactions->currentPage())
                  <span class="px-4 py-2 text-sm font-medium text-white bg-cyan-500 border border-cyan-500 rounded-lg">
                    {{ $page }}
                  </span>
                @else
                  <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-white bg-[#25262b] border border-[#373a40] rounded-lg hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all">
                    {{ $page }}
                  </a>
                @endif
              @endforeach
              @if ($transactions->hasMorePages())
                <a href="{{ $transactions->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-white bg-[#25262b] border border-[#373a40] rounded-lg hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all">
                  Next <i class="bi bi-chevron-right"></i>
                </a>
              @else
                <span class="px-4 py-2 text-sm font-medium text-gray-500 bg-[#25262b] border border-[#373a40] rounded-lg cursor-not-allowed">
                  Next <i class="bi bi-chevron-right"></i>
                </span>
              @endif
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
    </div>

<x-transaction-modal/>

<!-- Reject Return Modal -->
<div class="modal fade" id="rejectReturnModal" tabindex="-1" role="dialog" aria-labelledby="rejectReturnModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color: #2c2e33; border: 1px solid #373a40;">
      <div class="modal-header" style="border-bottom: 1px solid #373a40;">
        <h5 class="modal-title text-white" id="rejectReturnModalLabel">
          <i class="bi bi-x-circle text-danger me-2"></i>
          Reject Book Return
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="rejectReturnForm">
          <input type="hidden" id="rejectTransactionId" name="transaction_id">
          
          <div class="mb-3">
            <label for="rejectReason" class="form-label text-white">
              <i class="bi bi-file-text me-1"></i>Rejection Reason
            </label>
            <textarea 
              class="form-control" 
              id="rejectReason" 
              name="reason" 
              rows="3" 
              placeholder="Describe the damage or reason for rejection..."
              required
              style="background-color: #1a1b1e; border-color: #373a40; color: white;"></textarea>
            <small class="text-muted">Explain why the book is being rejected</small>
          </div>

          <div class="mb-3">
            <label for="damageFee" class="form-label text-white">
              <i class="bi bi-currency-dollar me-1"></i>Damage Fee (₱)
            </label>
            <input 
              type="number" 
              class="form-control" 
              id="damageFee" 
              name="damage_fee" 
              min="0" 
              step="0.01"
              value="50.00"
              placeholder="Enter damage fee"
              required
              style="background-color: #1a1b1e; border-color: #373a40; color: white;">
            <small class="text-muted">Standard damage fee is ₱50.00</small>
          </div>

          <div class="alert alert-warning" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            This will charge the user for book damage and mark the transaction as "damaged".
          </div>
        </form>
      </div>
      <div class="modal-footer" style="border-top: 1px solid #373a40;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i>Cancel
        </button>
        <button type="button" class="btn btn-danger" id="confirmRejectBtn">
          <i class="bi bi-check-circle me-1"></i>Confirm Rejection
        </button>
      </div>
    </div>
  </div>
</div>

<x-import-footer/>
<script src="{{ asset('js/staff.js') }}"></script>
<script src="{{ asset('js/return-modal.js') }}"></script>
<script src="{{ asset('js/transaction-filter.js') }}"></script>


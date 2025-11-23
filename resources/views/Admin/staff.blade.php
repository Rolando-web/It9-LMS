<x-import>
  <title>Manage Borrow Approvals</title>
</x-import>

  <div class="d-flex min-vh-100 bg-[#1a1b1e]">

    @include('components.sidebar')

    <x-header>
      <h1 class="text-light mb-0 text-3xl flex items-center gap-2">
<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" role="img">
  <path d="M16 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z"></path>
  <path d="M8 11c1.657 0 3-1.343 3-3S9.657 5 8 5 5 6.343 5 8s1.343 3 3 3z"></path>
  <path d="M2 20c0-2.21 1.79-4 4-4h12c2.21 0 4 1.79 4 4v0" opacity="0.9"></path>
  <path d="M6 20c0-1.657 1.343-3 3-3h0M15 20c0-1.657 1.343-3 3-3h0" opacity="0.9"></path>
</svg>
        Manage Borrow Requests
      </h1>
    </x-header>


    <div class="flex-grow-1 p-6">
      <!-- Stats Card -->
      <div class="bg-[#2c2e33] rounded-lg p-4 mb-6 border-[#373a40]">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-xl font-semibold text-white mb-1 flex items-center gap-2">
              <i class="bi bi-clock-history text-amber-500"></i>
              Pending Borrow Requests
            </h2>
            <p class="text-sm text-gray-400">Review and approve or reject pending book borrow requests</p>
          </div>
          <div class="bg-amber-500/10 border-amber-500/20 rounded-lg px-4 py-3">
            <div class="text-center">
              <p class="text-sm text-amber-500 mb-1">Total Pending</p>
              <p class="text-2xl font-bold text-white">{{ count($transactions) }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Container -->
      <div class="bg-[#2c2e33] rounded-xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full min-w-full">
            <thead class="bg-[#25262b] border-b border-[#373a40]">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-400 whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    <i class="bi bi-hash"></i>
                    Transaction ID
                  </div>
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-400 whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    <i class="bi bi-person"></i>
                    User Name
                  </div>
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-400 whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    <i class="bi bi-book"></i>
                    Book Title
                  </div>
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-400 whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    <i class="bi bi-calendar"></i>
                    Borrow Date
                  </div>
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-400 whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    <i class="bi bi-calendar-check"></i>
                    Due Date
                  </div>
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-400 whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    <i class="bi bi-info-circle"></i>
                    Status
                  </div>
                </th>
                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-400 whitespace-nowrap">
                  <div class="flex items-center justify-center gap-2">
                    <i class="bi bi-gear"></i>
                    Actions
                  </div>
                </th>
              </tr>
            </thead>
            <tbody>
              @forelse($transactions as $tx)
                @php 
                  $book = optional($tx->book); 
                  $user = optional($tx->user); 
                @endphp
                <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#2c2e33]" id="tx-row-{{ $tx->id }}">
                  <td class="px-6 py-4">
                    <span class="text-white font-bold text-base">#{{ $tx->id }}</span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                      <div>
                        <p class="text-white font-medium">{{ $user->firstName }} {{ $user->lastName }}</p>
                        <p class="text-xs text-gray-400">ID: {{ $user->id ?? $tx->user_id }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                      <div>
                        <p class="text-white font-medium">{{ $book->title ?? 'Unknown Title' }}</p>
                        <p class="text-xs text-gray-400">Book ID: {{ $tx->book_id }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <span class="text-gray-300 text-sm">{{ $tx->borrowed_at ? \Carbon\Carbon::parse($tx->borrowed_at)->format('M d, Y') : 'N/A' }}</span>
                  </td>
                  <td class="px-6 py-4">
                    <span class="text-gray-300 text-sm">{{ $tx->due_date ? \Carbon\Carbon::parse($tx->due_date)->format('M d, Y') : 'N/A' }}</span>
                  </td>
                  <td class="px-6 py-4">
                    @if($tx->status === 'pending')
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-500/10 text-amber-500 border-amber-500/20">
                        <i class="bi bi-clock-fill me-1.5"></i>Pending
                      </span>
                    @elseif($tx->status === 'borrowed')
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-500 border border-blue-500/20">
                        <i class="bi bi-book-fill me-1.5"></i>Borrowed
                      </span>
                    @elseif($tx->status === 'overdue')
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-500/10 text-red-500 border border-red-500/20">
                        <i class="bi bi-exclamation-triangle-fill me-1.5"></i>Overdue
                      </span>
                    @elseif($tx->status === 'rejected')
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-500/10 text-gray-500 border border-gray-500/20">
                        <i class="bi bi-x-circle-fill me-1.5"></i>Rejected
                      </span>
                    @else
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-500/10 text-gray-500 border border-gray-500/20">
                        {{ ucfirst($tx->status) }}
                      </span>
                    @endif
                  </td>
                  <td class="px-6 py-4">
                    @if($tx->status === 'pending')
                      <div class="flex gap-2 justify-center">
                        <button data-tx-id="{{ $tx->id }}" data-action="approve" class="approve-btn inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-emerald-600 hover:bg-emerald-500 text-white transition-all duration-200 shadow-lg hover:shadow-emerald-500/20">
                          <i class="bi bi-check-circle-fill"></i>
                          Approve
                        </button>
                        <button data-tx-id="{{ $tx->id }}" data-action="reject" class="reject-btn inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-red-600 hover:bg-red-500 text-white transition-all duration-200 shadow-lg hover:shadow-red-500/20">
                          <i class="bi bi-x-circle-fill"></i>
                          Reject
                        </button>
                      </div>
                    @else
                      <div class="text-center">
                        <span class="text-gray-500 text-sm">No actions available</span>
                      </div>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center">
                      <i class="bi bi-inbox text-6xl text-gray-600 mb-3"></i>
                      <p class="text-gray-400 text-lg font-medium">No pending borrow requests</p>
                      <p class="text-gray-500 text-sm mt-1">All requests have been processed</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Toast notification --}}
  <div id="adminToast" class="fixed top-6 right-6 z-50 hidden">
    <div id="adminToastInner" class="bg-green-600 text-white px-4 py-3 rounded shadow max-w-xs">
      <div id="adminToastMsg" class="font-medium">Action completed</div>
      <div id="adminToastSub" class="text-sm opacity-80"></div>
    </div>
  </div>

  <x-notification-modal/>

  {{-- Import external staff.js --}}
  <script src="{{ asset('js/staff.js') }}"></script>
  <x-import-footer/>

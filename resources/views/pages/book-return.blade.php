<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/svg+xml" href="/vite.svg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="icon" href="../image/willan.jpg" type="image/jpeg">
  <title>Book Return - Home Library</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white font-sans">

       @include('layouts.partials.header')


  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-6 py-8">
    <div class="mb-8">
      <h1 class="text-4xl font-light text-white mb-2">Borrowed Collection</h1>
      <p class="text-gray-400 text-lg">Kindly return borrowed books on or before the due date to prevent extra charges for overdue days.</p>
    </div>


    <!-- Filters and Controls -->
    <div class="bg-gray-800 rounded-xl p-6 mb-8">
      <form id="filterForm" method="GET">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
          <div class="flex flex-wrap gap-2">
            <button class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-white text-gray-900" data-category="all">
              All Books You Borrowed
            </button>
          </div>
        </div>
      </form>
    </div>

{{-- MODAL BORROW Success --}}


    <!-- Books Grid -->
    <div id="booksGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
      @forelse($borrowed as $tx)
        @php $book = optional($tx->book); @endphp
        <div class="bg-gray-800 rounded-xl p-2 hover:bg-gray-750 transition-colors group">
          <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-750 transition-colors group">
            <div class="mb-4">
              <div class="w-full h-48 bg-gradient-to-br from-slate-600 to-slate-800 rounded-lg flex items-center justify-center mb-4 relative overflow-hidden">
                @if($book && $book->image)
                  <img src="{{ asset($book->image) }}" alt="{{ $book->title ?? 'Cover' }}" class="w-full h-full object-cover rounded-lg">
                @else
                  <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                @endif
              </div>
            </div>
            <div class="space-y-2">
              <h3 class="text-white font-medium text-lg leading-tight">{{ $book->title ?? 'Unknown Title' }}</h3>
              <p class="text-gray-400 text-sm">{{ $book->author ?? 'Unknown Author' }}</p>
              <div class="text-sm text-gray-400">Borrowed: {{ $tx->borrowed_at ? \Carbon\Carbon::parse($tx->borrowed_at)->format('M d, Y') : '' }}</div>
              <div class="text-sm text-gray-400">Due: {{ $tx->due_date ? \Carbon\Carbon::parse($tx->due_date)->format('M d, Y') : '' }}</div>
              <div class="mt-2">
                @if($tx->status === 'pending')
                  <h3>Status: <span class="status-chip py-1 rounded text-md text-yellow-600">Pending</span></h3>
                @elseif($tx->status === 'borrowed')
                  <h3>Status: <span class="status-chip py-1 rounded text-md text-green-600">Borrowed</span></h3>
                @elseif($tx->status === 'overdue')
                  <h3>Status: <span class="status-chip py-1 rounded text-md text-red-600">Overdue</span></h3>
                @else
                  <h3>Status: <span class="status-chip py-1 rounded text-md text-gray-600">{{ ucfirst($tx->status) }}</span></h3>
                @endif
              </div>
              @if($tx->status !== 'returned')
                <div class="mt-3">
                  <button data-tx-id="{{ $tx->id }}" class="return-btn w-full bg-red-600 hover:bg-red-500 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">Return</button>
                </div>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="col-span-full text-center text-gray-400">You have no borrowed books at the moment.</div>
      @endforelse
    </div>


    <!-- Load More Button -->
    <div class="text-center">
      <button id="loadMoreBtn" class="bg-white text-gray-900 px-8 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors inline-flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        <span>Load More Books</span>
      </button>
    </div>
  </main>

<x-notification-modal/>

     <script src="{{ asset('js/user.js') }}"></script>
     <script src="{{ asset('js/notification.js') }}"></script>
     
     <script>
      // Lightweight toast for smooth UX (top-right stack)
      function getToastContainer() {
        let c = document.getElementById('toast-container');
        if (!c) {
          c = document.createElement('div');
          c.id = 'toast-container';
          c.className = 'fixed top-4 right-4 z-50 space-y-2 pointer-events-none';
          document.body.appendChild(c);
        }
        return c;
      }

      function showToast(message, type = 'success') {
        const container = getToastContainer();
        const color = type === 'success' ? 'bg-green-600' : (type === 'warn' ? 'bg-yellow-600' : 'bg-red-600');
        const toast = document.createElement('div');
        toast.setAttribute('role', 'status');
        toast.className = `${color} text-white px-4 py-2 rounded shadow-lg text-sm pointer-events-auto opacity-0 translate-x-4 transform transition-all duration-200`;
        toast.textContent = message;
        container.appendChild(toast);

        requestAnimationFrame(() => {
          toast.classList.remove('opacity-0', 'translate-x-4');
          toast.classList.add('opacity-100', 'translate-x-0');
        });

        setTimeout(() => {
          toast.classList.add('opacity-0', 'translate-x-4');
          setTimeout(() => toast.remove(), 200);
        }, 2500);
      }

      document.addEventListener('click', async function(e){
        const btn = e.target.closest('.return-btn');
        if(!btn) return;

        const id = btn.dataset.txId;
        const card = btn.closest('.group');
        const statusChip = card ? card.querySelector('.status-chip') : null;

        if(!confirm('Request a return for this book?')) return;

        const originalHTML = btn.innerHTML;
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
        btn.innerHTML = '<span class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin mr-2 align-middle"></span>Submitting...';

        const tokenEl = document.querySelector('meta[name="csrf-token"]');
        const token = tokenEl ? tokenEl.content : '';

        try {
          const res = await fetch(`/return/${id}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': token,
              'Accept': 'application/json'
            },
            credentials: 'same-origin'
          });

          const data = await res.json().catch(() => ({}));
          if (!res.ok) {
            throw new Error(data.message || 'Failed to process return');
          }

          // Smooth in-place UI update: mark as Return Pending
          if (statusChip) {
            statusChip.textContent = 'Return Pending';
            statusChip.className = 'status-chip py-1 rounded text-md text-yellow-500';
          }
          btn.innerHTML = 'Return Requested';
          btn.classList.remove('bg-red-600', 'hover:bg-red-500');
          btn.classList.add('bg-gray-700');

          showToast(data.message || 'Return request submitted.');
        } catch (err) {
          showToast(err.message || 'Network error', 'error');
          btn.disabled = false;
          btn.classList.remove('opacity-70', 'cursor-not-allowed');
          btn.innerHTML = originalHTML;
        }
      });
    </script>

</body>

</html>
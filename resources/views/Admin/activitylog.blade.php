<x-import>
  <title>Activity Logs - Book Management System</title>
</x-import>

  <div class="d-flex min-vh-100 bg-[#1a1b1e]">

    @include('components.sidebar')

    <x-header>
      <h1 class="text-light mb-0 text-3xl flex items-center gap-2">
        <i class="bi bi-clock-history text-purple-500"></i>
        User Activity Logs
      </h1>
    </x-header>

    <div class="flex-grow-1 p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-[#2c2e33] rounded-xl p-6 hover:shadow-xl hover:border-blue-500/50 transition-all duration-300 hover:-translate-y-1">
          <div class="flex items-center justify-between">
            <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
              <i class="bi bi-activity text-blue-500 text-2xl"></i>
            </div>
            <div class="text-right">
              <p class="text-3xl font-bold text-white mb-1">{{ $totalActivities ?? 0 }}</p>
              <p class="text-sm text-gray-400 font-medium">Total Activities</p>
            </div>
          </div>
        </div>

        <div class="bg-[#2c2e33] rounded-xl p-6 hover:shadow-xl hover:border-emerald-500/50 transition-all duration-300 hover:-translate-y-1">
          <div class="flex items-center justify-between">
            <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center">
              <i class="bi bi-box-arrow-in-right text-emerald-500 text-2xl"></i>
            </div>
            <div class="text-right">
              <p class="text-3xl font-bold text-white mb-1">{{ $userLogins ?? 0 }}</p>
              <p class="text-sm text-gray-400 font-medium">User Logins</p>
            </div>
          </div>
        </div>

        <div class="bg-[#2c2e33] rounded-xl p-6 hover:shadow-xl hover:border-purple-500/50 transition-all duration-300 hover:-translate-y-1">
          <div class="flex items-center justify-between">
            <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center">
              <i class="bi bi-book text-purple-500 text-2xl"></i>
            </div>
            <div class="text-right">
              <p class="text-3xl font-bold text-white mb-1">{{ $bookActions ?? 0 }}</p>
              <p class="text-sm text-gray-400 font-medium">Book Actions</p>
            </div>
          </div>
        </div>

        <div class="bg-[#2c2e33] rounded-xl p-6 hover:shadow-xl hover:border-amber-500/50 transition-all duration-300 hover:-translate-y-1">
          <div class="flex items-center justify-between">
            <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center">
              <i class="bi bi-calendar-check text-amber-500 text-2xl"></i>
            </div>
            <div class="text-right">
              <p class="text-3xl font-bold text-white mb-1">{{ $todaysActivity ?? 0 }}</p>
              <p class="text-sm text-gray-400 font-medium">Today's Activity</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Activity Logs Table -->
      <div class="bg-[#2c2e33] rounded-xl shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-[#373a40]">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
              <i class="bi bi-list-task text-purple-500"></i>
              Recent Activity Logs
            </h3>
            
            <!-- Filter Dropdown -->
            <div class="flex items-center gap-3">
              <label for="activityFilter" class="text-gray-400 text-sm font-medium flex items-center gap-2">
                <i class="bi bi-funnel"></i>
                Filter:
              </label>
              <form method="GET" action="{{ route('activity-log') }}" id="filterForm">
                <select name="filter" id="activityFilter" class="bg-[#1a1b1e] border border-[#373a40] text-white text-sm rounded-lg px-4 py-2 pr-10 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 cursor-pointer appearance-none" onchange="this.form.submit()">
                  <option value="all" {{ ($filter ?? 'all') === 'all' ? 'selected' : '' }}>All Activities</option>
                  <option value="login" {{ ($filter ?? '') === 'login' ? 'selected' : '' }}>Login</option>
                  <option value="logout" {{ ($filter ?? '') === 'logout' ? 'selected' : '' }}>Logout</option>
                  <option value="borrowed" {{ ($filter ?? '') === 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                  <option value="returned" {{ ($filter ?? '') === 'returned' ? 'selected' : '' }}>Returned</option>
                  <option value="update" {{ ($filter ?? '') === 'update' ? 'selected' : '' }}>Update</option>
                  <option value="add" {{ ($filter ?? '') === 'add' ? 'selected' : '' }}>Add</option>
                  <option value="delete" {{ ($filter ?? '') === 'delete' ? 'selected' : '' }}>Delete</option>
                </select>
              </form>
              @if(($filter ?? 'all') !== 'all')
                <a href="{{ route('activity-log') }}" class="text-gray-400 hover:text-red-500 transition-colors" title="Clear filter">
                  <i class="bi bi-x-circle text-xl"></i>
                </a>
              @endif
            </div>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-[#25262b] border-b border-[#373a40]">
              <tr>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">ID</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">User</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Details</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Timestamp</th>
                  <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">Status</th>
                </tr>
            </thead>
            <tbody>
              @forelse($activities as $activity)
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#2c2e33]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">{{ $activity->id }}</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-emerald-500"></i>
                    </div>
                    <div>
                      <p class="text-white font-medium text-sm">{{ $activity->user_name ?? ($activity->user ? $activity->user->firstName . ' ' . $activity->user->lastName : 'System') }}</p>
                      <small class="text-gray-500 text-xs">{{ $activity->role ?? 'N/A' }}</small>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">{{ $activity->details }}</span>
                </td>
                <td class="px-4 py-4">
                  <div class="text-gray-300 text-sm">{{ $activity->created_at ? $activity->created_at->format('M d, Y') : '' }}</div>
                  <small class="text-gray-500 text-xs">{{ $activity->created_at ? $activity->created_at->format('h:i A') : '' }}</small>
                </td>
                <td class="px-4 py-4 text-end">
                  <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-emerald-500/10 text-emerald-500">
                    {{ ucfirst($activity->status ?? 'success') }}
                  </span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-400">No activity logs yet.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="px-6 py-4 border-t border-[#373a40] bg-[#25262b] flex items-center justify-between">
          <div class="text-sm text-gray-400">
            Showing <span class="font-semibold text-white">{{ $activities->firstItem() ?? 0 }}-{{ $activities->lastItem() ?? 0 }}</span> of <span class="font-semibold text-white">{{ $activities->total() ?? 0 }}</span> activities
          </div>

          <div>
            @if($activities->hasPages())
            @php
              $start = max(1, $activities->currentPage() - 2);
              $end = min($activities->lastPage(), $activities->currentPage() + 2);
            @endphp
            <div class="flex items-center gap-2">
              {{-- Previous --}}
              @if($activities->onFirstPage())
                <button class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-400 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                  <i class="bi bi-chevron-left"></i>
                </button>
              @else
                <a href="{{ $activities->previousPageUrl() }}" class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-400 hover:border-purple-500/50 hover:text-purple-500 transition-all">
                  <i class="bi bi-chevron-left"></i>
                </a>
              @endif

              @if($start > 1)
                <a href="{{ $activities->url(1) }}" class="px-4 py-2 rounded-lg {{ $activities->currentPage() == 1 ? 'bg-purple-500 text-white' : 'bg-[#2c2e33] text-gray-400 hover:border-purple-500/50 hover:text-white' }}">1</a>
                @if($start > 2)
                  <span class="px-2 text-gray-400">...</span>
                @endif
              @endif

              @for($i = $start; $i <= $end; $i++)
                <a href="{{ $activities->url($i) }}" class="px-4 py-2 rounded-lg {{ $activities->currentPage() == $i ? 'bg-purple-500 text-white' : 'bg-[#2c2e33] text-gray-400 hover:border-purple-500/50 hover:text-white' }}">{{ $i }}</a>
              @endfor

              @if($end < $activities->lastPage())
                @if($end < $activities->lastPage() - 1)
                  <span class="px-2 text-gray-400">...</span>
                @endif
                <a href="{{ $activities->url($activities->lastPage()) }}" class="px-4 py-2 rounded-lg {{ $activities->currentPage() == $activities->lastPage() ? 'bg-purple-500 text-white' : 'bg-[#2c2e33] text-gray-400 hover:border-purple-500/50 hover:text-white' }}">{{ $activities->lastPage() }}</a>
              @endif

              @if($activities->hasMorePages())
                <a href="{{ $activities->nextPageUrl() }}" class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-400 hover:border-purple-500/50 hover:text-purple-500 transition-all">
                  <i class="bi bi-chevron-right"></i>
                </a>
              @else
                <button class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-400 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                  <i class="bi bi-chevron-right"></i>
                </button>
              @endif
            </div>
            @endif
          </div>

        </div>
      </div>
    </div>
  </div>


<x-import-footer/>
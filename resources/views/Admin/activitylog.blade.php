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
        <div class="bg-[#2c2e33] rounded-lg p-4 hover:border-blue-500/50 transition-all">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-400 text-sm mb-1">Total Activities</p>
              <p class="text-2xl font-bold text-white">12</p>
            </div>
            <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-activity text-blue-500 text-xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-[#2c2e33] rounded-lg p-4 hover:border-emerald-500/50 transition-all">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-400 text-sm mb-1">User Logins</p>
              <p class="text-2xl font-bold text-white">5</p>
            </div>
            <div class="w-12 h-12 bg-emerald-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-box-arrow-in-right text-emerald-500 text-xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-[#2c2e33] rounded-lg p-4 hover:border-purple-500/50 transition-all">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-400 text-sm mb-1">Book Actions</p>
              <p class="text-2xl font-bold text-white">4</p>
            </div>
            <div class="w-12 h-12 bg-purple-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-book text-purple-500 text-xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-[#2c2e33] rounded-lg p-4 hover:border-amber-500/50 transition-all">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-400 text-sm mb-1">Today's Activity</p>
              <p class="text-2xl font-bold text-white">3</p>
            </div>
            <div class="w-12 h-12 bg-amber-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-calendar-check text-amber-500 text-xl"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Activity Logs Table -->
      <div class="bg-[#2c2e33] rounded-xl shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-[#373a40]">
          <h3 class="text-lg font-semibold text-white flex items-center gap-2">
            <i class="bi bi-list-task text-purple-500"></i>
            Recent Activity Logs
          </h3>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-[#25262b] border-b border-[#373a40]">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">ID</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">User</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Action</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Details</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">IP Address</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Timestamp</th>
                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">Status</th>
              </tr>
            </thead>
            <tbody>
              <!-- Activity 1 - User Login -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#2c2e33]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">1</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-emerald-500"></i>
                    </div>
                    <div>
                      <p class="text-white font-medium text-sm">John Doe</p>
                      <small class="text-gray-500 text-xs">Admin</small>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                    <i class="bi bi-box-arrow-in-right me-1.5"></i>Login
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">User logged into the system</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-400 text-sm font-mono">192.168.1.10</span>
                </td>
                <td class="px-4 py-4">
                  <div class="text-gray-300 text-sm">Oct 21, 2025</div>
                  <small class="text-gray-500 text-xs">10:30 AM</small>
                </td>
                <td class="px-4 py-4 text-end">
                  <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-emerald-500/10 text-emerald-500">
                    <i class="bi bi-check-circle-fill me-1"></i>Success
                  </span>
                </td>
              </tr>

            </tbody>
          </table>
        </div>

        <div class="px-6 py-4 border-t border-[#373a40] bg-[#25262b] flex items-center justify-between">
          <div class="text-sm text-gray-400">
            Showing <span class="font-semibold text-white">1-5</span> of <span class="font-semibold text-white">12</span> activities
          </div> 
          <div class="flex items-center gap-2">
            <button class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-400 hover:border-purple-500/50 hover:text-purple-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
              <i class="bi bi-chevron-left"></i>
            </button>
            <button class="px-4 py-2 rounded-lg bg-purple-500 text-white font-semibold">
              1
            </button>
            <button class="px-4 py-2 rounded-lg bg-[#2c2e33] text-gray-400 hover:border-purple-500/50 hover:text-white transition-all">
              2
            </button>
            <button class="px-4 py-2 rounded-lg bg-[#2c2e33] text-gray-400 hover:border-purple-500/50 hover:text-white transition-all">
              3
            </button>
            <button class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-400 hover:border-purple-500/50 hover:text-purple-500 transition-all">
              <i class="bi bi-chevron-right"></i>
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>


<x-import-footer/>
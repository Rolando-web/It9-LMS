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
              <p class="text-2xl font-bold text-white">5</p>
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
              <p class="text-2xl font-bold text-white">3</p>
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
              <p class="text-2xl font-bold text-white">2</p>
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
              <p class="text-2xl font-bold text-white">₱150</p>
            </div>
            <div class="w-12 h-12 bg-amber-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-currency-dollar text-amber-500 text-xl"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-[#2c2e33] rounded-xl shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-[#373a40]">
          <h3 class="text-lg font-semibold text-white flex items-center gap-2">
            <i class="bi bi-list-ul text-orange-500"></i>
            Recent Transactions
          </h3>
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
              <!-- Transaction 1 - Returned -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#2c2e33]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">1</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-blue-500"></i>
                    </div>
                    <span class="text-white font-medium">John Doe</span>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">The Great Gatsby</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Oct 01, 2025</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Oct 15, 2025</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-emerald-500 text-sm">Oct 14, 2025</span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                    <i class="bi bi-check-circle-fill me-1.5"></i>Returned
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">₱0</span>
                </td>
                <td class="px-4 py-4 text-end">
                  <button class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-cyan-500/20 text-cyan-500 hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200"
                          data-bs-toggle="modal" data-bs-target="#bookModal">
                    <i class="bi bi-eye text-base"></i>
                  </button>
                </td>
              </tr>          
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </div>

<x-transaction-modal/>

      </div>
    </div>
  </div>

<x-import-footer/>
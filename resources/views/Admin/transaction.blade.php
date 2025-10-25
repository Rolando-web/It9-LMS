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
      <!-- Stats Summary -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg p-4 hover:border-blue-500/50 transition-all">
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

        <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg p-4 hover:border-emerald-500/50 transition-all">
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

        <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg p-4 hover:border-red-500/50 transition-all">
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

        <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg p-4 hover:border-amber-500/50 transition-all">
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

      <!-- Transactions Table -->
      <div class="bg-[#2c2e33] border border-[#373a40] rounded-xl shadow-xl overflow-hidden">
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

              <!-- Transaction 2 - Overdue -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#272931]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">2</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-purple-500"></i>
                    </div>
                    <span class="text-white font-medium">Jane Smith</span>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">1984</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Sep 20, 2025</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Oct 04, 2025</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-500 text-sm">-</span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-500/10 text-red-500 border border-red-500/20">
                    <i class="bi bi-exclamation-triangle-fill me-1.5"></i>Overdue
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-red-500 text-sm font-semibold">₱100</span>
                </td>
                <td class="px-4 py-4 text-end">
                  <button class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-cyan-500/20 text-cyan-500 hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200"
                          data-bs-toggle="modal" data-bs-target="#bookModal">
                    <i class="bi bi-eye text-base"></i>
                  </button>
                </td>
              </tr>

              <!-- Transaction 3 - Borrowed -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#2c2e33]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">3</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-emerald-500"></i>
                    </div>
                    <span class="text-white font-medium">Mike Johnson</span>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">To Kill a Mockingbird</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Oct 10, 2025</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Oct 24, 2025</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-500 text-sm">-</span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-500 border border-blue-500/20">
                    <i class="bi bi-book-fill me-1.5"></i>Borrowed
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

              <!-- Transaction 4 - Returned -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#272931]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">4</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-amber-500"></i>
                    </div>
                    <span class="text-white font-medium">Sarah Williams</span>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Pride and Prejudice</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Sep 25, 2025</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Oct 09, 2025</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-emerald-500 text-sm">Oct 08, 2025</span>
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

              <!-- Transaction 5 - Overdue -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#2c2e33]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">5</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-pink-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-pink-500"></i>
                    </div>
                    <span class="text-white font-medium">Robert Brown</span>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">The Catcher in the Rye</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Sep 15, 2025</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Sep 29, 2025</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-500 text-sm">-</span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-500/10 text-red-500 border border-red-500/20">
                    <i class="bi bi-exclamation-triangle-fill me-1.5"></i>Overdue
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-red-500 text-sm font-semibold">₱50</span>
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

    <!-- Book Details Modal -->
    <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background-color: #2c2e33; border: 1px solid #373a40;">
          <div class="modal-header border-0" style="border-bottom: 1px solid #373a40 !important;">
            <h5 class="modal-title text-white font-semibold flex items-center gap-2" id="bookModalLabel">
              <i class="bi bi-info-circle text-cyan-500"></i>
              Transaction Details
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row g-4">
              <div class="col-md-3 text-center">
                <img src="../image/book-cover.jpg" alt="Book Cover" class="img-fluid rounded-lg border" style="height: 160px; border-color: #373a40;">
              </div>
              <div class="col-md-9">
                <div class="space-y-3">
                  <div class="flex items-start gap-3">
                    <i class="bi bi-book text-blue-500 mt-1"></i>
                    <div>
                      <p class="text-gray-400 text-xs mb-1">Book Title</p>
                      <p class="text-white font-semibold">The Great Gatsby</p>
                    </div>
                  </div>
                  <div class="flex items-start gap-3">
                    <i class="bi bi-person text-purple-500 mt-1"></i>
                    <div>
                      <p class="text-gray-400 text-xs mb-1">Borrowed By</p>
                      <p class="text-white font-semibold">John Doe</p>
                    </div>
                  </div>
                  <div class="flex items-start gap-3">
                    <i class="bi bi-pen text-emerald-500 mt-1"></i>
                    <div>
                      <p class="text-gray-400 text-xs mb-1">Author</p>
                      <p class="text-white font-semibold">F. Scott Fitzgerald</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr class="my-4" style="border-color: #373a40;">
            <div class="row g-3">
              <div class="col-md-4">
                <div class="bg-[#1a1b1e] rounded-lg p-3 border" style="border-color: #373a40;">
                  <p class="text-gray-400 text-xs mb-1">Transaction ID</p>
                  <p class="text-white font-bold text-lg">001</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="bg-[#1a1b1e] rounded-lg p-3 border" style="border-color: #373a40;">
                  <p class="text-gray-400 text-xs mb-1">Borrow Date</p>
                  <p class="text-white font-bold text-lg">Oct 01, 2025</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="bg-[#1a1b1e] rounded-lg p-3 border" style="border-color: #373a40;">
                  <p class="text-gray-400 text-xs mb-1">Due Date</p>
                  <p class="text-white font-bold text-lg">Oct 15, 2025</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="bg-emerald-500/10 rounded-lg p-3 border border-emerald-500/20">
                  <p class="text-emerald-500 text-xs mb-1">Return Date</p>
                  <p class="text-emerald-500 font-bold text-lg">Oct 14, 2025</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="bg-blue-500/10 rounded-lg p-3 border border-blue-500/20">
                  <p class="text-blue-500 text-xs mb-1">Status</p>
                  <p class="text-blue-500 font-bold text-lg">Returned</p>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer border-0" style="border-top: 1px solid #373a40 !important;">
            <button type="button" class="btn btn-outline-light rounded-lg" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-2"></i>Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

<x-import-footer/>
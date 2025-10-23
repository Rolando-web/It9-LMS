<x-import>
  <title>User Management - Book Management System</title>
</x-import>

  <div class="d-flex min-vh-100 bg-[#1a1b1e]">

 @include('components.sidebar')
    <x-header>
      <h1 class="text-light mb-0 text-3xl flex items-center gap-2">
        <i class="bi bi-people-fill text-indigo-500"></i>
        User Management
      </h1>
    </x-header>

    <div class="flex-grow-1 p-6">
      <div class="mb-4">
        <button
          type="button"
          class="inline-flex items-center px-4 py-2.5 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-indigo-500/50"
          data-bs-toggle="modal" data-bs-target="#addUserModal">
          <i class="bi bi-plus-circle me-2"></i>
          Add New User
        </button>
      </div>

      <!-- User Stats -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg p-4 hover:border-indigo-500/50 transition-all">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-400 text-sm mb-1">Total Users</p>
              <p class="text-2xl font-bold text-white">8</p>
            </div>
            <div class="w-12 h-12 bg-indigo-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-people text-indigo-500 text-xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg p-4 hover:border-emerald-500/50 transition-all">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-400 text-sm mb-1">Active Users</p>
              <p class="text-2xl font-bold text-white">6</p>
            </div>
            <div class="w-12 h-12 bg-emerald-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-person-check text-emerald-500 text-xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg p-4 hover:border-purple-500/50 transition-all">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-400 text-sm mb-1">Admins</p>
              <p class="text-2xl font-bold text-white">2</p>
            </div>
            <div class="w-12 h-12 bg-purple-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-shield-check text-purple-500 text-xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg p-4 hover:border-blue-500/50 transition-all">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-400 text-sm mb-1">Librarians</p>
              <p class="text-2xl font-bold text-white">2</p>
            </div>
            <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center">
              <i class="bi bi-person-badge text-blue-500 text-xl"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Users Table -->
      <div class="bg-[#2c2e33] border border-[#373a40] rounded-xl shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-[#373a40]">
          <h3 class="text-lg font-semibold text-white flex items-center gap-2">
            <i class="bi bi-list-ul text-indigo-500"></i>
            All Users
          </h3>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-[#25262b] border-b border-[#373a40]">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">ID</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">User</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Contact</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Email</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Role</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Status</th>
                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- User 1 - Admin -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#2c2e33]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">1</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-indigo-500"></i>
                    </div>
                    <div>
                      <p class="text-white font-medium text-sm">Rolando Luayon</p>
                      <small class="text-gray-500 text-xs">Joined Oct 2024</small>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">09812565123</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">lalo@gmail.com</span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-purple-500/10 text-purple-500 border border-purple-500/20">
                    <i class="bi bi-shield-fill-check me-1.5"></i>Admin
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-emerald-500/10 text-emerald-500">
                    <i class="bi bi-circle-fill me-1.5" style="font-size: 6px;"></i>Active
                  </span>
                </td>
                <td class="px-4 py-4 text-end">
                  <div class="flex gap-2 justify-end">
                    <button class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-cyan-500/20 text-cyan-500 hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200" 
                            title="Edit User"
                            data-bs-toggle="modal"
                            data-bs-target="#editUserModal">
                      <i class="bi bi-pencil-square text-base"></i>
                    </button>
                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-red-500/20 text-red-500 hover:bg-red-500/10 hover:border-red-500/40 transition-all duration-200" 
                              title="Delete User">
                        <i class="bi bi-trash text-base"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>

              <!-- User 2 - Librarian -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#272931]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">2</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-blue-500"></i>
                    </div>
                    <div>
                      <p class="text-white font-medium text-sm">Jane Smith</p>
                      <small class="text-gray-500 text-xs">Joined Oct 2024</small>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">09123456789</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">jane.smith@library.com</span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-500 border border-blue-500/20">
                    <i class="bi bi-person-badge me-1.5"></i>Librarian
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-emerald-500/10 text-emerald-500">
                    <i class="bi bi-circle-fill me-1.5" style="font-size: 6px;"></i>Active
                  </span>
                </td>
                <td class="px-4 py-4 text-end">
                  <div class="flex gap-2 justify-end">
                    <button class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-cyan-500/20 text-cyan-500 hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200" 
                            title="Edit User">
                      <i class="bi bi-pencil-square text-base"></i>
                    </button>
                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-red-500/20 text-red-500 hover:bg-red-500/10 hover:border-red-500/40 transition-all duration-200" 
                              title="Delete User">
                        <i class="bi bi-trash text-base"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>

              <!-- User 3 - Student -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#2c2e33]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">3</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-emerald-500"></i>
                    </div>
                    <div>
                      <p class="text-white font-medium text-sm">John Doe</p>
                      <small class="text-gray-500 text-xs">Joined Oct 2024</small>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">09234567890</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">john.doe@student.com</span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                    <i class="bi bi-book-half me-1.5"></i>Student
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-emerald-500/10 text-emerald-500">
                    <i class="bi bi-circle-fill me-1.5" style="font-size: 6px;"></i>Active
                  </span>
                </td>
                <td class="px-4 py-4 text-end">
                  <div class="flex gap-2 justify-end">
                    <button class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-cyan-500/20 text-cyan-500 hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200" 
                            title="Edit User">
                      <i class="bi bi-pencil-square text-base"></i>
                    </button>
                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-red-500/20 text-red-500 hover:bg-red-500/10 hover:border-red-500/40 transition-all duration-200" 
                              title="Delete User">
                        <i class="bi bi-trash text-base"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>

              <!-- User 4 - Admin -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#272931]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">4</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-purple-500"></i>
                    </div>
                    <div>
                      <p class="text-white font-medium text-sm">Sarah Williams</p>
                      <small class="text-gray-500 text-xs">Joined Sep 2024</small>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">09345678901</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">sarah.w@library.com</span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-purple-500/10 text-purple-500 border border-purple-500/20">
                    <i class="bi bi-shield-fill-check me-1.5"></i>Admin
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-emerald-500/10 text-emerald-500">
                    <i class="bi bi-circle-fill me-1.5" style="font-size: 6px;"></i>Active
                  </span>
                </td>
                <td class="px-4 py-4 text-end">
                  <div class="flex gap-2 justify-end">
                    <button class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-cyan-500/20 text-cyan-500 hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200" 
                            title="Edit User">
                      <i class="bi bi-pencil-square text-base"></i>
                    </button>
                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-red-500/20 text-red-500 hover:bg-red-500/10 hover:border-red-500/40 transition-all duration-200" 
                              title="Delete User">
                        <i class="bi bi-trash text-base"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>

              <!-- User 5 - Librarian -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#2c2e33]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">5</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-cyan-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-cyan-500"></i>
                    </div>
                    <div>
                      <p class="text-white font-medium text-sm">Michael Brown</p>
                      <small class="text-gray-500 text-xs">Joined Oct 2024</small>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">09456789012</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">michael.b@library.com</span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-500 border border-blue-500/20">
                    <i class="bi bi-person-badge me-1.5"></i>Librarian
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-amber-500/10 text-amber-500">
                    <i class="bi bi-circle-fill me-1.5" style="font-size: 6px;"></i>Inactive
                  </span>
                </td>
                <td class="px-4 py-4 text-end">
                  <div class="flex gap-2 justify-end">
                    <button class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-cyan-500/20 text-cyan-500 hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200" 
                            title="Edit User">
                      <i class="bi bi-pencil-square text-base"></i>
                    </button>
                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent border border-red-500/20 text-red-500 hover:bg-red-500/10 hover:border-red-500/40 transition-all duration-200" 
                              title="Delete User">
                        <i class="bi bi-trash text-base"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-[#373a40] bg-[#25262b] flex items-center justify-between">
          <div class="text-sm text-gray-400">
            Showing <span class="font-semibold text-white">1-5</span> of <span class="font-semibold text-white">8</span> users
          </div>
          
          <div class="flex items-center gap-2">
            <!-- Previous Button -->
            <button class="px-3 py-2 rounded-lg bg-[#2c2e33] border border-[#373a40] text-gray-400 hover:border-indigo-500/50 hover:text-indigo-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
              <i class="bi bi-chevron-left"></i>
            </button>
            
            <!-- Page Numbers -->
            <button class="px-4 py-2 rounded-lg bg-indigo-500 text-white font-semibold">
              1
            </button>
            <button class="px-4 py-2 rounded-lg bg-[#2c2e33] border border-[#373a40] text-gray-400 hover:border-indigo-500/50 hover:text-white transition-all">
              2
            </button>
            
            <!-- Next Button -->
            <button class="px-3 py-2 rounded-lg bg-[#2c2e33] border border-[#373a40] text-gray-400 hover:border-indigo-500/50 hover:text-indigo-500 transition-all">
              <i class="bi bi-chevron-right"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/admin.js') }}"></script>
  <script src="{{ asset('js/active.js') }}"></script>
  <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
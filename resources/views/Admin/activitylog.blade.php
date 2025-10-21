<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Activity Logs - Book Management System</title>
  <meta name="description" content="Admin dashboard for book management system with dark theme interface">
  <link rel="stylesheet" href="{{asset('css/style.css')}}" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../image/willan.jpg" type="image/jpeg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            dark: {
              primary: '#1a1b1e',
              secondary: '#25262b',
              card: '#2c2e33',
              border: '#373a40',
            }
          }
        }
      }
    }
  </script>
</head>

<body class="bg-[#1a1b1e]">
  <div class="d-flex min-vh-100 bg-[#1a1b1e]">

    @include('components.sidebar')
    <x-header>
      <h1 class="text-light mb-0 text-3xl flex items-center gap-2">
        <i class="bi bi-clock-history text-purple-500"></i>
        User Activity Logs
      </h1>
    </x-header>

    <div class="flex-grow-1 p-6">
      <!-- Activity Stats -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg p-4 hover:border-blue-500/50 transition-all">
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

        <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg p-4 hover:border-emerald-500/50 transition-all">
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

        <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg p-4 hover:border-purple-500/50 transition-all">
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

        <div class="bg-[#2c2e33] border border-[#373a40] rounded-lg p-4 hover:border-amber-500/50 transition-all">
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
      <div class="bg-[#2c2e33] border border-[#373a40] rounded-xl shadow-xl overflow-hidden">
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

              <!-- Activity 2 - Book Added -->
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
                      <small class="text-gray-500 text-xs">Librarian</small>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-500 border border-blue-500/20">
                    <i class="bi bi-plus-circle me-1.5"></i>Add Book
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Added "The Great Gatsby" to library</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-400 text-sm font-mono">192.168.1.15</span>
                </td>
                <td class="px-4 py-4">
                  <div class="text-gray-300 text-sm">Oct 21, 2025</div>
                  <small class="text-gray-500 text-xs">09:15 AM</small>
                </td>
                <td class="px-4 py-4 text-end">
                  <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-emerald-500/10 text-emerald-500">
                    <i class="bi bi-check-circle-fill me-1"></i>Success
                  </span>
                </td>
              </tr>

              <!-- Activity 3 - Book Borrowed -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#2c2e33]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">3</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-purple-500"></i>
                    </div>
                    <div>
                      <p class="text-white font-medium text-sm">Mike Johnson</p>
                      <small class="text-gray-500 text-xs">Student</small>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-purple-500/10 text-purple-500 border border-purple-500/20">
                    <i class="bi bi-book me-1.5"></i>Borrow
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Borrowed "1984" by George Orwell</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-400 text-sm font-mono">192.168.1.22</span>
                </td>
                <td class="px-4 py-4">
                  <div class="text-gray-300 text-sm">Oct 20, 2025</div>
                  <small class="text-gray-500 text-xs">03:45 PM</small>
                </td>
                <td class="px-4 py-4 text-end">
                  <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-emerald-500/10 text-emerald-500">
                    <i class="bi bi-check-circle-fill me-1"></i>Success
                  </span>
                </td>
              </tr>

              <!-- Activity 4 - User Logout -->
              <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 bg-[#272931]">
                <td class="px-4 py-4">
                  <span class="text-white font-semibold text-base">4</span>
                </td>
                <td class="px-4 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-500/10 rounded-full flex items-center justify-center">
                      <i class="bi bi-person-fill text-amber-500"></i>
                    </div>
                    <div>
                      <p class="text-white font-medium text-sm">Sarah Williams</p>
                      <small class="text-gray-500 text-xs">Librarian</small>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-500/10 text-amber-500 border border-amber-500/20">
                    <i class="bi bi-box-arrow-right me-1.5"></i>Logout
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">User logged out from the system</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-400 text-sm font-mono">192.168.1.18</span>
                </td>
                <td class="px-4 py-4">
                  <div class="text-gray-300 text-sm">Oct 20, 2025</div>
                  <small class="text-gray-500 text-xs">05:30 PM</small>
                </td>
                <td class="px-4 py-4 text-end">
                  <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-emerald-500/10 text-emerald-500">
                    <i class="bi bi-check-circle-fill me-1"></i>Success
                  </span>
                </td>
              </tr>

              <!-- Activity 5 - Book Returned -->
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
                      <p class="text-white font-medium text-sm">Robert Brown</p>
                      <small class="text-gray-500 text-xs">Student</small>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-4">
                  <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-cyan-500/10 text-cyan-500 border border-cyan-500/20">
                    <i class="bi bi-arrow-return-left me-1.5"></i>Return
                  </span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-300 text-sm">Returned "Pride and Prejudice"</span>
                </td>
                <td class="px-4 py-4">
                  <span class="text-gray-400 text-sm font-mono">192.168.1.25</span>
                </td>
                <td class="px-4 py-4">
                  <div class="text-gray-300 text-sm">Oct 19, 2025</div>
                  <small class="text-gray-500 text-xs">11:20 AM</small>
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

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-[#373a40] bg-[#25262b] flex items-center justify-between">
          <div class="text-sm text-gray-400">
            Showing <span class="font-semibold text-white">1-5</span> of <span class="font-semibold text-white">12</span> activities
          </div>
          
          <div class="flex items-center gap-2">
            <!-- Previous Button -->
            <button class="px-3 py-2 rounded-lg bg-[#2c2e33] border border-[#373a40] text-gray-400 hover:border-purple-500/50 hover:text-purple-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
              <i class="bi bi-chevron-left"></i>
            </button>
            
            <!-- Page Numbers -->
            <button class="px-4 py-2 rounded-lg bg-purple-500 text-white font-semibold">
              1
            </button>
            <button class="px-4 py-2 rounded-lg bg-[#2c2e33] border border-[#373a40] text-gray-400 hover:border-purple-500/50 hover:text-white transition-all">
              2
            </button>
            <button class="px-4 py-2 rounded-lg bg-[#2c2e33] border border-[#373a40] text-gray-400 hover:border-purple-500/50 hover:text-white transition-all">
              3
            </button>
            
            <!-- Next Button -->
            <button class="px-3 py-2 rounded-lg bg-[#2c2e33] border border-[#373a40] text-gray-400 hover:border-purple-500/50 hover:text-purple-500 transition-all">
              <i class="bi bi-chevron-right"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!-- Bootstrap JS for mobile sidebar toggle -->
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
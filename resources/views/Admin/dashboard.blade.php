<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Management System - Admin Control</title>
  <meta name="description" content="Admin dashboard for book management system with dark theme interface">
  <link rel="stylesheet" href="{{asset('css/style.css')}}" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../image/willan.jpg" type="image/jpeg">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
  <div class="d-flex min-vh-100  bg-[#2c2d2c]">

    @include('components.sidebar')
    <x-header>
  <h1 class="text-light mb-0 text-3xl">
       Dashboard
      </h1>
    </x-header>

        <!-- Dashboard Content -->
        <div class="px-8 py-6">

          <!-- Stats Cards -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card bg-[#404040] rounded-xl shadow-sm p-6">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                  </svg>
                </div>
                <span class="badge px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">2%</span>
              </div>
              <p class="text-2xl font-bold text-white mb-1">2</p>
              <p class="text-sm text-gray-500 font-medium">Total Books</p>
            </div>

            <div class="stat-card bg-[#404040] rounded-xl shadow-sm  p-6">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                  </svg>
                </div>
                <span class="badge px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">2%</span>
              </div>
              <p class="text-2xl font-bold text-white mb-1">2</p>
              <p class="text-sm text-gray-500 font-medium">Categories</p>
            </div>

            <div class="stat-card bg-[#404040] rounded-xl shadow-sm  p-6">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                  </svg>
                </div>
                <span class="badge px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">2%</span>
              </div>
              <p class="text-2xl font-bold text-white mb-1">2</p>
              <p class="text-sm text-gray-500 font-medium">Active Users</p>
            </div>

            <div class="stat-card bg-[#404040] rounded-xl shadow-sm p-6">
              <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                  </svg>
                </div>
                <span class="badge px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">2%</span>
              </div>
              <p class="text-2xl font-bold text-white mb-1">2</p>
              <p class="text-sm text-gray-500 font-medium">Daily log Activities</p>
            </div>
          </div>

          <!-- Books Table -->
          <div class="bg-[#404040] rounded-xl shadow-sm ">
            <div class="px-6 py-4 border-b border-gray-200 border-opacity-50">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">Recently Books Added</h3>

              </div>
            </div>

            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-[#404040] border-b border-gray-200 border-opacity-20 text-white">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Book</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Copies</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Creted At</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 divide-opacity-20">
                    <tr class="table-row hover:bg-gray-700">
                      <td class="px-6 py-3">
                        <div class="flex items-center space-x-3">
                          <div class="w-12 h-16  rounded flex-shrink-0 flex items-center justify-center text-white text-xs font-bold">
                            <img src="#"
                              alt="jayr"
                              class="rounded"
                              width="80" height="80" />
                          </div>
                          <div>
                            <p class="text-sm font-semibold text-white">jayr</p>
                            <p class="text-xs text-white opacity-30">002-222</p>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Adventure</span>
                      </td>
                      <td class="px-6 py-4 text-sm text-white">Jayr</td>
                      <td class="px-6 py-4 text-sm text-white">12</td>
                      <td class="px-6 py-4 text-sm text-white">2004-18-12</td>
                      <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                          <button class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg editBtn" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                          </button>
                        </div>
                      </td>
                    </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </main>


      <!-- Bootstrap JS Bundle -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <script src="{{ asset('js/admin.js') }}"></script>
        <script src="{{ asset('js/active.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
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


    <main class="max-w-full mx-auto px-6 py-8">
      <div class="bg-[#25262b] rounded-lg shadow px-6 py-6">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h2 class="text-2xl font-medium text-white">Pending Borrow Requests</h2>
            <p class="text-sm text-gray-400">Review and take action on borrow requests.</p>
          </div>
          <div class="text-sm text-gray-400">Total: <span class="font-semibold text-white">3</span></div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full table-auto">
            <thead>
              <tr class="text-left text-sm text-gray-300 border-b border-gray-800">
                <th class="py-3 px-4">Transaction ID</th>
                <th class="py-3 px-4">User ID</th>
                <th class="py-3 px-4">Book ID</th>
                <th class="py-3 px-4">Book Title</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 px-4">Action</th>
              </tr>
            </thead>
            <tbody class="text-sm text-white">
              <tr class="border-b border-gray-800 hover:bg-[#2d2f33]">
                <td class="py-4 px-4 font-medium">#1024</td>
                <td class="py-4 px-4">U-0012</td>
                <td class="py-4 px-4">B-2045</td>
                <td class="py-4 px-4">Introduction to Algorithms</td>
                <td class="py-4 px-4"><span class="px-2 py-1 rounded text-xs bg-yellow-600">Pending</span></td>
                <td class="py-4 px-4">
                  <div class="flex gap-2">
                    <button class="bg-green-600 hover:bg-green-500 text-white px-3 py-1 rounded text-sm">Approve</button>
                    <button class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded text-sm">Reject</button>
                  </div>
                </td>
              </tr>

              <tr class="border-b border-gray-800 hover:bg-[#2d2f33]">
                <td class="py-4 px-4 font-medium">#1025</td>
                <td class="py-4 px-4">U-0034</td>
                <td class="py-4 px-4">B-1050</td>
                <td class="py-4 px-4">Design Patterns: Elements of Reusable Object-Oriented Software</td>
                <td class="py-4 px-4"><span class="px-2 py-1 rounded text-xs bg-yellow-600">Pending</span></td>
                <td class="py-4 px-4">
                  <div class="flex gap-2">
                    <button class="bg-green-600 hover:bg-green-500 text-white px-3 py-1 rounded text-sm">Approve</button>
                    <button class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded text-sm">Reject</button>
                  </div>
                </td>
              </tr>

              <tr class="border-b border-gray-800 hover:bg-[#2d2f33]">
                <td class="py-4 px-4 font-medium">#1026</td>
                <td class="py-4 px-4">U-0078</td>
                <td class="py-4 px-4">B-3301</td>
                <td class="py-4 px-4">Clean Code: A Handbook of Agile Software Craftsmanship</td>
                <td class="py-4 px-4"><span class="px-2 py-1 rounded text-xs bg-yellow-600">Pending</span></td>
                <td class="py-4 px-4">
                  <div class="flex gap-2">
                    <button class="bg-green-600 hover:bg-green-500 text-white px-3 py-1 rounded text-sm">Approve</button>
                    <button class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded text-sm">Reject</button>
                  </div>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
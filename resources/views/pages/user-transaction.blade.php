<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Transaction</title>
  <link rel="stylesheet" href="../src/input.css" />
  <link rel="stylesheet" href="../src/output.css" />
  <link rel="icon" href="../image/willan.jpg" type="image/jpeg">
  <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="min-h-screen bg-[#101929]">

 @include('layouts.partials.header')



  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-6 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="bg-[#1E2939] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium ">Active Borrowings</h3>
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
          </svg>
        </div>
        <div class="text-3xl font-bold mb-2">1</div>
        <div class="text-sm opacity-80">Currently borrowed books</div>
      </div>

      <!-- Overdue Books -->
      <div class="bg-[#1E2939] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-white">Overdue Books</h3>
          <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
        </div>
        <div class="flex items-center space-x-2 mb-2">
          <div class="text-3xl font-bold">1</div>
        </div>
        <div class="text-sm text-white">Books past due date</div>
      </div>

      <!-- Outstanding Fees -->
      <div class="bg-[#1E2939] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-white">Outstanding Fees</h3>
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
        </div>
{{-- 
    get user overduefees --}}


      </div>

      <!-- Total Transactions -->
      <div class="bg-[#1E2939] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-white">Total Transactions</h3>
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <div class="text-3xl font-bold mb-2">1</div>
        <div class="text-sm text-white">All-time borrowings</div>
      </div>
    </div>

    <!-- Active Borrowings Table -->
    <div class="bg-[#1E2939] rounded-xl p-6 mb-8">
      <div class="flex items-center space-x-2 mb-6">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
        <h2 class="text-xl font-semibold text-white opacity-70">Active Borrowings 1</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-gray-200 border-opacity-20">
              <th class="text-left py-3 px-4 font-medium text-white">Transaction ID</th>
              <th class="text-left py-3 px-4 font-medium text-white">Book ID</th>
              <th class="text-left py-3 px-4 font-medium text-white">Title</th>
              <th class="text-left py-3 px-4 font-medium text-white">Author</th>
              <th class="text-left py-3 px-4 font-medium text-white">Borrowed Date</th>
              <th class="text-left py-3 px-4 font-medium text-white">Due Date</th>
              <th class="text-left py-3 px-4 font-medium text-white">Status</th>
              <th class="text-left py-3 px-4 font-medium text-white">Fee</th>
            </tr>
          </thead>
          <tbody class="text-white">
          
          </tbody>
        </table>
      </div>
    </div>

    <!-- Transaction History -->
    <div class="bg-[#1E2939] rounded-xl p-6">
      <div class="flex items-center space-x-2 mb-6">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h2 class="text-xl font-semibold text-white opacity-70">Transaction History 1</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-gray-200 border-opacity-20">
              <th class="text-left py-3 px-4 font-medium text-white">Transaction ID</th>
              <th class="text-left py-3 px-4 font-medium text-white">Book ID</th>
              <th class="text-left py-3 px-4 font-medium text-white">Title</th>
              <th class="text-left py-3 px-4 font-medium text-white">Author</th>
              <th class="text-left py-3 px-4 font-medium text-white">Borrowed Date</th>
              <th class="text-left py-3 px-4 font-medium text-white">Return Date</th>
              <th class="text-left py-3 px-4 font-medium text-white">Final Fee</th>
            </tr>
          </thead>
          <tbody class="text-white">
              <tr class="border-b border-gray-100 hover:bg-[#101929] border-opacity-10">
                <td class="py-4 px-4 font-medium">wewtd>
                <td class="py-4 px-4">11</td>
                <td class="py-4 px-4 font-medium">wew</td>
                <td class="py-4 px-4">11</td>
                <td class="py-4 px-4">2004</td>
                <td class="py-4 px-4">N/A</td>
                <td class="py-4 px-4 font-medium text-[#e24545] ">
                  50
                </td>
              </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
     <script src="{{ asset('js/user.js') }}"></script>
</body>

</html>
  <!-- borrow-modal -->
  <!-- Borrow Modal -->
  <div id="borrowModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-gray-800 rounded-xl p-8 max-w-md w-full mx-4">
      <div class="text-center mb-6">
        <div class="w-16 h-16 bg-green-600 bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-white mb-2">Borrow Book</h3>
        <p class="text-gray-400 mb-4">You're about to borrow:</p>
        <p id="borrowBookTitle" class="text-white font-medium text-lg mb-2"></p>
        <p id="borrowBookAuthor" class="text-gray-400 mb-6"></p>
      </div>

      <div class="space-y-4 mb-6">
        <div>
          <label class="block text-gray-400 text-sm mb-2">Borrow Duration</label>
          <select id="borrowDuration" class="w-full bg-gray-700 text-white px-3 py-2 rounded-lg border border-gray-600 focus:border-gray-400 focus:outline-none">
            <option value="3" selected>3 days</option>
            <option value="7">7 days</option>
            <option value="14">14 days</option>
            <option value="21">21 days</option>
            <option value="30">30 days</option>
          </select>
        </div>
        <div>
          <label class="block text-gray-400 text-sm mb-2">Return Date</label>
          <input type="date" id="returnDate" class="w-full bg-gray-700 text-white px-3 py-2 rounded-lg border border-gray-600 focus:border-gray-400 focus:outline-none" readonly>
        </div>
      </div>

      <div class="flex space-x-4">
        <button id="cancelBorrow" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-3 px-4 rounded-lg font-medium transition-colors">
          Cancel
        </button>
        <button id="confirmBorrow" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition-colors">
          Confirm Borrow
        </button>
      </div>
    </div>
  </div>

  <!-- Success Modal -->
  <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex hidden items-center justify-center z-5">
    <div class="bg-gray-800 rounded-xl p-8 max-w-md w-full mx-4">
      <div class="text-center">
        <div class="w-16 h-16 bg-green-600 bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-white mb-2">Book Borrowed Successfully!</h3>
        <p class="text-gray-400 mb-6">You can find your borrowed books in your account dashboard.</p>
        <button onclick="" id="closeSuccess" class="bg-white text-gray-900 px-6 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors">
          Close
        </button>
      </div>
    </div>
  </div>

  <div id="errorModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white text-red-500 p-6 rounded-lg max-w-md text-center flex justify-center flex-col items-center">
      <h3 class="text-xl font-bold mb-4">Error</h3>
      <p id="errorMessage"></p>
      <svg class="w-10 h-10 mt-0.5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
      <button onclick="document.getElementById('errorModal').classList.add('hidden')" class="mt-4 bg-red-600 text-white px-4 py-2 rounded">Close</button>
    </div>
  </div>

<!-- Payment Modal -->
<div id="payModal" class="fixed inset-0 z-50 hidden">
  <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
  <div class="relative w-full max-w-md mx-auto mt-32 bg-[#1E2939] rounded-xl shadow-xl border border-gray-700 overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-700">
      <h3 class="text-white text-lg font-semibold flex items-center gap-2">
        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
        Pay Book Fee
      </h3>
      <button id="closePayModal" class="text-gray-400 hover:text-white transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="px-5 py-4 space-y-5">
      <div>
        <p class="text-sm text-gray-400 mb-1">Transaction ID</p>
        <p id="payTxId" class="text-white font-medium">—</p>
      </div>
      <div>
        <p class="text-sm text-gray-400 mb-1">Amount Due</p>
        <p class="text-2xl font-bold text-emerald-400">₱<span id="payAmount">0.00</span></p>
      </div>
      <div>
        <p class="text-sm text-gray-400 mb-2">Select Payment Method</p>
        <div class="grid grid-cols-2 gap-3">
          <button type="button" data-method="gcash" class="pay-method-btn group border border-gray-600 hover:border-emerald-500 rounded-lg p-4 flex flex-col items-center gap-2 transition-colors">
            <img src="/image/gcash.png" onerror="this.style.display='none'" alt="GCash" class="w-10 h-10 object-contain" />
            <span class="text-xs text-gray-300 group-hover:text-white font-medium">GCash</span>
          </button>
          <button type="button" data-method="paymaya" class="pay-method-btn group border border-gray-600 hover:border-emerald-500 rounded-lg p-4 flex flex-col items-center gap-2 transition-colors">
            <img src="/image/paymaya.png" onerror="this.style.display='none'" alt="PayMaya" class="w-10 h-10 object-contain" />
            <span class="text-xs text-gray-300 group-hover:text-white font-medium">PayMaya</span>
          </button>
        </div>
        <p id="methodHint" class="mt-3 text-xs text-gray-500">Choose a method to continue.</p>
      </div>
      <div class="bg-gray-800/60 rounded-lg p-3 text-xs text-gray-400 leading-relaxed">
        This is a demo payment interface. Selecting a method and clicking Confirm will simulate a successful payment and close this modal.
      </div>
    </div>
    <div class="px-5 py-4 border-t border-gray-700 flex items-center justify-end gap-3 bg-gray-800/40">
      <button id="cancelPay" class="px-4 py-2 rounded-lg text-sm font-medium bg-gray-700 hover:bg-gray-600 text-gray-200 transition-colors">Cancel</button>
      <button id="confirmPay" disabled class="px-4 py-2 rounded-lg text-sm font-semibold bg-emerald-600/60 text-white cursor-not-allowed transition-colors">Confirm Payment</button>
    </div>
  </div>
</div>

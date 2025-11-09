<!-- Reject Return Modal -->
<div class="modal fade" id="rejectReturnModal" tabindex="-1" aria-labelledby="rejectReturnModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-[#2c2e33] border-[#373a40]">
      <div class="modal-header border-b border-[#373a40]">
        <h5 class="modal-title text-white flex items-center gap-2" id="rejectReturnModalLabel">
          <i class="bi bi-x-circle text-red-500"></i>
          Reject Book Return
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="rejectReturnForm">
          <input type="hidden" id="rejectTransactionId" name="transaction_id">
          
          <div class="mb-4">
            <label for="rejectReason" class="form-label text-gray-300 text-sm font-medium">Rejection Reason</label>
            <textarea 
              class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-red-500 focus:ring-red-500" 
              id="rejectReason" 
              name="reason" 
              rows="3" 
              placeholder="Describe the damage or reason for rejection..."
              required></textarea>
            <small class="text-gray-400">Explain why the book is being rejected</small>
          </div>

          <div class="mb-4">
            <label for="damageFee" class="form-label text-gray-300 text-sm font-medium">Damage Fee (₱)</label>
            <input 
              type="number" 
              class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-red-500 focus:ring-red-500" 
              id="damageFee" 
              name="damage_fee" 
              min="0" 
              step="0.01"
              value="50.00"
              placeholder="Enter damage fee"
              required>
            <small class="text-gray-400">Standard damage fee is ₱50.00</small>
          </div>

          <div class="alert alert-warning bg-amber-500/10 border-amber-500/20 text-amber-500 mb-0" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            This will charge the user for book damage and mark the transaction as "damaged".
          </div>
        </form>
      </div>
      <div class="modal-footer border-t border-[#373a40]">
        <button type="button" class="btn btn-secondary bg-[#373a40] border-[#373a40] hover:bg-[#25262b]" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i>Cancel
        </button>
        <button type="button" class="btn btn-danger bg-red-500 border-red-500 hover:bg-red-600" id="confirmRejectBtn">
          <i class="bi bi-check-circle me-1"></i>Confirm Rejection
        </button>
      </div>
    </div>
  </div>
</div>

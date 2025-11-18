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
                <img id="modalBookImage" src="" alt="Book Cover" class="img-fluid rounded-lg border" style="height: 160px; border-color: #373a40;">
              </div>
              <div class="col-md-9">
                <div class="space-y-3">
                  <div class="flex items-start gap-3">
                    <i class="bi bi-book text-blue-500 mt-1"></i>
                    <div>
                      <p class="text-gray-400 text-xs mb-1">Book Title</p>
                      <p id="modalBookTitle" class="text-white font-semibold">--</p>
                    </div>
                  </div>
                  <div class="flex items-start gap-3">
                    <i class="bi bi-person text-purple-500 mt-1"></i>
                    <div>
                      <p class="text-gray-400 text-xs mb-1">Borrowed By</p>
                      <p id="modalUserName" class="text-white font-semibold">--</p>
                    </div>
                  </div>
                  <div class="flex items-start gap-3">
                    <i class="bi bi-pen text-emerald-500 mt-1"></i>
                    <div>
                      <p class="text-gray-400 text-xs mb-1">Author</p>
                      <p id="modalBookAuthor" class="text-white font-semibold">--</p>
                    </div>
                  </div>
                </div>

                <!-- Damage Return Modal -->
                <div class="modal fade" id="damageReturnModal" tabindex="-1" aria-labelledby="damageReturnModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background-color: #2c2e33; border: 1px solid #373a40;">
                      <div class="modal-header border-0" style="border-bottom: 1px solid #373a40 !important;">
                        <h5 class="modal-title text-white font-semibold" id="damageReturnModalLabel">
                          <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                          Mark as Damaged
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" id="damageTxId" value="">
                        <div class="mb-3">
                          <label for="damageReason" class="form-label text-gray-300">Reason for Damage</label>
                          <textarea id="damageReason" class="form-control" rows="3" placeholder="Describe the damage..." style="background:#1f2126;border-color:#3a3d44;color:#fff"></textarea>
                        </div>
                        <div class="mb-2">
                          <label for="damageFee" class="form-label text-gray-300">Damage Fee (₱)</label>
                          <input type="number" id="damageFee" class="form-control" min="0" step="0.01" placeholder="0.00" style="background:#1f2126;border-color:#3a3d44;color:#fff">
                        </div>
                        <small class="text-gray-400">This fee will be added to any existing overdue fees.</small>
                      </div>
                        <div class="modal-footer border-0" style="border-top: 1px solid #373a40 !important;">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">
                          <i class="bi bi-x-circle me-1"></i>Cancel
                        </button>
                        <button type="button" class="btn btn-warning" id="confirmDamageBtn">
                          <i class="bi bi-check2-circle me-1"></i>Apply Damage
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr class="my-4" style="border-color: #373a40;">
            <div class="row g-3">
              <div class="col-md-4">
                <div class="bg-[#1a1b1e] rounded-lg p-3 " style="border-color: #373a40;">
                  <p class="text-gray-400 text-xs mb-1">Transaction ID</p>
                  <p id="modalTxId" class="text-white font-bold text-lg">--</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="bg-[#1a1b1e] rounded-lg p-3 " style="border-color: #373a40;">
                  <p class="text-gray-400 text-xs mb-1">Borrow Date</p>
                  <p id="modalBorrowDate" class="text-white font-bold text-lg">--</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="bg-[#1a1b1e] rounded-lg p-3 " style="border-color: #373a40;">
                  <p class="text-gray-400 text-xs mb-1">Due Date</p>
                  <p id="modalDueDate" class="text-white font-bold text-lg">--</p>
                </div>
              </div>
              <div class="col-md-6">
                <div id="modalReturnDateBox" class="bg-gray-500/10 rounded-lg p-3">
                  <p class="text-gray-400 text-xs mb-1">Return Date</p>
                  <p id="modalReturnDate" class="text-gray-400 font-bold text-lg">--</p>
                </div>
              </div>
              <div class="col-md-6">
                <div id="modalStatusBox" class="bg-gray-500/10 rounded-lg p-3">
                  <p id="modalStatusLabel" class="text-gray-400 text-xs mb-1">Status</p>
                  <p id="modalStatus" class="text-gray-400 font-bold text-lg">--</p>
                </div>
              </div>
              <div class="col-md-12">
                <div class="bg-amber-500/10 rounded-lg p-3 border-amber-500/20">
                  <p class="text-amber-500 text-xs mb-1">Fee</p>
                  <p id="modalFee" class="text-amber-500 font-bold text-lg">₱--</p>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer border-0" style="border-top: 1px solid #373a40 !important;">
            <!-- Return Approval Buttons (only shown for return_pending status) -->
            <div id="returnApprovalButtons" class="d-none me-auto">
              <button type="button" class="btn btn-success me-2 approve-return-btn-modal" id="approveReturnBtnModal">
                <i class="bi bi-check-circle me-1"></i>Approve Return
              </button>
              <button type="button" class="btn btn-danger reject-return-btn-modal" id="rejectReturnBtnModal">
                <i class="bi bi-x-circle me-1"></i>Damage Return
              </button>
            </div>
            
            <!-- Pay Now Button (only for non-admin roles; shown when there's a fee via JS) -->
            @if(auth()->check() && !in_array(auth()->user()->role, ['admin','super_admin']))
            <button type="button" id="payNowBtn" class="btn btn-warning rounded-lg d-none me-auto" data-tx-id="" data-fee="">
              <i class="bi bi-credit-card me-2"></i><span class="pay-label">Pay Now</span> ₱<span id="payNowAmount">0.00</span>
            </button>
            @endif
            
            <a id="downloadReceiptBtn" href="#" class="btn btn-success rounded-lg" target="_blank">
              <i class="bi bi-download me-2"></i>Download Receipt
            </a>
            <button type="button" class="btn btn-outline-light rounded-lg" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-2"></i>Close
            </button>
          </div>
        </div>
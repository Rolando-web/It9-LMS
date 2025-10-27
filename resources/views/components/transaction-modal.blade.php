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
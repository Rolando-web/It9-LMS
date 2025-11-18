<!-- Add Book Modal -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-[#2c2e33] border border-[#373a40]">
      <div class="modal-header border-b border-[#373a40]">
        <h5 class="modal-title text-white flex items-center gap-2" id="addBookModalLabel">
          <i class="bi bi-book-fill text-indigo-500"></i>
          Add New Book
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="addBookForm" action="{{ route('create') }}" enctype="multipart/form-data">
          @csrf
          <div class="row mb-4">
            <div class="col-md-6 mb-3">
              <label for="title" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-bookmark-fill me-1"></i>Title
              </label>
              <input type="text" class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500" id="title" name="title" placeholder="Enter book title" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="author" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-person-fill me-1"></i>Author
              </label>
              <input type="text" class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500" id="author" name="author" placeholder="Enter author name" required>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-6 mb-3">
              <label for="category" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-tags-fill me-1"></i>Category
              </label>
              <select class="form-select bg-[#1a1b1e] border-[#373a40] text-white focus:border-indigo-500 focus:ring-indigo-500" id="category" name="category" required>
                <option value="">Select a category...</option>
                <option value="Fiction">Fiction</option>
                <option value="Technology">Technology</option>
                <option value="History">History</option>
                <option value="Business">Business</option>
                <option value="Philosophy">Philosophy</option>
                <option value="Arts">Arts</option>
                <option value="Science">Science</option>
                <option value="Biology">Biology</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="isbn" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-upc-scan me-1"></i>ISBN
              </label>
              <input type="text" class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500" id="isbn" name="isbn" placeholder="Enter ISBN number" required>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-6 mb-3">
              <label for="publish_date" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-calendar-date me-1"></i>Publish Date
              </label>
              <input type="date" class="form-control bg-[#1a1b1e] border-[#373a40] text-white focus:border-indigo-500 focus:ring-indigo-500" id="publish_date" name="publish_date" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="copies" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-stack me-1"></i>Available Copies
              </label>
              <input type="number" class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500" id="copies" name="copies" min="1" placeholder="Enter number of copies" required>
            </div>
          </div>
          <div class="mb-4">
            <label for="image" class="form-label text-gray-300 text-sm font-medium">
              <i class="bi bi-image me-1"></i>Book Cover Image
            </label>
            <input type="file" class="form-control bg-[#1a1b1e] border-[#373a40] text-white focus:border-indigo-500 focus:ring-indigo-500" id="image" name="image" accept="image/*">
            <small class="text-gray-400">Recommended size: 400x600px</small>
          </div>
        </form>
      </div>
      <div class="modal-footer border-t border-[#373a40]">
        <button type="button" class="btn btn-secondary bg-[#373a40] border-[#373a40] hover:bg-[#25262b]" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i>Cancel
        </button>
        <button type="submit" form="addBookForm" name="addBook" class="btn bg-indigo-500 border-indigo-500 hover:bg-indigo-600 text-white">
          <i class="bi bi-check-circle me-1"></i>Save Book
        </button>
      </div>
    </div>
  </div>
</div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editBookModal" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <form method="POST" action="{{route('update-book')}}" enctype="multipart/form-data" class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                      @csrf
                      <!-- Modal Header -->
                      <div class="modal-header" style="background: linear-gradient(135deg, #0b2a2f, #12343b);">
                        <h5 class="modal-title text-white fw-bold">
                          <i class="bi bi-pencil-square me-2"></i>Edit Book Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                      </div>
                      
                      <!-- Modal Body -->
                      <div class="modal-body p-4" style="background-color: #f8f9fa;">
                        <input type="hidden" id="edit_id" name="edit_id">
                        <input type="hidden" id="edit_current_image" name="edit_current_image">

                        <div class="row g-4">
                          <div class="col-md-6">
                            <div class="modal-body p-4" style="background-color: #1a1b1e;">
                              <div class="card-body">
                                <h6 class="text-muted mb-3 fw-bold text-uppercase" style="font-size: 0.85rem;">
                                  <i class="bi bi-info-circle me-2"></i>Book Information
                                </h6>
                                
                                  <div class="card border-0 shadow-sm h-100" style="background-color:#25262b; color:#e5e7eb;">
                                  <label for="edit_title" class="form-label fw-semibold">
                                    <i class="bi bi-bookmark-fill text-primary me-1"></i>Title
                                  </label>
                                  <input type="text" id="edit_title" name="edit_title" class="form-control form-control-lg" 
                                         placeholder="Enter book title" required
                        <!-- Edit Book Modal -->
                        <div class="modal fade" id="editBookModal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg">
                            <form method="POST" action="{{ route('update-book') }}" enctype="multipart/form-data" class="modal-content bg-[#2c2e33] border border-[#373a40]">
                              @csrf
                              <div class="modal-header border-b border-[#373a40]">
                                <h5 class="modal-title text-white flex items-center gap-2">
                                  <i class="bi bi-pencil-square text-indigo-500"></i>
                                  Edit Book Details
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                <input type="hidden" id="edit_id" name="edit_id">
                                <input type="hidden" id="edit_current_image" name="edit_current_image">
                                <div class="row mb-4">
                                  <div class="col-md-6 mb-3">
                                    <label for="edit_title" class="form-label text-gray-300 text-sm font-medium"><i class="bi bi-bookmark-fill me-1"></i>Title</label>
                                    <input type="text" id="edit_title" name="edit_title" class="form-control bg-[#1a1b1e] border-[#373a40] text-white focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter book title" required>
                                  </div>
                                  <div class="col-md-6 mb-3">
                                    <label for="edit_author" class="form-label text-gray-300 text-sm font-medium"><i class="bi bi-person-fill me-1"></i>Author</label>
                                    <input type="text" id="edit_author" name="edit_author" class="form-control bg-[#1a1b1e] border-[#373a40] text-white focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter author name" required>
                                  </div>
                                </div>
                                <div class="row mb-4">
                                  <div class="col-md-6 mb-3">
                                    <label for="edit_category" class="form-label text-gray-300 text-sm font-medium"><i class="bi bi-tags-fill me-1"></i>Category</label>
                                    <select id="edit_category" name="edit_category" class="form-select bg-[#1a1b1e] border-[#373a40] text-white focus:border-indigo-500 focus:ring-indigo-500" required>
                                      <option value="Fiction">Fiction</option>
                                      <option value="Technology">Technology</option>
                                      <option value="History">History</option>
                                      <option value="Business">Business</option>
                                      <option value="Philosophy">Philosophy</option>
                                      <option value="Arts">Arts</option>
                                      <option value="Science">Science</option>
                                      <option value="Biology">Biology</option>
                                    </select>
                                  </div>
                                  <div class="col-md-6 mb-3">
                                    <label for="edit_isbn" class="form-label text-gray-300 text-sm font-medium"><i class="bi bi-upc-scan me-1"></i>ISBN</label>
                                    <input type="text" id="edit_isbn" name="edit_isbn" class="form-control bg-[#1a1b1e] border-[#373a40] text-white focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter ISBN number" required>
                                  </div>
                                </div>
                                <div class="row mb-4">
                                  <div class="col-md-6 mb-3">
                                    <label for="edit_publish_date" class="form-label text-gray-300 text-sm font-medium"><i class="bi bi-calendar-date me-1"></i>Publish Date</label>
                                    <input type="date" id="edit_publish_date" name="edit_publish_date" class="form-control bg-[#1a1b1e] border-[#373a40] text-white focus:border-indigo-500 focus:ring-indigo-500" required>
                                  </div>
                                  <div class="col-md-6 mb-3">
                                    <label for="edit_copies" class="form-label text-gray-300 text-sm font-medium"><i class="bi bi-stack me-1"></i>Available Copies</label>
                                    <input type="number" id="edit_copies" name="edit_copies" class="form-control bg-[#1a1b1e] border-[#373a40] text-white focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter number of copies" required>
                                  </div>
                                </div>
                                <div class="mb-4">
                                  <label for="edit_image" class="form-label text-gray-300 text-sm font-medium"><i class="bi bi-image me-1"></i>Book Cover Image</label>
                                  <input type="file" id="edit_image" name="edit_image" class="form-control bg-[#1a1b1e] border-[#373a40] text-white focus:border-indigo-500 focus:ring-indigo-500" accept="image/*">
                                  <small class="text-gray-400">Leave empty to keep current image</small>
                                </div>
                                <div class="mb-3">
                                  <div class="text-center p-3 bg-[#1a1b1e] border border-dashed border-[#373a40] rounded">
                                    <img id="edit_preview" src="" alt="Book Cover Preview" class="img-fluid rounded shadow-sm" style="max-height:120px; object-fit:cover; display:none;">
                                    <div id="edit_preview_placeholder">
                                      <i class="bi bi-image text-gray-600" style="font-size:3rem;"></i>
                                      <p class="text-gray-400 text-sm mb-0 mt-2">Current image preview</p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer border-t border-[#373a40]">
                                <button type="button" class="btn btn-secondary bg-[#373a40] border-[#373a40] hover:bg-[#25262b]" data-bs-dismiss="modal">
                                  <i class="bi bi-x-circle me-1"></i>Cancel
                                </button>
                                <button type="submit" name="updateBook" class="btn bg-indigo-500 border-indigo-500 hover:bg-indigo-600 text-white">
                                  <i class="bi bi-check-circle me-1"></i>Update Book
                                </button>
                              </div>
                            </form>
                          </div>
                        </div>
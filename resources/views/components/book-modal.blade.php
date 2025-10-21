                <!-- Modal -->
                <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">

                      <!-- Modal Header -->
                      <div class="modal-header bg-[#1E1E1E]">
                        <h5 class="modal-title text-white fw-bold" id="addBookModalLabel">
                          <i class="bi bi-book-fill me-2"></i>Add New Book
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <!-- Modal Body -->
                      <div class="modal-body p-4" style="background-color: #f8f9fa;">
                        <form method="POST" id="addBookForm" action="{{route('create')}}" enctype="multipart/form-data">
                          @csrf
                          <div class="row g-4">
                            <!-- Left Column - Book Information -->
                            <div class="col-md-6">
                              <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                  <h6 class="text-muted mb-3 fw-bold text-uppercase" style="font-size: 0.85rem;">
                                    <i class="bi bi-info-circle me-2"></i>Book Information
                                  </h6>
                                  
                                  <div class="mb-3">
                                    <label for="title" class="form-label fw-semibold">
                                      <i class="bi bi-bookmark-fill text-primary me-1"></i>Title
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="title" name="title" 
                                           placeholder="Enter book title" required 
                                           style="border-radius: 8px; border: 2px solid #e9ecef;">
                                  </div>
                                  
                                  <div class="mb-3">
                                    <label for="author" class="form-label fw-semibold">
                                      <i class="bi bi-person-fill text-success me-1"></i>Author
                                    </label>
                                    <input type="text" class="form-control form-control-lg text-white" id="author" name="author" 
                                           placeholder="Enter author name" required
                                           style="border-radius: 8px; border: 2px solid;">
                                  </div>
                                  
                                  <div class="mb-3">
                                    <label for="category" class="form-label fw-semibold">
                                      <i class="bi bi-tags-fill text-warning me-1"></i>Category
                                    </label>
                                    <select class="form-select form-select-lg" id="category" name="category" required 
                                            style="border-radius: 8px; border: 2px solid #e9ecef; background-color: #252525; color: white;">
                                      <option value="" selected disabled>Select a category</option>
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
                                  
                                  <div class="mb-3">
                                    <label for="isbn" class="form-label fw-semibold">
                                      <i class="bi bi-upc-scan text-info me-1"></i>ISBN
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="isbn" name="isbn" 
                                           placeholder="Enter ISBN number" required
                                           style="border-radius: 8px; border: 2px solid #e9ecef;">
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Right Column - Publishing Details -->
                            <div class="col-md-6">
                              <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                  <h6 class="text-muted mb-3 fw-bold text-uppercase" style="font-size: 0.85rem;">
                                    <i class="bi bi-calendar-check me-2"></i>Publishing Details
                                  </h6>
                                  
                                  <div class="mb-3">
                                    <label for="publish_date" class="form-label fw-semibold">
                                      <i class="bi bi-calendar-date text-danger me-1"></i>Publish Date
                                    </label>
                                    <input type="date" class="form-control form-control-lg" id="publish_date" name="publish_date" required
                                           style="border-radius: 8px; border: 2px solid #e9ecef;">
                                  </div>
                                  
                                  <div class="mb-3">
                                    <label for="copies" class="form-label fw-semibold">
                                      <i class="bi bi-stack text-primary me-1"></i>Available Copies
                                    </label>
                                    <input type="number" class="form-control form-control-lg" id="copies" name="copies" min="1" 
                                           placeholder="Enter number of copies" required
                                           style="border-radius: 8px; border: 2px solid #e9ecef;">
                                  </div>
                                  
                                  <div class="mb-3">
                                    <label for="image" class="form-label fw-semibold">
                                      <i class="bi bi-image text-purple me-1"></i>Book Cover Image
                                    </label>
                                    <div class="border-2 border-dashed rounded p-3" style="border: 2px dashed #dee2e6; background-color: #fff;">
                                      <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                             style="border: none;">
                                      <small class="text-muted d-block mt-2">
                                        <i class="bi bi-info-circle me-1"></i>Recommended size: 400x600px
                                      </small>
                                    </div>
                                  </div>

                                  <!-- Preview Area -->
                                  <div class="text-center p-3 bg-white rounded" style="border: 2px dashed #dee2e6;">
                                    <i class="bi bi-image" style="font-size: 3rem; color: #dee2e6;"></i>
                                    <p class="text-muted mb-0 mt-2" style="font-size: 0.85rem;">Image preview will appear here</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>

                      <!-- Modal Footer -->
                      <div class="modal-footer border-0 bg-white p-3">
                        <button type="button" class="btn btn-danger btn-lg px-4" data-bs-dismiss="modal" style="border-radius: 8px;">
                          <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <button type="submit" form="addBookForm" name="addBook" class="btn text-white btn-lg px-4 bg-[#1A2C2F] border-2 border-[#1ED1E9] hover:bg-[#1e1e1e] hover:text-[#1A2C2F]">
                          <i class="bi bi-check-circle me-2"></i>Save Book
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
                      <div class="modal-header bg-[#1E1E1E]">
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
                            <div class="card border-0 shadow-sm h-100">
                              <div class="card-body">
                                <h6 class="text-muted mb-3 fw-bold text-uppercase" style="font-size: 0.85rem;">
                                  <i class="bi bi-info-circle me-2"></i>Book Information
                                </h6>
                                
                                <div class="mb-3">
                                  <label for="edit_title" class="form-label fw-semibold">
                                    <i class="bi bi-bookmark-fill text-primary me-1"></i>Title
                                  </label>
                                  <input type="text" id="edit_title" name="edit_title" class="form-control form-control-lg" 
                                         placeholder="Enter book title" required
                                         style="border-radius: 8px; border: 2px solid #e9ecef;">
                                </div>
                                
                                <div class="mb-3">
                                  <label for="edit_author" class="form-label fw-semibold">
                                    <i class="bi bi-person-fill text-success me-1"></i>Author
                                  </label>
                                  <input type="text" id="edit_author" name="edit_author" class="form-control form-control-lg" 
                                         placeholder="Enter author name" required
                                         style="border-radius: 8px; border: 2px solid #e9ecef;">
                                </div>
                                
                                <div class="mb-3">
                                  <label for="edit_category" class="form-label fw-semibold">
                                    <i class="bi bi-tags-fill text-warning me-1"></i>Category
                                  </label>
                                  <select class="form-select form-select-lg" id="edit_category" name="edit_category" required 
                                          style="border-radius: 8px; border: 2px solid #e9ecef; background-color: #252525; color: white;">
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
                                
                                <div class="mb-3">
                                  <label for="edit_isbn" class="form-label fw-semibold">
                                    <i class="bi bi-upc-scan text-info me-1"></i>ISBN
                                  </label>
                                  <input type="text" id="edit_isbn" name="edit_isbn" class="form-control form-control-lg" 
                                         placeholder="Enter ISBN number" required
                                         style="border-radius: 8px; border: 2px solid #e9ecef;">
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- Right Column - Publishing Details & Image -->
                          <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                              <div class="card-body">
                                <h6 class="text-muted mb-3 fw-bold text-uppercase" style="font-size: 0.85rem;">
                                  <i class="bi bi-calendar-check me-2"></i>Publishing Details
                                </h6>
                                
                                <div class="mb-3">
                                  <label for="edit_publish_date" class="form-label fw-semibold">
                                    <i class="bi bi-calendar-date text-danger me-1"></i>Publish Date
                                  </label>
                                  <input type="date" id="edit_publish_date" name="edit_publish_date" class="form-control form-control-lg" required
                                         style="border-radius: 8px; border: 2px solid #e9ecef;">
                                </div>
                                
                                <div class="mb-3">
                                  <label for="edit_copies" class="form-label fw-semibold">
                                    <i class="bi bi-stack text-primary me-1"></i>Available Copies
                                  </label>
                                  <input type="number" id="edit_copies" name="edit_copies" class="form-control form-control-lg" 
                                         placeholder="Enter number of copies" required
                                         style="border-radius: 8px; border: 2px solid #e9ecef;">
                                </div>

                                <div class="mb-3">
                                  <label for="edit_image" class="form-label fw-semibold">
                                    <i class="bi bi-image text-purple me-1"></i>Book Cover Image
                                  </label>
                                  <div class="border-2 border-dashed rounded p-3" style="border: 2px dashed #dee2e6; background-color: #fff;">
                                    <input type="file" id="edit_image" name="edit_image" class="form-control" accept="image/*"
                                           style="border: none;">
                                    <small class="text-muted d-block mt-2">
                                      <i class="bi bi-info-circle me-1"></i>Leave empty to keep current image
                                    </small>
                                  </div>
                                </div>

                                <!-- Preview Area -->
                                <div class="text-center p-3 bg-white rounded" style="border: 2px dashed #dee2e6;">
                                  <img id="edit_preview" src="" alt="Book Cover Preview"
                                    class="img-fluid rounded shadow-sm"
                                    style="max-height: 120px; object-fit: cover; display: none;">
                                  <div id="edit_preview_placeholder">
                                    <i class="bi bi-image" style="font-size: 3rem; color: #dee2e6;"></i>
                                    <p class="text-muted mb-0 mt-2" style="font-size: 0.85rem;">Current image preview</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="modal-footer border-0 bg-white p-3">
                        <button type="button" class="btn btn-danger btn-lg px-4" data-bs-dismiss="modal" style="border-radius: 8px;">
                          <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <button type="submit" name="updateBook" class="btn text-white btn-lg px-4 bg-[#1A2C2F] border-2 border-[#1ED1E9] hover:bg-[#1e1e1e] hover:text-[#1A2C2F]">
                          <i class="bi bi-check-circle me-2"></i>Update Book
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
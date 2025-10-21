                <!-- Modal -->
                <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h5 class="modal-title" id="addBookModalLabel">Add New Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <!-- Modal Body -->
                      <div class="modal-body">
                        <form method="POST" id="addBookForm" action="{{route('create')}}">
                          @csrf
                          <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                          </div>
                          <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control" id="author" name="author" required>
                          </div>
                          <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category" required style="background-color: #252525; color: white;">
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
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" required>
                          </div>
                          <div class="mb-3">
                            <label for="publish_date" class="form-label">Publish Date</label>
                            <input type="date" class="form-control" id="publish_date" name="publish_date" required>
                          </div>
                          <div class="mb-3">
                            <label for="copies" class="form-label">Copies</label>
                            <input type="number" class="form-control" id="copies" name="copies" min="1" required>
                          </div>
                          <div class="mb-3">
                            <label for="image" class="form-label">Book Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                          </div>
                        </form>
                      </div>

                      <!-- Modal Footer -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="addBookForm" name="addBook" class="btn btn-primary">Save Book</button>

                      </div>
                    </div>
                  </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editBookModal" tabindex="-1">
                  <div class="modal-dialog">
                    <form method="POST" enctype="multipart/form-data" class="modal-content" style="background-color: white; color:black;">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" id="edit_id" name="edit_id">
                        <input type="hidden" id="edit_current_image" name="edit_current_image">

                        <input type="text" id="edit_title" name="edit_title" class="form-control mb-2" required>
                        <input type="text" id="edit_author" name="edit_author" class="form-control mb-2" required>
                        <div class="mb-3">
                          <label for="category" class="form-label">Category</label>
                          <select class="form-select" id="edit_category" name="edit_category" required style="background-color: #252525; color: white;">
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
                        <input type="text" id="edit_isbn" name="edit_isbn" class="form-control mb-2" required>
                        <input type="date" id="edit_publish_date" name="edit_publish_date" class="form-control mb-2" required>
                        <input type="number" id="edit_copies" name="edit_copies" class="form-control mb-2" required>

                        <!-- Image Preview -->
                        <div class="mb-2">
                          <img id="edit_preview" src=""
                            alt="Book Image"
                            class="img-fluid rounded mb-2"
                            style="max-height: 150px;">
                        </div>

                        <input type="file" id="edit_image" name="edit_image" class="form-control mb-2">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="updateBook" class="btn btn-success">Update Book</button>
                      </div>
                    </form>
                  </div>
                </div>
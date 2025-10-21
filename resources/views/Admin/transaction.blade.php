<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Management System - Admin Control</title>
  <meta name="description" content="Admin dashboard for book management system with dark theme interface">
  <link rel="stylesheet" href="{{asset('css/style.css')}}" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../image/willan.jpg" type="image/jpeg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
  <div class="d-flex min-vh-100 bg-[#2c2d2c]">
    @include('components.sidebar')
    
    <x-header>
  <h1 class="text-light mb-0 text-3xl">
       Manage Transactions
      </h1>
    </x-header>


    <div class="flex-grow-1">
      <div class="table-responsive m-4" style="border-radius: 10px;">
        <table class="table table-dark table-hover align-middle">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">User_id</th>
              <th scope="col">Book_id</th>
              <th scope="col">Borrow_date</th>
              <th scope="col">Due_date</th>
              <th scope="col">Return_date</th>
              <th scope="col">Overdue_date</th>
              <th scope="col">Fee</th>
            </tr>
          </thead>
          <tbody>           
              <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
              </tr>
          </tbody>
        </table>
      </div>

      <!-- Book Details Modal -->
      <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content bg-dark text-light">
            <div class="modal-header border-0">
              <h5 class="modal-title" id="bookModalLabel">Borrowed Book Details</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row g-3">
                <div class="col-md-3 text-center">
                  <img src="../image/book-cover.jpg" alt="Book Cover" class="img-fluid rounded" style="height: 120px;">
                </div>
                <div class="col-md-9">
                  <p><strong>Book ID:</strong> 001</p>
                  <p><strong>User ID:</strong> 1</p>
                  <p><strong>Title:</strong> Amie the Doughnut</p>
                  <p><strong>Author:</strong> William Shakespear</p>
                </div>
              </div>
              <hr class="border-light">
              <div class="row mt-3">
                <div class="col-md-4"><strong>ID:</strong> 4</div>
                <div class="col-md-4"><strong>Total Books:</strong> 04 Books</div>
                <div class="col-md-4"><strong>Due Date:</strong> 13 - 12 - 2024</div>
              </div>
            </div>
            <div class="modal-footer border-0">
              <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/admin.js') }}"></script>
        <script src="{{ asset('js/active.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
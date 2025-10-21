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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<style>

</style>

<body class="h-full">
    <div class="d-flex min-vh-100 bg-[#2c2d2c]">
    @include('components.sidebar')
    <x-header>
  <h1 class="text-light mb-0 text-3xl pl-2">
       Manage Books
      </h1>
    </x-header>
            <!-- Controls -->
            <div class="p-4 w-100">
                <div class="flex flex-col md:flex-row mb-4">
                        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-green-100 border-green-300">
                                        <h5 class="modal-title text-green-700" id="successModalLabel">Success</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-green-600">
                                    </div>
                                    <div class="modal-footer bg-green-100 border-green-300">
                                        <button type="button" class="btn btn-green-600" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="w-full lg:w-[20%] mb-3 md:mb-0">
                        <button
                            type="button"
                            class="bg-blue-500 text-white flex items-center justify-center w-full md:w-auto px-3 lg:px-4 py-2 rounded hover:bg-blue-600"
                            data-bs-toggle="modal"
                            data-bs-target="#addBookModal">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Book
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive" style="border-radius: 10px;">
                    <table class="table table-dark table-hover">
                        <thead class="text-white font-bold">
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">ID</th>
                                <th scope="col">Title</th>
                                <th scope="col" class="d-none d-sm-table-cell">Author</th>
                                <th scope="col">Category</th>
                                <th scope="col" class="d-none d-lg-table-cell">ISBN</th>
                                <th scope="col" class="d-none d-md-table-cell">Publish_date</th>
                                <th scope="col" class="d-none d-lg-table-cell">Copies</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                    <tr>
                                        <td>
                                            <img src="#" alt="wew" class="rounded" width="80" height="80" />
                                        </td>
                                        <td class="align-middle">11</td>
                                        <td class="align-middle">
                                            <div>
                                                <div class="fw-bold">www</div>
                                                <small class="opacity-50">wew</small>
                                            </div>
                                        </td>
                                        <td class="align-middle d-none d-sm-table-cell">wew</td>
                                        <td class="align-middle d-none d-sm-table-cell">aa</td>
                                        <td class="align-middle d-none d-lg-table-cell">00</td>
                                        <td class="align-middle d-none d-md-table-cell">2004</td>
                                        <td class="align-middle d-none d-lg-table-cell">20</td>
                                        <td class="align-middle">
                                            <div class="d-flex gap-1">
                                                <button class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg editBtn" title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                                    <input type="hidden" name="delete_id" value="11">
                                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                        </tbody>
                    </table>
                </div>



                <!-- Sidebar -->
                @include('components.book-modal')
                <!-- Sidebar -->

            </div>
              </div>
            <!-- Bootstrap JS for mobile sidebar toggle -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
         <script src="{{ asset('js/admin.js') }}"></script>
        <script src="{{ asset('js/active.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>

</body>

</html>
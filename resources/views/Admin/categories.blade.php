<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Management System - Admin Control</title>
  <meta name="description" content="Admin dashboard for book management system with dark theme interface">
  <link rel="stylesheet" href="{{asset('css/style.css')}}" />
  <link rel="icon" href="../image/willan.jpg" type="image/jpeg">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
  <div class="d-flex min-vh-100 bg-[#2c2d2c]">
    
    @include('components.sidebar')
    <x-header>
      <h1 class="text-light mb-0 text-3xl">
       Manage Categories
      </h1>
    </x-header>

      <!-- Category -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 m-8">
          <div class="group relative overflow-hidden cursor-pointer rounded-lg border border-border bg-card transition-all duration-300 hover:scale-[1.02] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.15)]">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/arts.jpg')}}" alt="category"
                alt="category"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
              <h3 class="text-2xl font-bold text-white mb-1">Business</h3>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </div>

            <div class="group relative overflow-hidden cursor-pointer rounded-lg border border-border bg-card transition-all duration-300 hover:scale-[1.02] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.15)]">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/biology.jpg')}}" alt="category"
                alt="category"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
              <h3 class="text-2xl font-bold text-white mb-1">Business</h3>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </div>

            <div class="group relative overflow-hidden cursor-pointer rounded-lg border border-border bg-card transition-all duration-300 hover:scale-[1.02] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.15)]">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/business.jpg')}}" alt="category"
                alt="category"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
              <h3 class="text-2xl font-bold text-white mb-1">Business</h3>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </div>

            <div class="group relative overflow-hidden cursor-pointer rounded-lg border border-border bg-card transition-all duration-300 hover:scale-[1.02] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.15)]">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/fiction.jpg')}}" alt="category"
                alt="category"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
              <h3 class="text-2xl font-bold text-white mb-1">Business</h3>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </div>

            <div class="group relative overflow-hidden cursor-pointer rounded-lg border border-border bg-card transition-all duration-300 hover:scale-[1.02] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.15)]">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/history.jpg')}}" alt="category"
                alt="category"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
              <h3 class="text-2xl font-bold text-white mb-1">Business</h3>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </div>

            <div class="group relative overflow-hidden cursor-pointer rounded-lg border border-border bg-card transition-all duration-300 hover:scale-[1.02] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.15)]">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/technology.jpg')}}" alt="category"
                alt="category"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
              <h3 class="text-2xl font-bold text-white mb-1">Business</h3>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </div>

            <div class="group relative overflow-hidden cursor-pointer rounded-lg border border-border bg-card transition-all duration-300 hover:scale-[1.02] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.15)]">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/philosophy.jpg')}}" alt="category"
                alt="category"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
              <h3 class="text-2xl font-bold text-white mb-1">Business</h3>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </div>

            <div class="group relative overflow-hidden cursor-pointer rounded-lg border border-border bg-card transition-all duration-300 hover:scale-[1.02] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.15)]">
            <div class="aspect-[5/4] overflow-hidden">
              <img src="{{asset('category/science.jpg')}}" alt="category"
                alt="category"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
              <h3 class="text-2xl font-bold text-white mb-1">Business</h3>
              <p class="text-sm text-gray-300">2 books</p>
            </div>
          </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
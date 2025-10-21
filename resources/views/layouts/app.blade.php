<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/svg+xml" href="/vite.svg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="../image/willan.jpg" type="image/jpeg">
 @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <title>Home Library</title>
</head>
<body class="bg-gray-900 text-white font-sans">
   
  @include('layouts.partials.header')
  @include('layouts.partials.hero')
  @include('layouts.partials.featured')
  @include('layouts.partials.modals')
  @include('layouts.partials.category')
  @include('layouts.partials.footer')


  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="{{ asset('js/user.js') }}"></script>
</body>
</html>




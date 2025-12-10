<x-page-header>
 Home Library
</x-page-header>
   
  @include('layouts.partials.header')
  @include('layouts.partials.hero')
  @include('layouts.partials.featured')
  @include('layouts.partials.modals')
  @include('layouts.partials.category')
  @include('layouts.partials.footer')


  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="{{ asset('js/user.js') }}"></script>
  <script src="{{ asset('js/notification.js') }}"></script>
</body>
</html>




<x-import>
  <title>Forget-Password - Book Management System</title>
</x-import>
    <div class="flex min-h-screen items-center justify-center bg-[#1A1A1A] py-12 px-4">
      <div class="flex flex-col md:flex-row w-full max-w-4xl rounded-lg shadow-lg overflow-hidden md:h-[420px]">

        <div class="md:w-1/2 w-full bg-[#252525] p-8 flex flex-col items-center justify-center text-center text-white">
          <img src="./image/willan.jpg" alt="William Shakespeare" class="w-20 h-20 md:w-32 md:h-32 rounded-full mb-4">
          <h2 class="text-3xl md:text-4xl font-bold mb-2">Library Management System</h2>
          <p class=" my-4 md:my-8 text-[18px]">Reset your password to get back in.</p>
        </div>

        <div class="md:w-1/2 w-full p-8 flex flex-col justify-center items-center text-center bg-[#1E1E1E] text-white">
          <div class="w-full max-w-md">
            <h2 class="text-2xl md:text-4xl font-semibold mb-6">Forgot Password</h2>

            @if(session('success'))
              <div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-lg flex items-center gap-3 text-emerald-400">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm">{{ session('success') }}</span>
              </div>
            @endif

            @if($errors->any())
              <div class="mb-4 p-4 bg-red-500/10 border border-red-500/30 rounded-lg text-red-400 text-sm text-left">
                <div class="flex items-center gap-2 mb-2">
                  <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                  </svg>
                  <strong>Error:</strong>
                </div>
                <ul class="ml-7 list-disc">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form class="space-y-4" method="POST" action="{{ route('password.check') }}">
              @csrf
              <div>
                <label for="email" class="block text-sm font-medium text-left">Email</label>
                <input required type="email" placeholder="Email" id="email" name="email" value="{{ old('email') }}" class="text-black mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <button type="submit" class="w-full cursor-pointer bg-white text-black py-2 border rounded-md hover:bg-[#1A2C2F] hover:border-[#1ED1E9] hover:text-white transition">Continue</button>
              <p class="mt-6">
                Back to
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login</a>
              </p>
            </form>
          </div>
        </div>

      </div>
    </div>
    
<x-import-footer/>

<x-import>
  <title>Forgot Password - Book Management System</title>
</x-import>

<div class="flex min-h-screen items-center justify-center bg-[#1A1A1A] py-12 px-4">
  <div class="flex flex-col md:flex-row w-full max-w-4xl rounded-lg shadow-lg overflow-hidden md:h-[495px]">

    <!-- Left Section (same as login) -->
    <div class="md:w-1/2 w-full bg-[#252525] p-8 flex flex-col items-center justify-center text-center text-white">
      <img src="./image/willan.jpg" alt="William Shakespeare" class="w-20 h-20 md:w-32 md:h-32 rounded-full mb-4">
      <h2 class="text-3xl md:text-4xl font-bold mb-2">Library Management System</h2>
      <p class="my-4 md:my-8 text-[18px]">Your premier digital library for borrowing and reading books.</p>
    </div>

    <!-- Right Section -->
    <div class="md:w-1/2 w-full p-8 flex flex-col justify-center items-center text-center bg-[#1E1E1E] text-white">
      <div class="w-full max-w-md">
        <h2 class="text-2xl md:text-4xl font-semibold mb-6">Forgot your password?</h2>
        <p class="text-gray-400 mb-6">Enter your email to continue to password reset.</p>

        @if(session('status'))
          <div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-lg flex items-center gap-3 text-emerald-400" role="alert">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm">{{ session('status') }}</span>
          </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4 text-left">
          @csrf
          <div>
            <label class="block text-sm font-medium" for="email">Email</label>
            <input type="email" id="email" name="email" class="text-black mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
            @error('email')
              <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
            @enderror
          </div>
          <button type="submit" class="w-full cursor-pointer bg-[#131313] text-white py-2 border rounded-md hover:bg-[#1A2C2F] hover:border-[#1ED1E9] transition">Continue</button>
        </form>

        <div class="mt-6 text-center">
          <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Back to login</a>
        </div>
      </div>
    </div>

  </div>
</div>

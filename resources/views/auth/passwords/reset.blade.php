<x-import>
  <title>Reset Password - Book Management System</title>
</x-import>

<div class="min-h-screen flex items-center justify-center bg-[#1A1A1A] py-12 px-4">
  <div class="w-full max-w-md bg-[#1E1E1E] text-white rounded-lg shadow-lg p-8">
    <h2 class="text-3xl font-semibold mb-6 text-center">Reset your password</h2>

    @if(session('status'))
      <div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-lg flex items-center gap-3 text-emerald-400" role="alert">
        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span class="text-sm">{{ session('status') }}</span>
      </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}" />

      <div>
        <label class="block text-sm font-medium" for="email">Email</label>
        <!-- Disabled visible email field -->
        <input type="email" id="email" value="{{ $email ?? old('email') }}" class="text-black mt-1 w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" disabled />
        <!-- Hidden email field to submit the value -->
        <input type="hidden" name="email" value="{{ $email ?? old('email') }}" />
        @error('email')
          <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label class="block text-sm font-medium" for="password">New Password</label>
        <input type="password" id="password" name="password" class="text-black mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
        @error('password')
          <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label class="block text-sm font-medium" for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="text-black mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
      </div>

      <button type="submit" class="w-full cursor-pointer bg-[#131313] text-white py-2 border rounded-md hover:bg-[#1A2C2F] hover:border-[#1ED1E9] transition">Reset Password</button>
    </form>

    <div class="mt-6 text-center">
      <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Back to login</a>
    </div>
  </div>
</div>

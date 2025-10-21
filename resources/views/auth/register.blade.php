<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
     <div class="flex min-h-screen items-center justify-center bg-[#1A1A1A] py-12 px-4">
    <div class="flex flex-col md:flex-row-reverse w-full max-w-4xl rounded-lg shadow-lg overflow-hidden md:h-[650px]">

      <!-- Right Section (Image & Title) -->
      <div class="md:w-1/2 w-full bg-[#252525] p-8 flex flex-col items-center justify-center text-center text-white">
        <img src="./image/willan.jpg" alt="William Shakespeare" class="w-20 h-20 md:w-32 md:h-32 rounded-full mb-4">
        <h2 class="text-3xl md:text-4xl font-bold mb-2">Library Management System</h2>
        <p class="my-4 md:my-8 text-[18px]">Your premier digital library for borrowing and reading books.</p>
      </div>


      <div class="md:w-1/2 w-full p-8 flex flex-col justify-center items-center text-center bg-[#1E1E1E] text-white">
        <div class="w-full max-w-md">
          <h2 class="text-2xl md:text-4xl font-semibold mb-6">REGISTER</h2>
          <p class="mb-4">Create your account to get started.</p>

          <form class="space-y-4" method="POST" action="{{ route('register') }}">
                @csrf
            <div class="flex flex-col md:flex-row gap-4">
              <div class="w-full">
                <label for="firstName" class="block text-sm font-medium text-left">First Name</label>
                <input required type="text" id="firstName" name="firstName" placeholder="First Name" class="text-black mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div class="w-full">
                <label for="lastName" class="block text-sm font-medium text-left">Last Name</label>
                <input required type="text" id="lastName" name="lastName" placeholder="Last Name" class="text-black mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
            </div>

            <!-- Contact -->
            <div>
              <label for="contact" class="block text-sm font-medium text-left">Contact</label>
              <input required type="text" id="contact" name="contact" placeholder="Contact Number" class="text-black mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Email -->
            <div>
              <label for="email" class="block text-sm font-medium text-left">Email</label>
              <input required type="email" id="email" name="email" placeholder="Email" class="text-black mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Password -->
            <div>
              <label for="password" class="block text-sm font-medium text-left">Password</label>
              <input required type="password" id="password" name="password" placeholder="Password" class="text-black mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

             <!-- Confirmed Password -->
            <div>
              <label for="password" class="block text-sm font-medium text-left">Password</label>
              <input required type="password" id="password" name="password_confirmation" placeholder="Confirm Password" class="text-black mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full cursor-pointer bg-white border text-black py-2 rounded-md hover:bg-[#1A2C2F] hover:border-[#1ED1E9] hover:text-white transition">Register</button>

            <!-- Login Redirect -->
            <p class="mt-6">
              Already have an account?
              <a href="{{route('login')}}" class="text-blue-600 hover:underline font-medium">Log in</a>
            </p>
          </form>
        </div>
      </div>

    </div>
  </div>

  </body>
</html>
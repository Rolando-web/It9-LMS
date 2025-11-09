<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-[#2c2e33] border-[#373a40]">
      <div class="modal-header border-b border-[#373a40]">
        <h5 class="modal-title text-white flex items-center gap-2" id="addUserModalLabel">
          <i class="bi bi-person-plus-fill text-indigo-500"></i>
          Add New User
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addUserForm" method="POST" action="{{ route('user.store') }}">
          @csrf
          
          <div class="row mb-4">
            <div class="col-md-6 mb-3">
              <label for="firstName" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-person me-1"></i>First Name
              </label>
              <input 
                type="text" 
                class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500" 
                id="firstName" 
                name="firstName" 
                placeholder="Enter first name"
                required>
            </div>
            
            <div class="col-md-6 mb-3">
              <label for="lastName" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-person me-1"></i>Last Name
              </label>
              <input 
                type="text" 
                class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500" 
                id="lastName" 
                name="lastName" 
                placeholder="Enter last name"
                required>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6 mb-3">
              <label for="email" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-envelope me-1"></i>Email Address
              </label>
              <input 
                type="email" 
                class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500" 
                id="email" 
                name="email" 
                placeholder="user@example.com"
                required>
            </div>
            
            <div class="col-md-6 mb-3">
              <label for="contact" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-phone me-1"></i>Contact Number
              </label>
              <input 
                type="text" 
                class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500" 
                id="contact" 
                name="contact" 
                placeholder="+63 XXX XXX XXXX">
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6 mb-3">
              <label for="password" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-lock me-1"></i>Password
              </label>
              <div class="input-group">
                <input 
                  type="password" 
                  class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500" 
                  id="password" 
                  name="password" 
                  placeholder="Enter password"
                  minlength="8"
                  required>
                <button class="btn bg-[#373a40] border-[#373a40] text-gray-300 hover:bg-[#25262b]" type="button" id="togglePassword">
                  <i class="bi bi-eye" id="passwordIcon"></i>
                </button>
              </div>
              <small class="text-gray-400">Minimum 8 characters</small>
            </div>
            
            <div class="col-md-6 mb-3">
              <label for="password_confirmation" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-lock-fill me-1"></i>Confirm Password
              </label>
              <input 
                type="password" 
                class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500" 
                id="password_confirmation" 
                name="password_confirmation" 
                placeholder="Re-enter password"
                minlength="8"
                required>
            </div>
          </div>

          <div class="mb-4">
            <label for="role" class="form-label text-gray-300 text-sm font-medium">
              <i class="bi bi-shield-check me-1"></i>User Role
            </label>
            <select 
              class="form-select bg-[#1a1b1e] border-[#373a40] text-white focus:border-indigo-500 focus:ring-indigo-500" 
              id="role" 
              name="role"
              required>
              <option value="">Select a role...</option>
              <option value="user">User - Regular library member</option>
              <option value="admin">Admin - Can manage books and users</option>
              <option value="super_admin">Super Admin - Full system access</option>
            </select>
            <small class="text-gray-400">Choose the appropriate role for this user</small>
          </div>
        </form>
      </div>
      <div class="modal-footer border-t border-[#373a40]">
        <button type="button" class="btn btn-secondary bg-[#373a40] border-[#373a40] hover:bg-[#25262b]" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i>Cancel
        </button>
        <button type="submit" form="addUserForm" class="btn bg-indigo-500 border-indigo-500 hover:bg-indigo-600 text-white">
          <i class="bi bi-check-circle me-1"></i>Add User
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  // Toggle password visibility
  document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');

    if (togglePassword) {
      togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Toggle icon
        if (type === 'text') {
          passwordIcon.classList.remove('bi-eye');
          passwordIcon.classList.add('bi-eye-slash');
        } else {
          passwordIcon.classList.remove('bi-eye-slash');
          passwordIcon.classList.add('bi-eye');
        }
      });
    }

    // Password match validation
    const passwordConfirmation = document.getElementById('password_confirmation');
    if (passwordConfirmation) {
      passwordConfirmation.addEventListener('input', function() {
        if (this.value !== password.value) {
          this.setCustomValidity('Passwords do not match');
        } else {
          this.setCustomValidity('');
        }
      });
    }
  });
</script>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-[#2c2e33] border-[#373a40]">
      <div class="modal-header border-b border-[#373a40]">
        <h5 class="modal-title text-white flex items-center gap-2" id="editUserModalLabel">
          <i class="bi bi-pencil-square text-cyan-500"></i>
          Edit User
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editUserForm" method="POST" action="#">
          @csrf
          @method('PUT')

          <div class="row mb-4">
            <div class="col-md-6 mb-3">
              <label for="edit_firstName" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-person me-1"></i>First Name
              </label>
              <input 
                type="text" 
                class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-cyan-500 focus:ring-cyan-500" 
                id="edit_firstName" 
                name="firstName" 
                placeholder="Enter first name"
                required>
            </div>
            
            <div class="col-md-6 mb-3">
              <label for="edit_lastName" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-person me-1"></i>Last Name
              </label>
              <input 
                type="text" 
                class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-cyan-500 focus:ring-cyan-500" 
                id="edit_lastName" 
                name="lastName" 
                placeholder="Enter last name"
                required>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6 mb-3">
              <label for="edit_email" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-envelope me-1"></i>Email Address
              </label>
              <input 
                type="email" 
                class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-cyan-500 focus:ring-cyan-500" 
                id="edit_email" 
                name="email" 
                placeholder="user@example.com"
                required>
            </div>
            
            <div class="col-md-6 mb-3">
              <label for="edit_contact" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-phone me-1"></i>Contact Number
              </label>
              <input 
                type="text" 
                class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-cyan-500 focus:ring-cyan-500" 
                id="edit_contact" 
                name="contact" 
                placeholder="+63 XXX XXX XXXX">
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6 mb-3">
              <label for="edit_password" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-lock me-1"></i>New Password (optional)
              </label>
              <div class="input-group">
                <input 
                  type="password" 
                  class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-cyan-500 focus:ring-cyan-500" 
                  id="edit_password" 
                  name="password" 
                  placeholder="Leave blank to keep current"
                  minlength="8">
                <button class="btn bg-[#373a40] border-[#373a40] text-gray-300 hover:bg-[#25262b]" type="button" id="toggleEditPassword">
                  <i class="bi bi-eye" id="editPasswordIcon"></i>
                </button>
              </div>
              <small class="text-gray-400">Leave empty to keep the existing password</small>
            </div>
            
            <div class="col-md-6 mb-3">
              <label for="edit_password_confirmation" class="form-label text-gray-300 text-sm font-medium">
                <i class="bi bi-lock-fill me-1"></i>Confirm New Password
              </label>
              <input 
                type="password" 
                class="form-control bg-[#1a1b1e] border-[#373a40] text-white placeholder-gray-500 focus:border-cyan-500 focus:ring-cyan-500" 
                id="edit_password_confirmation" 
                name="password_confirmation" 
                placeholder="Re-enter new password"
                minlength="8">
            </div>
          </div>

          <div class="mb-4">
            <label for="edit_role" class="form-label text-gray-300 text-sm font-medium">
              <i class="bi bi-shield-check me-1"></i>User Role
            </label>
            <select 
              class="form-select bg-[#1a1b1e] border-[#373a40] text-white focus:border-cyan-500 focus:ring-cyan-500" 
              id="edit_role" 
              name="role"
              required>
              <option value="user">User - Regular library member</option>
              <option value="admin">Admin - Can manage books and users</option>
              <option value="super_admin">Super Admin - Full system access</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer border-t border-[#373a40]">
        <button type="button" class="btn btn-secondary bg-[#373a40] border-[#373a40] hover:bg-[#25262b]" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i>Cancel
        </button>
        <button type="submit" form="editUserForm" class="btn bg-cyan-500 border-cyan-500 hover:bg-cyan-600 text-white">
          <i class="bi bi-check-circle me-1"></i>Save Changes
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  // Edit Password visibility + confirmation match
  document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('toggleEditPassword');
    const pass = document.getElementById('edit_password');
    const icon = document.getElementById('editPasswordIcon');
    const passConf = document.getElementById('edit_password_confirmation');

    if (toggle) {
      toggle.addEventListener('click', function() {
        const type = pass.getAttribute('type') === 'password' ? 'text' : 'password';
        pass.setAttribute('type', type);
        if (type === 'text') {
          icon.classList.remove('bi-eye');
          icon.classList.add('bi-eye-slash');
        } else {
          icon.classList.remove('bi-eye-slash');
          icon.classList.add('bi-eye');
        }
      });
    }

    if (passConf) {
      passConf.addEventListener('input', function() {
        if (pass.value.length > 0 && this.value !== pass.value) {
          this.setCustomValidity('Passwords do not match');
        } else {
          this.setCustomValidity('');
        }
      });
    }
  });
</script>

<!-- Notification Modal Component -->
<div id="notificationModal" class="fixed inset-0 z-[9999] hidden">
  <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
  <div class="relative min-h-screen flex items-center justify-center p-4">
    <div class="relative w-full max-w-md bg-[#1E2939] rounded-xl shadow-2xl border border-gray-700 overflow-hidden transform transition-all">
      <!-- Header -->
      <div id="notifHeader" class="flex items-center justify-between px-6 py-4 border-b border-gray-700">
        <h3 id="notifTitle" class="text-white text-lg font-semibold flex items-center gap-2">
          <svg id="notifIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
          <span id="notifTitleText">Notification</span>
        </h3>
      </div>

      <!-- Body -->
      <div class="px-6 py-6">
        <p id="notifMessage" class="text-gray-300 text-base leading-relaxed"></p>
      </div>

      <!-- Footer -->
      <div id="notifFooter" class="px-6 py-4 border-t border-gray-700 flex items-center justify-end gap-3 bg-gray-800/40">
        <!-- Buttons will be dynamically added here -->
      </div>
    </div>
  </div>
</div>

<script>
(function() {
  const modal = document.getElementById('notificationModal');
  const title = document.getElementById('notifTitleText');
  const message = document.getElementById('notifMessage');
  const icon = document.getElementById('notifIcon');
  const header = document.getElementById('notifHeader');
  const footer = document.getElementById('notifFooter');
  
  let resolveCallback = null;

  // Icons
  const icons = {
    success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
    error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
    warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3l-7.108-12c-.395-.667-1.265-.667-1.661 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>',
    info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
    question: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
  };

  const colors = {
    success: { icon: 'text-emerald-400', header: 'border-emerald-500/20' },
    error: { icon: 'text-red-400', header: 'border-red-500/20' },
    warning: { icon: 'text-yellow-400', header: 'border-yellow-500/20' },
    info: { icon: 'text-blue-400', header: 'border-blue-500/20' },
    question: { icon: 'text-cyan-400', header: 'border-cyan-500/20' }
  };

  function show(options) {
    const type = options.type || 'info';
    const titleText = options.title || 'Notification';
    const messageText = options.message || '';
    const buttons = options.buttons || [{ text: 'OK', value: true, primary: true }];

    // Set title
    title.textContent = titleText;

    // Set icon
    icon.innerHTML = icons[type] || icons.info;
    icon.className = `w-6 h-6 ${colors[type]?.icon || colors.info.icon}`;

    // Set message
    message.textContent = messageText;

    // Set header color
    header.className = `flex items-center justify-between px-6 py-4 border-b ${colors[type]?.header || colors.info.header}`;

    // Clear and create buttons
    footer.innerHTML = '';
    buttons.forEach(btn => {
      const button = document.createElement('button');
      button.textContent = btn.text;
      button.className = btn.primary 
        ? 'px-5 py-2.5 rounded-lg text-sm font-semibold bg-emerald-600 hover:bg-emerald-700 text-white transition-colors'
        : 'px-5 py-2.5 rounded-lg text-sm font-medium bg-gray-700 hover:bg-gray-600 text-gray-200 transition-colors';
      
      button.addEventListener('click', () => {
        hide();
        if (resolveCallback) resolveCallback(btn.value);
      });
      
      footer.appendChild(button);
    });

    // Show modal
    modal.classList.remove('hidden');

    // Return promise for async/await usage
    return new Promise(resolve => {
      resolveCallback = resolve;
    });
  }

  function hide() {
    modal.classList.add('hidden');
    resolveCallback = null;
  }

  // Close on backdrop click
  modal.addEventListener('click', (e) => {
    if (e.target === modal || e.target.classList.contains('backdrop-blur-sm')) {
      hide();
      if (resolveCallback) resolveCallback(false);
    }
  });

  // Expose global functions
  window.showNotification = show;
  window.hideNotification = hide;

  // Helper functions
  window.showAlert = (message, title = 'Alert') => {
    return show({
      type: 'info',
      title: title,
      message: message,
      buttons: [{ text: 'OK', value: true, primary: true }]
    });
  };

  window.showError = (message, title = 'Error') => {
    return show({
      type: 'error',
      title: title,
      message: message,
      buttons: [{ text: 'OK', value: true, primary: true }]
    });
  };

  window.showSuccess = (message, title = 'Success') => {
    return show({
      type: 'success',
      title: title,
      message: message,
      buttons: [{ text: 'OK', value: true, primary: true }]
    });
  };

  window.showConfirm = (message, title = 'Confirm') => {
    return show({
      type: 'question',
      title: title,
      message: message,
      buttons: [
        { text: 'Cancel', value: false, primary: false },
        { text: 'Confirm', value: true, primary: true }
      ]
    });
  };
})();
</script>

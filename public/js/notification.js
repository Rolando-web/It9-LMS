// Notification functionality
document.addEventListener("DOMContentLoaded", function () {
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationDropdown = document.getElementById(
        "notificationDropdown"
    );
    const notificationBadge = document.getElementById("notificationBadge");
    const notificationList = document.getElementById("notificationList");

    // Function to get CSRF token from meta tag
    function getCsrfToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute("content") : "";
    }

    // Toggle notification dropdown
    if (notificationBtn) {
        notificationBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle("hidden");

            // Load notifications when opening
            if (!notificationDropdown.classList.contains("hidden")) {
                loadNotifications();
            }
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener("click", function (e) {
        if (
            !notificationBtn.contains(e.target) &&
            !notificationDropdown.contains(e.target)
        ) {
            notificationDropdown.classList.add("hidden");
        }
    });

    // Load notifications from server
    function loadNotifications() {
        fetch("/notifications")
            .then((response) => response.json())
            .then((data) => {
                displayNotifications(data.notifications);
                updateBadge(data.unread_count);
            })
            .catch((error) => {
                console.error("Error loading notifications:", error);
                notificationList.innerHTML = `
                    <div class="p-4 text-center text-gray-400">
                        <p>Failed to load notifications</p>
                    </div>
                `;
            });
    }

    // Display notifications
    function displayNotifications(notifications) {
        if (notifications.length === 0) {
            notificationList.innerHTML = `
                <div class="p-4 text-center text-gray-400">
                    <p>No notifications</p>
                </div>
            `;
            return;
        }

        notificationList.innerHTML = notifications
            .map((notification) => {
                const isRead = notification.is_read;
                const bgColor = isRead ? "bg-gray-800" : "bg-gray-700";

                // Determine icon based on notification type
                let typeIcon;
                if (
                    notification.type === "borrow_approved" ||
                    notification.type === "return_approved"
                ) {
                    typeIcon =
                        '<i class="bi bi-check-circle-fill text-green-500"></i>';
                } else if (
                    notification.type === "borrow_rejected" ||
                    notification.type === "return_rejected"
                ) {
                    typeIcon =
                        '<i class="bi bi-x-circle-fill text-red-500"></i>';
                } else {
                    typeIcon =
                        '<i class="bi bi-info-circle-fill text-blue-500"></i>';
                }

                const timeAgo = formatTimeAgo(notification.created_at);

                return `
                <div class="notification-item ${bgColor} hover:bg-gray-600 p-4 border-b border-gray-700 cursor-pointer transition-colors"
                     data-notification-id="${notification.id}"
                     data-is-read="${isRead}">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1">
                            ${typeIcon}
                        </div>
                        <div class="flex-1">
                            <h4 class="text-white font-semibold text-sm">${
                                notification.title
                            }</h4>
                            <p class="text-gray-300 text-xs mt-1">${
                                notification.message
                            }</p>
                            <p class="text-gray-500 text-xs mt-2">${timeAgo}</p>
                        </div>
                        ${
                            !isRead
                                ? '<div class="flex-shrink-0"><span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span></div>'
                                : ""
                        }
                    </div>
                </div>
            `;
            })
            .join("");

        // Add click event to mark as read
        document.querySelectorAll(".notification-item").forEach((item) => {
            item.addEventListener("click", function () {
                const notificationId = this.getAttribute(
                    "data-notification-id"
                );
                const isRead = this.getAttribute("data-is-read") === "true";

                if (!isRead) {
                    markAsRead(notificationId);
                }
            });
        });
    }

    // Mark notification as read
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": getCsrfToken(),
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Reload notifications to update UI
                    loadNotifications();
                }
            })
            .catch((error) => {
                console.error("Error marking notification as read:", error);
            });
    }

    // Update notification badge
    function updateBadge(count) {
        if (count > 0) {
            notificationBadge.textContent = count > 9 ? "9+" : count;
            notificationBadge.classList.remove("hidden");
        } else {
            notificationBadge.classList.add("hidden");
        }
    }

    // Format time ago
    function formatTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);

        if (seconds < 60) return "Just now";
        if (seconds < 3600) return `${Math.floor(seconds / 60)} minutes ago`;
        if (seconds < 86400) return `${Math.floor(seconds / 3600)} hours ago`;
        if (seconds < 604800) return `${Math.floor(seconds / 86400)} days ago`;

        return date.toLocaleDateString();
    }

    // Load initial notification count
    loadNotifications();

    // Poll for new notifications every 30 seconds
    setInterval(loadNotifications, 30000);
});

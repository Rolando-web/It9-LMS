// Simple mobile sidebar toggle
const openSidebar = document.getElementById("openSidebar");
const closeSidebar = document.getElementById("closeSidebar");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("sidebarOverlay");

openSidebar.addEventListener("click", function () {
    sidebar.classList.add("show");
    overlay.classList.add("show");
});

closeSidebar.addEventListener("click", function () {
    sidebar.classList.remove("show");
    overlay.classList.remove("show");
});

overlay.addEventListener("click", function () {
    sidebar.classList.remove("show");
    overlay.classList.remove("show");
});

// Edit button listener
document.querySelectorAll(".editBtn").forEach((button) => {
    button.addEventListener("click", function () {
        document.getElementById("edit_id").value = this.dataset.id;
        document.getElementById("edit_title").value = this.dataset.title;
        document.getElementById("edit_author").value = this.dataset.author;
        document.getElementById("edit_category").value = this.dataset.category;
        document.getElementById("edit_isbn").value = this.dataset.isbn;
        document.getElementById("edit_publish_date").value =
            this.dataset.publish_date;
        document.getElementById("edit_copies").value = this.dataset.copies;
        document.getElementById("edit_current_image").value =
            this.dataset.image;

        // 📌 Show image preview
        const preview = document.getElementById("edit_preview");
        preview.src =
            this.dataset.image && this.dataset.image !== ""
                ? this.dataset.image
                : "../image/default.jpg";

        new bootstrap.Modal(document.getElementById("editBookModal")).show();
    });
});

// 📌 Change preview when selecting new file
document.getElementById("edit_image").addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
        document.getElementById("edit_preview").src = URL.createObjectURL(file);
    }
});

// Active
document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".sidebar .nav-link");
    const currentPage = window.location.pathname.split("/").pop().toLowerCase();

    navLinks.forEach((link) => {
        const linkPage = link
            .getAttribute("href")
            .split("/")
            .pop()
            .toLowerCase();

        if (linkPage === currentPage) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });
});

// Book added success modal
document.addEventListener("DOMContentLoaded", function () {
    const modal = new bootstrap.Modal(document.getElementById("successModal"), {
        keyboard: false,
    });
    modal.show();
    setTimeout(() => {
        modal.hide();
    }, 3000);
});

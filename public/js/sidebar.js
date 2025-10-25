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

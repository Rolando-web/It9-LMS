// profile Logout dropdown
const dropdownButton = document.getElementById("dropdownButton");
const dropdownMenu = document.getElementById("dropdownMenu");

dropdownButton.addEventListener("click", () => {
    dropdownMenu.classList.toggle("hidden");
});

// Close dropdown when clicking outside
document.addEventListener("click", (e) => {
    if (
        !dropdownButton.contains(e.target) &&
        !dropdownMenu.contains(e.target)
    ) {
        dropdownMenu.classList.add("hidden");
    }
});

// Mobile menu functionality
const mobileMenuBtn = document.getElementById("mobileMenuBtn");
const mobileMenu = document.getElementById("mobileMenu");
const mobileMenuPanel = document.getElementById("mobileMenuPanel");
const closeMobileMenu = document.getElementById("closeMobileMenu");

function openMobileMenu() {
    mobileMenu.classList.remove("hidden");
    setTimeout(() => {
        mobileMenuPanel.classList.remove("translate-x-full");
    }, 10);
}

function closeMobileMenuFunc() {
    mobileMenuPanel.classList.add("translate-x-full");
    setTimeout(() => {
        mobileMenu.classList.add("hidden");
    }, 300);
}

mobileMenuBtn.addEventListener("click", openMobileMenu);
closeMobileMenu.addEventListener("click", closeMobileMenuFunc);

// Close menu when clicking outside
mobileMenu.addEventListener("click", (e) => {
    if (e.target === mobileMenu) {
        closeMobileMenuFunc();
    }
});

// Swiper
var swiper1 = new Swiper(".mySwiper1", {
    slidesPerView: 1.2,
    spaceBetween: 20,
    pagination: {
        el: ".mySwiper1 .swiper-pagination",
        clickable: true,
    },
    freeMode: true,
    grabCursor: true,
    breakpoints: {
        640: {
            slidesPerView: 2.5,
        },
        1024: {
            slidesPerView: 4,
        },
    },
});

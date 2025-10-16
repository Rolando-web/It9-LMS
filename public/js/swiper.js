var swiper1 = new Swiper(".mySwiper1", {
    slidesPerView: 1.2, // small preview of next card
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

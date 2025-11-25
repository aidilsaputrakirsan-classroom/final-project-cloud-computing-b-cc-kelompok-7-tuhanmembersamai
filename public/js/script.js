document.addEventListener("DOMContentLoaded", function () {
    // Swiper initialization
    const swiperContainer = document.querySelector(".mySwiper");
    if (swiperContainer) {
        var swiper = new Swiper(swiperContainer, {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "3",
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 300,
                modifier: 1,
                slideShadows: true,
            },
            navigation: {
                nextEl: swiperContainer.querySelector(".swiper-button-next"),
                prevEl: swiperContainer.querySelector(".swiper-button-prev"),
            },
            loop: true,
        });
    }

    // Cek apakah ini adalah route landing berdasarkan URL atau route name
    const currentPath = window.location.pathname;

    // Sesuaikan '/' dengan path route landing Anda
    if (currentPath === "/" || currentPath === "/eksplorasi") {
        const header = document.querySelector("header");
        if (header) {
            window.addEventListener("scroll", () => {
                const scrollPosition = window.scrollY > 0;
                header.classList.toggle("scrolling-active", scrollPosition);
            });
        }
    }

    // Comment button toggle
    const commentButton = document.getElementById("commentButton");
    if (commentButton) {
        commentButton.addEventListener("click", function () {
            const textareaDiv = document.querySelector(".textarea");
            if (textareaDiv) {
                textareaDiv.classList.toggle("textarea-hidden");
            }
        });
    }

    // Menu button toggle
    const btnKarya = document.getElementById("btn-karya");
    const btnTentang = document.getElementById("btn-tentang");
    const myArtworks = document.querySelector(".my-artworks");
    const aboutMe = document.querySelector(".about-me");

    if (btnKarya && btnTentang && myArtworks && aboutMe) {
        btnKarya.addEventListener("click", function () {
            myArtworks.style.display = "block";
            aboutMe.style.display = "none";
            btnKarya.classList.add("active");
            btnTentang.classList.remove("active");
        });

        btnTentang.addEventListener("click", function () {
            myArtworks.style.display = "none";
            aboutMe.style.display = "block";
            btnTentang.classList.add("active");
            btnKarya.classList.remove("active");
        });
    }
});

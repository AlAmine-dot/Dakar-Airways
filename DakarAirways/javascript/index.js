let menu = document.querySelector("#menu-bars");
let navbar = document.querySelector(".navbar");
let sections = document.querySelectorAll("section");
let navLinks = document.querySelectorAll("header .navbar a");
const modal = document.getElementById("login-modal");
const openBtn = document.querySelector(".modal-open-btn");
const closeBtn = document.querySelector(".close-btn");

// console.log(modal);
// console.log(openBtn);
// console.log(closeBtn);

function loader() {
  document.querySelector(".loader-container").classList.add("fade-out");
}

function fadeOut() {
  setInterval(loader, 3000);
}

menu.addEventListener("click", () => {
  menu.classList.toggle("fa-times");
  navbar.classList.toggle("active");
});

window.addEventListener("scroll", () => {
  menu.classList.remove("fa-times");
  navbar.classList.remove("active");

  // scrollspy :

  //   sections.forEach((section) => {
  //     let top = window.scrollY;
  //     let height = section.offsetHeight;
  //     let offset = section.offsetTop - 150;
  //     let id = section.getAttribute("id");

  //     if (top >= offset && top < offset + height) {
  //       navLinks.forEach((links) => {
  //         links.classList.remove("active");
  //         document
  //           .querySelector(`header .navbar a[href*='${id}'`)
  //           .classList.add("active");
  //       });
  //     }
  //   });
});

// Search section

document.querySelector("#search-icon").addEventListener("click", () => {
  document.querySelector("#search-form").classList.toggle("active");
});

document.querySelector("#close").addEventListener("click", () => {
  document.querySelector("#search-form").classList.remove("active");
});

// Swiper section

// Swiper section

var swiper = new Swiper(".home-slider", {
  spaceBetween: 30,
  centeredSlides: true,
  autoplay: {
    delay: 7500,
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  loop: true,
});

var swiper = new Swiper(".review-slider", {
  spaceBetween: 20,
  centeredSlides: true,
  autoplay: {
    delay: 7500,
    disableOnInteraction: false,
  },
  loop: true,
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    640: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 3,
    },
  },
});

// // Loader

window.onload = fadeOut;

/* ############ MODAL CONTENT ########## */

// Click events

openBtn.addEventListener("click", () => {
  modal.style.display = "block";
});

openBtn.addEventListener("click", () => {
  modal.style.display = "block";
});

closeBtn.addEventListener("click", () => {
  modal.style.display = "none";
});

window.addEventListener("click", (e) => {
  if (e.target == modal) {
    modal.style.display = "none";
  }
});

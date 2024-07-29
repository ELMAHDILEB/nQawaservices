// Dark Mode
var isDarkTheme = localStorage.getItem("darkTheme") === "true";
let body = document.body;
var icon = document.getElementById("icon");

if (isDarkTheme) {
  body.classList.add("dark__theme");
  icon.className = "fa-solid fa-sun";
} else {
  body.classList.remove("dark__theme");
  icon.className = "fa-solid fa-moon";
}

icon.onclick = function() {
  body.classList.toggle("dark__theme");
  localStorage.setItem("darkTheme", body.classList.contains("dark__theme"));
  if (body.classList.contains("dark__theme")) {
      icon.className = "fa-solid fa-sun";
  } else {
      icon.className = "fa-solid fa-moon";
  }
};

// Responsive Menu
let closeMenu = document.querySelector(".closeMenu");
let openMenu = document.querySelector(".openMenu");
let menu = document.querySelector(".list");
let menuMobile = document.querySelector(".mobile");

function show() {
    menuMobile.style.transform = "translateX(0%)";
}

function hide() {
    menuMobile.style.transform = "translateX(-1000%)";
}
// Show And Hide SideBar
let sidebar = document.querySelector(".sidebar");
let closeSidebar = document.querySelector(".closeSidebar");
let openSidebar = document.querySelector(".openSidebar");

function showSidebar() {
    sidebar.style.transform = "translateX(0%)";
}

function hideSidebar() {
    sidebar.style.transform = "translateX(-100%)";
}
// DropDown Menu
let dropBtns = document.querySelectorAll('.dropBtn');
        let dropdownContents = document.querySelectorAll('.dropdown-content');

        dropBtns.forEach(function(dropBtn, index) {
            let dropdownContent = dropdownContents[index];

            dropBtn.addEventListener("click", function(event) {
                event.preventDefault(); 

                if (dropdownContent.style.display === "flex") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "flex";
                }
            });
        });

 // Scroll To Top
 let icon__scroll = document.querySelector(".scroll");
 let header = document.getElementById("header");
 window.addEventListener("DOMContentLoaded", () => {
     window.addEventListener("scroll", () => {
         document.documentElement.scrollTop >= 150 ? icon__scroll.style.cssText = `opacity: 1; visibility: visible;` : icon__scroll.style.cssText = `opacity: 0; visibility: hidden;`;
         document.documentElement.scrollTop > 0 ? header.classList.add("shadow") : header.classList.remove("shadow");
     })
 })

 icon__scroll.addEventListener("click", () => {
     window.scrollTo({
         behavior: 'smooth',
         top: 0
     })
 })
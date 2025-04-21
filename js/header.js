window.addEventListener("scroll", function () {
    let nav = document.querySelector(".top-nav");

    if (window.scrollY === 0) {
        // display top-nav when scroll to highest
        nav.classList.remove("hidden");
    } else {
        nav.classList.add("hidden");
    }
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".nav-item[data-link]").forEach(function (element) {
        element.addEventListener("click", function () {
            let link = this.getAttribute("data-link");

            if (link) {
                window.location.href = link;
            }
        });
    });



    // 侧边栏菜单逻辑
    const menuToggle = document.getElementById("menuToggle");
    const sideMenu = document.getElementById("sideMenu");
    const closeMenu = document.getElementById("closeMenu");
    const overlay = document.getElementById("overlay");

    function openMenu() {
        console.log("s")
        sideMenu.classList.add("open");
        overlay.classList.add("show");
    }

    function closeMenuFunc() {
        sideMenu.classList.remove("open");
        overlay.classList.remove("show");
    }

    menuToggle.addEventListener("click", openMenu);
    closeMenu.addEventListener("click", closeMenuFunc);
    overlay.addEventListener("click", closeMenuFunc);
});


// Header dynamic layout
$(() => {
    const header = $('header');
    if (header.length) {
        // body padding-top随header高度变化，避免内容被header遮住
        $('body').css('padding-top', (header.outerHeight() / 2) + 'px');
    }
});
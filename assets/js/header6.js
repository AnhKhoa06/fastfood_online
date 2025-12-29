document.querySelectorAll(".menu button").forEach((btn) => {
  btn.addEventListener("click", function () {
    // Xóa class active ở tất cả
    document
      .querySelectorAll(".menu button")
      .forEach((b) => b.classList.remove("active"));
    // Thêm class active cho nút vừa bấm
    this.classList.add("active");
  });
});

// Highlight active danh mục trong dropdown dựa trên URL
document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const currentCategory = urlParams.get("category");

  if (currentCategory) {
    const items = document.querySelectorAll(".mega-dropdown .dropdown-item");
    items.forEach((item) => {
      const href = item.getAttribute("href");
      if (href.includes(`category=${currentCategory}`)) {
        item.classList.add("active");
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const navb = document.querySelector(".navb");
  const megaDropdown = document.querySelector(".mega-dropdown");
  let lastScrollTop = 0;

  // Ban đầu: KHÔNG override bất kỳ gì, để CSS gốc (header12.css) áp dụng hoàn toàn
  // Dropdown sẽ hiện đúng vị trí ban đầu (top: 82%, left: 50%, translateX(-50%), margin-left: 150px, v.v.)

  // Chỉ áp dụng ở trang menu.php
  if (window.location.pathname.includes("menu.php")) {
    window.addEventListener("scroll", function () {
      let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

      if (scrollTop > lastScrollTop && scrollTop > 80) {
        // scroll xuống
        navb.style.transform = "translateY(-100%)";
        navb.style.transition = "transform 0.4s ease";

        // Override TỐI THIỂU khi sticky: chỉ set fixed + full width + căn giữa
        // KHÔNG override top/marginTop để tránh nhích lên
        megaDropdown.style.position = "fixed";
        megaDropdown.style.left = "50%";
        megaDropdown.style.transform = "translateX(-50%)";
        megaDropdown.style.marginLeft = "65px"; // bỏ margin 150px để full căn giữa
        megaDropdown.style.width = "100%";
        megaDropdown.style.maxWidth = "2500px";
        megaDropdown.style.zIndex = "999";
        megaDropdown.style.borderRadius = "0 0 0px 0px";
        megaDropdown.style.boxShadow = "0 4px 15px rgba(0,0,0,0.2)";
        megaDropdown.style.opacity = "1";
        megaDropdown.style.visibility = "visible";
      } else if (scrollTop <= 80) {
        // scroll lên đầu
        navb.style.transform = "translateY(0)";

        // Reset về CSS gốc: KHÔNG set top/marginTop, để CSS ban đầu áp dụng
        megaDropdown.style.position = "absolute";
        megaDropdown.style.left = "50%";
        megaDropdown.style.transform = "translateX(-50%)";
        megaDropdown.style.marginLeft = "150px"; // giữ margin gốc
        megaDropdown.style.marginTop = "10px";
        megaDropdown.style.width = "auto";
        megaDropdown.style.maxWidth = "none";
        megaDropdown.style.borderRadius = "0 0 30px 30px";
        megaDropdown.style.boxShadow = "0 10px 30px rgba(0,0,0,0.2)";
        megaDropdown.style.opacity = "1";
        megaDropdown.style.visibility = "visible";
      }

      lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });
  }
});

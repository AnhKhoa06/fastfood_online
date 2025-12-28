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

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

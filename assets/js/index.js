// GIAO HÀNG TẬN NƠI / ĐẾN LẤY - CHUYỂN TAB + ĐỔI PLACEHOLDER
const tabs = document.querySelectorAll(".tab-btn");
const input = document.getElementById("address-input");

tabs.forEach((tab) => {
  tab.addEventListener("click", function () {
    // Xóa active ở tất cả
    tabs.forEach((t) => t.classList.remove("active"));
    // Thêm active cho tab được bấm
    this.classList.add("active");

    // Đổi placeholder theo tab
    if (this.dataset.type === "delivery") {
      input.placeholder = "Nhập địa chỉ giao hàng";
    } else {
      input.placeholder = "Nhập địa chỉ/cửa hàng bạn đến lấy";
    }
  });
});

// Cho phép focus và xóa placeholder khi bấm vào (giống Jollibee thật)
input.addEventListener("focus", function () {
  if (
    this.placeholder === "Nhập địa chỉ giao hàng" ||
    this.placeholder === "Nhập địa chỉ/cửa hàng bạn đến lấy"
  ) {
    this.placeholder = "";
    this.style.color = "#000";
  }
});

input.addEventListener("blur", function () {
  if (this.value === "") {
    const activeTab = document.querySelector(".tab-btn.active").dataset.type;
    this.placeholder =
      activeTab === "delivery"
        ? "Nhập địa chỉ giao hàng"
        : "Nhập địa chỉ/cửa hàng bạn đến lấy";
    this.style.color = "#888";
  }
});

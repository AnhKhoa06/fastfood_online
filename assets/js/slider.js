const slider = document.querySelector(".slider");
const wrapper = document.querySelector(".slider-wrapper");
const prev = document.querySelector(".prev-btn");
const next = document.querySelector(".next-btn");
const dotsContainer = document.querySelector(".progress-bars");
const slides = document.querySelectorAll(".slide"); // <<< THÊM DÒNG NÀY

let idx = 0;
const total = slides.length;

// Clone slide đầu & cuối để lướt vô tận
const first = slides[0].cloneNode(true);
const last = slides[total - 1].cloneNode(true);
slider.appendChild(first);
slider.insertBefore(last, slider.firstChild);

// Tạo dots
for (let i = 0; i < total; i++) {
  const dot = document.createElement("span");
  if (i === 0) dot.classList.add("active");
  dot.onclick = () => goTo(i);
  dotsContainer.appendChild(dot);
}
const dots = dotsContainer.children;

// Di chuyển + cập nhật active slide + dots
function slide() {
  slider.style.transition = "transform 0.7s ease-in-out";
  slider.style.transform = `translateX(${-(idx + 1) * 100}%)`;

  updateActiveSlide(); // <<< THÊM: đánh dấu slide chính giữa
  updateDots();
}

// === THÊM MỚI: Đánh dấu slide chính giữa là .active (sắc nét) ===
function updateActiveSlide() {
  const realIdx = (idx + total) % total; // chỉ số slide thật (0 đến total-1)
  document.querySelectorAll(".slide").forEach((s, i) => {
    // Vì có clone ở đầu nên slide thật thứ realIdx nằm ở vị trí i = realIdx + 1
    s.classList.toggle("active", i === realIdx + 1);
  });
}

// Cập nhật dots + vòng lặp mượt (giữ nguyên + sửa nhỏ)
function updateDots() {
  const realIdx = (idx + total) % total;
  for (let d of dots) {
    d.classList.remove("active");
    d.style.width = "";
  }
  dots[realIdx].classList.add("active");

  // Vòng lặp không giật
  if (idx === total) {
    setTimeout(() => {
      slider.style.transition = "none";
      idx = 0;
      slider.style.transform = `-100%`;
      updateActiveSlide(); // cập nhật lại active sau khi nhảy
    }, 700);
  }
  if (idx === -1) {
    setTimeout(() => {
      slider.style.transition = "none";
      idx = total - 1;
      slider.style.transform = `-${total * 100}%`;
      updateActiveSlide();
    }, 700);
  }
}

function goTo(n) {
  idx = n;
  slide();
  resetAuto();
}

// Nút
prev.onclick = () => {
  idx--;
  slide();
  resetAuto();
};
next.onclick = () => {
  idx++;
  slide();
  resetAuto();
};

// Auto 3 giây + hover dừng
let auto = setInterval(() => {
  idx++;
  slide();
}, 3000);
function resetAuto() {
  clearInterval(auto);
  auto = setInterval(() => {
    idx++;
    slide();
  }, 3000);
}

wrapper.onmouseenter = () => clearInterval(auto);
wrapper.onmouseleave = resetAuto;

// Khởi động
slider.style.transform = "-100%";
updateActiveSlide(); // <<< quan trọng: khởi động slide đầu tiên sắc nét
updateDots();

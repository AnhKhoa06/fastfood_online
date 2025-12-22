-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
<<<<<<< HEAD
-- Thời gian đã tạo: Th12 20, 2025 lúc 03:38 PM
=======
-- Thời gian đã tạo: Th12 22, 2025 lúc 12:46 PM
>>>>>>> 469296b (Đã làm xong phần quản lý sản phẩm và upload dl lên trang thực đơn)
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `fastfood`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
<<<<<<< HEAD
  `category_id` int(11) NOT NULL,
=======
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL DEFAULT '',
>>>>>>> 469296b (Đã làm xong phần quản lý sản phẩm và upload dl lên trang thực đơn)
  `image` varchar(255) NOT NULL,
  `child_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

<<<<<<< HEAD
INSERT INTO `categories` (`category_id`, `image`, `child_image`) VALUES
(2, 'ga_gion_vui_ve.webp', 'e17856b74b7a0e-titlegagionvuive.webp'),
(3, 'anh2.webp', '0a7c5c03bdcaaf-titlegasotcay.webp'),
(4, 'anh3.webp', 'anh3.1.webp'),
(5, 'anh4.webp', 'anh4.1.webp');
=======
INSERT INTO `categories` (`category_id`, `category_name`, `image`, `child_image`) VALUES
(2, 'ảnh nền 2', 'anh2.webp', 'anh2.1.webp'),
(3, 'ảnh nền 3', 'anh3.webp', 'anh3.1.webp'),
(4, 'ảnh nền 4', 'anh4.webp', 'anh4.1.webp'),
(5, 'ảnh nền 1', 'anh1_1766311085_83a438c2.webp', 'anh1.2_1766311085_34a35be4.webp'),
(6, 'THỨC UỐNG', 'menu8_1766311296_09c19767.webp', 'anhtrang_1766311296_b4e572ea.png'),
(7, 'MÓN TRÁNG MIỆNG', 'menu7.webp', 'anhtrang_1766311519_9d31a883.png'),
(8, 'PHẦN ĂN PHỤ', 'menu6.webp', 'anhtrang_1766311547_68847cc0.png'),
(9, 'BURGER.COM', 'menu5.webp', 'anhtrang_1766311570_b83a1b4b.png'),
(10, 'GÀ SỐT CAY', 'menu4.webp', 'anhtrang_1766311593_82cb3175.png'),
(11, 'MỲ JOLLY', 'menu3.webp', 'anhtrang_1766311613_1f239bb4.png'),
(12, 'GÀ GIÒN VUI VẺ', 'menu2.webp', 'anhtrang_1766311641_4d8c154d.png'),
(13, 'MÓN NGON PHẢI THỬ', 'menu1_1766311674_26076a88.webp', 'anhtrang_1766311674_1e47b2a4.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `prd_id` int(11) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `prd_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `additional_options` text DEFAULT NULL,
  `quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`prd_id`, `category_id`, `prd_name`, `image`, `price`, `description`, `additional_options`, `quantity`) VALUES
(2, 12, '2 MIẾNG GÀ GIÒN VUI VẺ', 'mon1.webp', 65000.00, '2 miếng gà và tương ớt', 'coca', 10),
(3, 11, '1 Mì Ý Jolly vừa + 1 Gà Giòn Vui Vẻ + 1 Khoai tây chiên vừa + 1 Nước ngọt', 'mon2.jpg', 75000.00, '1 Mì Ý Jolly vừa + 1 Gà Giòn Vui Vẻ + 1 Khoai tây chiên vừa + 1 Nước ngọt', 'nước coca', 12),
(4, 10, '2 miếng Gà Sốt Cay', 'mon3.jpg', 90000.00, '2 miếng Gà Sốt Cay', '2 miếng Gà Sốt Cay', 5),
(5, 9, '1 Burger Tôm + 1 Khoai tây chiên vừa + 1 Nước ngọt', 'mon4.webp', 99000.00, '1 Burger Tôm + 1 Khoai tây chiên vừa + 1 Nước ngọt', '1 Burger Tôm + 1 Khoai tây chiên vừa + 1 Nước ngọt', 14);
>>>>>>> 469296b (Đã làm xong phần quản lý sản phẩm và upload dl lên trang thực đơn)

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `address`, `password`, `is_admin`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', 1, '2025-12-11 16:59:45'),
(4, 'khoadzvcl', 'anhkhoa2406@gmail.com', '0357937048', NULL, 'e10adc3949ba59abbe56e057f20f883e', 0, '2025-12-11 17:49:23'),
(5, 'khoapro2k55', 'anhkhoale1998@gmail.com', '01122334455', NULL, 'e10adc3949ba59abbe56e057f20f883e', 0, '2025-12-11 17:51:53'),
<<<<<<< HEAD
(6, 'Anh Khoa', 'khoadeptrai2025@gmail.com', '0999888777', '237 Thanh Niên, Phường Quang Trung, Thành phố Quy Nhơn, Tỉnh Bình Định', 'e10adc3949ba59abbe56e057f20f883e', 0, '2025-12-11 18:10:59'),
(7, 'khoadzvcl123', 'anhkhoa@gmail.com', '0999888777', NULL, 'e10adc3949ba59abbe56e057f20f883e', 0, '2025-12-16 07:41:28');
=======
(6, 'Anh Khoa', 'khoadeptrai2025@gmail.com', '0999888777', '237 Thanh Niên, Phường Quang Trung, Thành phố Quy Nhơn, Tỉnh Bình Định', 'fcea920f7412b5da7be0cf42b8c93759', 0, '2025-12-11 18:10:59'),
(8, 'naovotrong', 'skajbdkasbdkjbasdkjb@gmail.com', '12983713', NULL, '202cb962ac59075b964b07152d234b70', 0, '2025-12-20 19:15:26');
>>>>>>> 469296b (Đã làm xong phần quản lý sản phẩm và upload dl lên trang thực đơn)

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
<<<<<<< HEAD
=======
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prd_id`),
  ADD KEY `category_id` (`category_id`);

--
>>>>>>> 469296b (Đã làm xong phần quản lý sản phẩm và upload dl lên trang thực đơn)
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
<<<<<<< HEAD
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
=======
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `prd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
>>>>>>> 469296b (Đã làm xong phần quản lý sản phẩm và upload dl lên trang thực đơn)

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

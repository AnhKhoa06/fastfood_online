-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 20, 2025 lúc 03:38 PM
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
  `category_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `child_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `image`, `child_image`) VALUES
(2, 'ga_gion_vui_ve.webp', 'e17856b74b7a0e-titlegagionvuive.webp'),
(3, 'anh2.webp', '0a7c5c03bdcaaf-titlegasotcay.webp'),
(4, 'anh3.webp', 'anh3.1.webp'),
(5, 'anh4.webp', 'anh4.1.webp');

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
(6, 'Anh Khoa', 'khoadeptrai2025@gmail.com', '0999888777', '237 Thanh Niên, Phường Quang Trung, Thành phố Quy Nhơn, Tỉnh Bình Định', 'e10adc3949ba59abbe56e057f20f883e', 0, '2025-12-11 18:10:59'),
(7, 'khoadzvcl123', 'anhkhoa@gmail.com', '0999888777', NULL, 'e10adc3949ba59abbe56e057f20f883e', 0, '2025-12-16 07:41:28');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

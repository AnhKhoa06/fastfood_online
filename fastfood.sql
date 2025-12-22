-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 22, 2025 lúc 04:48 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

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
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL,
  `child_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `image`, `child_image`) VALUES
(2, 'ảnh nền 2', 'anh2.webp', 'anh2.1_1766411423_bb320f80.webp'),
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
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`news_id`, `image`, `category`, `title`, `content`, `created_at`) VALUES
(10, 'tt1.jpg', 'JOLLIBEE ĐẠT MỐC 200 CỬA HÀNG TẠI THỊ TRƯỜNG VIỆT NAM', 'Sự kiện khai trương cửa hàng thứ 200 là cột mốc quan trọng trong kế hoạch mở rộng kinh...', '<h2><strong>Jollibee đạt mốc 200 cửa hàng tại thị trường Việt Nam</strong></h2><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p><i><strong>Sự kiện khai trương cửa hàng thứ 200 là cột mốc quan trọng trong kế hoạch mở rộng kinh doanh và khẳng định vị thế của Jollibee trong thị trường thức ăn nhanh Việt Nam.</strong></i></p><p><strong>Cột mốc đáng nhớ</strong></p><p>Ngày 12/12/2024, cửa hàng thứ 200 của Jollibee tại địa chỉ 704 Hậu Giang, Phường 12, Quận 6, TP. Hồ Chí Minh đã chính thức đi vào hoạt động. Sự kiện này không chỉ là một cột mốc đáng nhớ của thương hiệu tại thị trường Việt Nam mà còn là minh chứng rõ nét cho sự tin tưởng và ủng hộ của khách hàng trong suốt những năm qua.</p><figure class=\"image\"><img style=\"aspect-ratio:636/424;\" src=\"https://jollibee.com.vn/media/wysiwyg/TT1.jpg\" alt=\"\" width=\"636\" height=\"424\"></figure><p><i>Hình ảnh khai trương cửa hàng Jollibee Việt Nam thứ 200 tại Quận 6, TP.HCM</i></p><p>Chính thức có mặt tại Việt Nam từ năm 2005, Jollibee đã không ngừng lớn mạnh nhờ chiến lược kinh doanh “chậm mà chắc”. Tính tới thời điểm hiện tại, tập đoàn đã đạt cột mốc&nbsp; 200 cửa hàng và tiếp tục sẽ mở rộng thêm trong năm 2025, giúp Jollibee đến gần hơn với hành trình trở thành chuỗi nhà hàng phục vụ nhanh (Quick Serving Restaurant - QSR) hàng đầu tại Việt Nam.</p><p>Ông Ernesto Tanmantiong, Tổng Giám đốc toàn cầu tập đoàn Jollibee Group, chia sẻ: “<i>Cách đây 20 năm, chúng tôi bắt đầu hành trình tại Việt Nam với sự khiêm tốn và một ước mơ mang niềm vui ẩm thực đến mọi gia đình. Hôm nay, việc đạt cột mốc 200 cửa hàng khiến tôi vô cùng biết ơn niềm tin của người tiêu dùng Việt và sự tận tâm không ngừng nghỉ của đội ngũ Jollibee. Thành công này truyền cảm hứng cho chúng tôi tiếp tục mở rộng và thực hiện sứ mệnh mang niềm vui ăn uống đến nhiều người hơn trên thế giới.”</i></p><p>Ông Lâm Hồng Nguyễn, Tổng Giám Đốc Jollibee Việt Nam nhấn mạnh: <i>“Tình yêu và sự tin tưởng của người tiêu dùng Việt Nam là nền tảng cho thành công của Jollibee tại thị trường này. Chúng tôi không chỉ mang đến những món ăn ngon phù hợp với khẩu vị địa phương mà còn cung cấp dịch vụ tận tâm và trải nghiệm vượt trội. Việc khai trương cửa hàng thứ 200 không chỉ là một dấu mốc đáng nhớ mà còn khẳng định cam kết của chúng tôi trong việc đặt khách hàng làm trọng tâm và phục vụ cộng đồng tốt hơn mỗi ngày.”</i></p><p><i>&nbsp;</i></p><figure class=\"image\"><img style=\"aspect-ratio:639/426;\" src=\"https://jollibee.com.vn/media/wysiwyg/TT2.jpg\" alt=\"\" width=\"639\" height=\"426\"></figure><p><i>“Anh tài” Kay Trần xuất hiện tại sự kiện khai trương cửa hàng thứ 200 tại Jollibee Hậu Giang, Quận 6 thêm sôi động</i></p><p><i><img src=\"https://jollibee.com.vn/media/wysiwyg/TT3.jpg\" alt=\"\" width=\"648\" height=\"432\"></i></p><p><i>Cửa hàng Jollibee Hậu Giang, quận 6 thu hút rất đông khách hàng đến mua hàng trong ngày đầu khai trương</i></p><p>&nbsp;</p><p><strong>Hợp tác với rất nhiều doanh nghiệp</strong></p><p>Thành công không chỉ đến từ chất lượng sản phẩm và dịch vụ mà còn từ sự hợp tác chặt chẽ với các đối tác chiến lược. Buổi khai trương còn có sự tham gia của đại diện đến từ các đối tác quan trọng như: Suntory PepsiCo Việt Nam, Tập đoàn Wilmar CLV, Công ty CPV Food, Tập đoàn Yeah1 và nhiều đối tác quan trọng khác của công ty. Những lời chúc mừng và chia sẻ của các đối tác đã khẳng định tầm quan trọng của mối quan hệ hợp tác này trong sự phát triển của Jollibee.</p><p>Với sự thay đổi không ngừng của thị trường , nhu cầu về các sản phẩm thức ăn nhanh chất lượng ngày càng tăng, Jollibee đã và đang nỗ lực để mở rộng thị trường và củng cố vị thế của mình. Sự hợp tác chiến lược với các đối tác sẽ tiếp tục là động lực để Jollibee chinh phục những mục tiêu mới trong tương lai.</p><p><strong>Thông tin chung</strong></p><p>Jollibee Group là tập đoàn nhà hàng ở Châu Á, sở hữu 19 thương hiệu nổi tiếng và mạng lưới hơn 6.500 cửa hàng tại 32 quốc gia và vùng lãnh thổ.</p><p>Jollibee chính thức gia nhập thị trường Việt Nam vào năm 2005 và từ đó đã không ngừng phát triển. Tính đến tháng 12 năm 2024, Jollibee đã có 200 cửa hàng trên 51 tỉnh thành, cùng với một nhà máy sản xuất hiện đại đạt chứng nhận ISO 22000:2018 tại Khu công nghiệp Tân Kim Mở rộng, Cần Giuộc, Long An.</p><p>Với sứ mệnh mang đến niềm vui qua ẩm thực, Jollibee luôn đặt khách hàng làm trọng tâm, cung cấp những món ăn chất lượng với giá cả hợp lý. Thương hiệu không ngừng hướng tới dịch vụ xuất sắc và được cộng đồng trân quý.</p><p>Thành công của thương hiệu tại Việt Nam được khẳng định qua nhiều giải thưởng danh giá, như Top 5 Công ty Dịch vụ Ăn uống Uy tín nhất Việt Nam 2024 (hạng mục Chuỗi Nhà hàng, Dịch vụ Ăn uống và Nhượng quyền), Top 100 Nơi Làm việc Tốt nhất Việt Nam 2023 (doanh nghiệp quy mô vừa) do Anphabe bình chọn, và Giải Bạc BSI cho Dự án CSR năm 2024. Tập đoàn đóng góp cho xã hội, như chương trình <strong>“Triệu yêu thương tiếp bước em đến trường</strong>” phối hợp cùng Quỹ Bảo vệ Trẻ em Việt Nam, trao tặng học bổng và xe đạp cho trẻ em có</p><h3><strong>Website: http://www.jollibee.com.vn/</strong></h3><p><strong>Official Facebook Page:</strong> <strong>https://www.facebook.com/JollibeeVietnam</strong></p>', '2025-12-22 21:44:25'),
(11, 'tt2.jpg', 'HỢP TÁC BỀN VỮNG GIÚP JOLLIBEE PHÁT TRIỂN TẠI VIỆT NAM SAU HAI THẬP KỶ', 'Việc có chung mục tiêu và mối quan hệ hợp tác chặt chẽ với các đối tác giúp Jollibee Việt...', '<h2><strong>Hợp tác bền vững giúp Jollibee phát triển tại Việt Nam sau hai thập kỷ</strong></h2><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>Việc có chung mục tiêu và mối quan hệ hợp tác chặt chẽ với các đối tác giúp Jollibee Việt Nam phát triển bền bỉ suốt gần 20 năm qua.</p><p>Jollibee Việt Nam ra mắt vào năm 2005. Từ những ngày đầu, doanh nghiệp có sự đồng hành của các đối tác tại Việt Nam. Trong đó, Tập đoạn Wilmar (đơn vị cung cấp các nguyên liệu thực phẩm như: dầu ăn, bột mỳ, gạo và tương sốt đạt tiêu chuẩn quốc tế), góp phần giúp Jollibee giữ vững chất lượng thực đơn trong suốt nhiều năm liền.</p><p>Đại diện Tập đoàn Wilmar CLV cho biết trân trọng về mối quan hệ hợp tác chiến lược với Jollibee Việt Nam trong những năm qua, đồng thời khẳng định mối quan hệ hợp tác này không chỉ thúc đẩy sự phát triển của hai bên mà còn tạo nên những giá trị bền vững lâu dài.</p><p>“Chúng tôi đánh giá cao sự cam kết của Jollibee trong việc duy trì chất lượng và không ngừng đổi mới để mang đến trải nghiệm tốt nhất cho khách hàng”, đại diện Tập đoàn Wilmar CLV nói.</p><p>Theo vị đại diện, tiềm năng hợp tác giữa hai bên trong tương lai rất lớn, đặc biệt với tốc độ mở rộng mạnh mẽ và chiến lược phát triển bền vững của Jollibee. Với tầm nhìn dài hạn tại Việt Nam, doanh nghiệp này cam kết tiếp tục cung cấp những sản phẩm chất lượng cao với giá thành cạnh tranh nhất và mong muốn đồng hành cùng thương hiệu thức ăn nhanh trong việc đổi mới, tối ưu hóa chi phí và đáp ứng tốt hơn nhu cầu ngày càng cao của người tiêu dùng Việt Nam.</p><figure class=\"image\"><img style=\"aspect-ratio:765/536;\" src=\"https://jollibee.com.vn/media/wysiwyg/WEB_200STORE-02.jpg\" alt=\"\" width=\"765\" height=\"536\"></figure><p>Cửa hàng Jollibee tại 704 Đường Hậu Giang, Phường 12, Quận 6, Hồ Chí Minh Ảnh: <i>Jollibee Việt Nam</i></p><p>Ngoài Tập đoàn Wilmar CLV, Tập đoàn Suntory PepsiCo Việt Nam cũng găn bó với Jollibee Việt Nam từ những ngày đầu. Ông Jahanzeb Khan - Giám đốc điều hành SPVB, cho biết hai doanh nghiệp cùng có điểm chung về mục tiêu là mang đến cho người tiêu dùng Việt Nam trải nghiệm ẩm thực vui vẻ, chất lượng, thoải mái bên gia đình và bè bạn.</p><p>Không chỉ hợp tác trong lĩnh vực kinh doanh, Suntory PepsiCo Việt Nam và Jollibee còn chung tay “đóng góp lại cho xã hội” qua nhiều hoạt động ý nghĩa nhằm nâng cao chất lượng cuộc sống, lan tỏa những giá trị tốt đẹp đến với người Việt như: chuỗi sự kiện “The Jolly Tour” trong năm 2023 và 2024 vừa qua. Mối quan hệ hợp tác này cho thấy tầm quan trọng của việc tìm kiếm những đối tác có thể bổ sung cho nhau về sản phẩm, dịch vụ và thị trường.</p><p><i>“</i>Suntory PepsiCo Việt Nam cam kết sẽ tiếp tục đồng hành cùng Jollibee, không ngừng đổi mới và lan tỏa niềm vui đến người tiêu dùng”, ông Jahanzeb Khan khẳng định thêm về mối quan hệ hợp tác bền chặt với Jollibee.</p><p>Là một trong những đối tác của Jollibee trong nhiều năm qua, đại diện Công ty Cổ phần Chăn nuôi C.P. Việt Nam nhận định Jollibee là đối tác “QSR global chain (Chuỗi nhà hàng phục vụ nhanh quy mô toàn cầu) có sự tăng trưởng và lớn mạnh nhanh chóng. Đây cũng là đối tác tin cậy, có tầm nhìn chiến lược lâu dài trong việc đầu tư phát triển kinh doanh tại thị trường Việt Nam, định hướng phát triển kinh doanh song song với việc phát triển bền vững.</p><p>“Hai đối tác đã tìm thấy nhau cùng xây dựng, phát triển kinh doanh tại thị trường Việt Nam giàu tiềm năng phát triển. C.P. Việt Nam sẽ cùng đồng hành với Jollibee Việt Nam chinh phục các cột mốc thách thức tiếp theo để phục vụ người tiêu dùng các sản phẩm an toàn chất lượng theo tiêu chuẩn quốc tế và bền vững”, đại diện C.P Việt Nam khẳng định.</p><p>Theo đại diện Jollibee Việt Nam, bằng cách xây dựng mối quan hệ hợp tác bền vững dựa trên sự tin tưởng và lợi ích chung với các đối tác, Jollibee không chỉ góp phần thúc đẩy sự phát triển chung của thương hiệu tại Việt Nam và đối tác mà còn cam kết cùng đem đến những sản phẩm tốt nhất cho khách hàng, đóng góp giá trị tích cực cho của cộng đồng.</p><figure class=\"image\"><img style=\"aspect-ratio:640/480;\" src=\"https://jollibee.com.vn/media/wysiwyg/VN2.png\" alt=\"\" width=\"640\" height=\"480\"></figure><p>Jollibee Việt Nam thực hiện dự án “Triệu yêu thương tiếp bước em đến trường” tại trường Phìn Chải B, &nbsp;xã Vần Chải, huyện Đồng Văn, tỉnh Hà Giang trong năm 2024</p><p>Bên cạnh tập trung xây dựng nền tảng kinh doanh phát triển bền vững, trong nhiều năm qua, Jollibee Việt Nam còn là một trong những doanh nghiệp có nhiều đóng góp cho xã hội. Điều này được thực hiện thông qua những hoạt động, chương trình như “Triệu yêu thương tiếp bước em đến trường”; “Triệu khoảnh khắc gà giòn vui vẻ”... phối hợp cùng quỹ Bảo vệ trẻ em Việt Nam, xây dựng lớp học, trao tặng học bổng và xe đạp cho trẻ em có hoàn cảnh khó khăn.</p><p>“Hành trình của Jollibee tại Việt Nam không chỉ là câu chuyện mở rộng và phát triển mà còn là cam kết bền vững trong việc lan tỏa niềm vui và kết nối các gia đình qua những trải nghiệm ẩm thực tuyệt vời”, đại diện doanh nghiệp cho biết.</p><figure class=\"image\"><img style=\"aspect-ratio:788/552;\" src=\"https://jollibee.com.vn/media/wysiwyg/WEB_200STORE-01.jpg\" alt=\"\" width=\"788\" height=\"552\"></figure><p>Jollibee hiện có hơn 200 cửa hàng trên 51 tỉnh thành tại Việt Nam. Ảnh: <i>Jollibee Việt Nam</i></p><p>Jollibee Group là tập đoàn nhà hàng lớn ở châu Á, sở hữu 19 thương hiệu nổi tiếng và mạng lưới hơn 6.500 cửa hàng tại 32 quốc gia và vùng lãnh thổ. Jollibee gia nhập thị trường Việt Nam vào năm 2005 và từ đó&nbsp; không ngừng phát triển.</p><p>Tính đến tháng 12/2024, thương hiệu có hơn 200 cửa hàng trên 51 tỉnh thành và một nhà máy sản xuất hiện đại đạt chứng nhận ISO 22000:2018 tại Khu công nghiệp Tân Kim Mở rộng, Cần Giuộc, Long An.</p><p>Jollibee là một trong số các công ty theo mô hình chuỗi nhà hàng phục vụ nhanh QSR (Quick Serving Restaurant) sở hữu nhà máy sản xuất riêng biệt, khép kín để cung cấp cho chuỗi cửa hàng bán lẻ. Việc sở hữu nhà máy sản xuất không chỉ giúp Jollibee chủ động quản lý chất lượng nguồn nguyên liệu, thành phẩm mà còn đảm bảo sự đồng nhất về sản phẩm trên toàn bộ hệ thống.</p><p>Ông Ernesto Tanmantiong, Tổng giám đốc toàn cầu Tập đoàn Jollibee Group, chia sẻ cách đây 20 năm, thương hiệu bắt đầu hành trình tại Việt Nam với sự khiêm tốn và một ước mơ mang niềm vui ẩm thực đến mọi gia đình. Việc đạt cột mốc 200 cửa hàng cho thấy niềm tin của người tiêu dùng Việt và sự tận tâm không ngừng nghỉ của đội ngũ Jollibee.</p><p>“Thành công này truyền cảm hứng cho chúng tôi tiếp tục mở rộng và thực hiện sứ mệnh mang niềm vui ăn uống đến nhiều người hơn trên thế giới”, ông nói.</p><p>Uy tín của Jollibee tại Việt Nam được khẳng định qua nhiều giải thưởng, như: Top 5 Công ty dịch vụ ăn uống uy tín nhất Việt Nam 2024 (hạng mục Chuỗi nhà hàng, Dịch vụ ăn uống và nhượng quyền), Top 100 nơi làm việc tốt nhất Việt Nam 2023 (doanh nghiệp quy mô vừa) do Anphabe bình chọn, và Giải Bạc BSI cho Dự án CSR năm 2024.</p><p>(Nguồn: <i>Jollibee Việt Nam</i>)</p>', '2025-12-22 21:48:45'),
(12, 'tt3.jpg', 'JOLLIBEE VIỆT NAM KHAI TRƯƠNG CỬA HÀNG THỨ 191', 'Vào ngày 17/05/2024, tại tuyến phố Mê Linh sầm uất của phường Liên Bảo, thành...', '<h2><strong>JOLLIBEE VIỆT NAM KHAI TRƯƠNG CỬA HÀNG THỨ 191</strong></h2><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>Vào ngày&nbsp;17/05/2024,&nbsp;tại tuyến phố Mê&nbsp;Linh&nbsp;sầm uất của phường Liên Bảo, thành phố Vĩnh Yên, Jollibee Mê&nbsp;Linh chính thức khai trương, đánh dấu cột mốc sau 14 năm khai trương cửa hang thứ 2 tại Vĩnh Phúc.</p><p>Từ cửa hàng đầu tiên tại BigC Vĩnh Phúc được mở vào năm 2010, cho đến hôm nay, cửa hàng mặt phố đầu tiên đã được ra đời, với không gian trải nghiệm hoàn toàn mới lạ và đầy sắc màu, ghi dấu ấn cửa hàng 191 của Jollibee Việt Nam. &nbsp;</p><figure class=\"image\"><img src=\"https://jollibee.com.vn/media/wysiwyg/thumbnail.jpg\" alt=\"\" width=\"462\"></figure><p>Cửa hàng Jollibee Mê Linh, Vĩnh Phúc</p><p>&nbsp;</p><p>Jollibee là một thương hiệu nổi tiếng thế giới với sản phẩm Gà Giòn Vui Vẻ (Chickenjoy) với hơn 1500 cửa hàng hoạt động tại hơn 17 quốc gia và vùng lãnh thổ trên thế giới. Thương hiệu này thuộc công ty kinh doanh trong lĩnh vực nhà hàng lớn nhất châu Á - Jollibee Foods Corporation.</p><p>Anh Lâm Hồng Nguyễn - Tổng giám đốc Công ty TNHH Jollibee Việt Nam cho biết, hơn 15 năm hoạt động tại Việt Nam Jollibee đã và đang bền bỉ theo đuổi nhiệm vụ mang đến hạnh phúc và lan toả niềm vui ẩm thực cho mọi gia đình bằng việc phục vụ những món ăn ngon vượt trội với giá hợp lý; luôn nhấn mạnh đến việc lấy khách hàng làm trọng tâm.</p>', '2025-12-22 21:49:26'),
(13, 'tt4.jpg', 'Jollibee Việt Nam khai trương cửa hàng thứ 150', 'Jollibee Việt Nam đã đưa vào vận hành nhà máy mới với chứng nhận ISO 22000:2018 về...', '<h2><strong>Jollibee Việt Nam khai trương cửa hàng thứ 150</strong></h2><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><h2>JOLLIBEE KHAI TRƯƠNG CỬA HÀNG THỨ 150</h2><p>Ngày 19/3, Jollibee Việt Nam đã chính thức khai trương cửa hàng thứ 150 tại địa chỉ 254 Đống Đa, phường Thuận Phước, quận Hải Châu, Thành phố Đà Nẵng và cửa hàng này cũng là cửa hàng thứ 7 của chuỗi đang hoạt động tại Đà Nẵng.</p><figure class=\"image\"><img style=\"aspect-ratio:521/347;\" src=\"https://jollibee.com.vn/media/wysiwyg/Capture_1.PNG\" alt=\"\" width=\"521\" height=\"347\"></figure><p>Hình ảnh khai trương cửa hàng Jollibee thứ 150. Ảnh: Jollibee</p><p>Để kỷ niệm dấu mốc quan trọng này, Jollibee đã tổ chức một sự kiện kết hợp giữa offline và online nhằm mục đích lan toả được những niềm vui bất tận của ngày khai trương đến với tất cả các khách hàng yêu quý của mình trên cả nước. Đặc biệt tại sự kiện offline Đà Nẵng, khách hàng còn được dịp chiêm ngưỡng khoảnh khắc đáng nhớ với cổng hoa chào mừng tại cửa hàng nở rộ 150 bông hoa tượng trưng cho 150 cửa hàng của Jollibee trên toàn quốc, cổng chào này được trưng bày trong vòng 2 tuần để khách hàng đến tham quan và chụp ảnh.</p><p>Jollibee là một thương hiệu nổi tiếng thế giới với sản phẩm Gà Giòn Vui Vẻ (Chickenjoy) với hơn 1500 cửa hàng hoạt động tại hơn 17 quốc gia và vùng lãnh thổ trên thế giới. Thương hiệu này thuộc công ty kinh doanh trong lĩnh vực nhà hàng lớn nhất châu Á - Jollibee Foods Corporation.</p><p>Ông Lâm Hồng Nguyễn, Tổng giám đốc công ty Jollibee Việt Nam cho biết, hơn 15 năm hoạt động tại Việt Nam Jollibee đã và đang bền bỉ theo đuổi nhiệm vụ mang đến hạnh phúc và lan toả niềm vui ẩm thực cho mọi gia đình bằng việc phục vụ những món ăn ngon vượt trội với giá hợp lý; luôn nhấn mạnh đến việc lấy khách hàng làm trọng tâm.</p>', '2025-12-22 22:37:51');

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
(6, 'Anh Khoa', 'khoadeptrai2025@gmail.com', '0999888777', '237 Thanh Niên, Phường Quang Trung, Thành phố Quy Nhơn, Tỉnh Bình Định', 'fcea920f7412b5da7be0cf42b8c93759', 0, '2025-12-11 18:10:59'),
(8, 'naovotrong', 'skajbdkasbdkjbasdkjb@gmail.com', '12983713', NULL, '202cb962ac59075b964b07152d234b70', 0, '2025-12-20 19:15:26');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

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
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 08, 2026 lúc 08:34 AM
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
-- Cơ sở dữ liệu: `travel_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tour_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `tour_id`, `customer_name`, `customer_phone`, `customer_email`, `total_price`, `status`, `booking_date`) VALUES
(1, 5, 3, 'Trần Thị Huyền', '0123456789', 'huyen@gmail.com', 1200000.00, 'pending', '2026-02-08 06:40:35'),
(2, 5, 5, 'Trần Thị Huyền', '0123456789', 'huyen@gmail.com', 12000000.00, 'cancelled', '2026-02-08 06:46:23'),
(3, 5, 6, 'Trần Thị Huyền', '0123456789', 'huyen@gmail.com', 5000000.00, 'cancelled', '2026-02-08 06:47:54'),
(4, 5, 4, 'Trần Thị Huyền', '0123456789', 'huyen@gmail.com', 15000000.00, 'completed', '2026-02-08 06:55:51'),
(5, 5, 6, 'Trần Thị Huyền', '0123456789', 'huyen@gmail.com', 5000000.00, 'completed', '2026-02-08 07:23:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Tour Biển Đảo', 'tour-bien-dao'),
(2, 'Tour giá rẻ', 'tour-gia-re'),
(3, 'Tour trong nước', 'tour-trong-nuoc'),
(4, 'Tour nước ngoài', 'tour-nuoc-ngoai'),
(5, 'Tour trên núi', 'tour-tren-nui'),
(6, 'Tour trong ngày', 'tour-trong-ngay');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `summary`, `content`, `image`, `created_at`) VALUES
(1, 'Đã nẵng kích cầu du lịch trong năm 2026', 'n-ng-k-ch-c-u-du-l-ch-trong-n-m-2026', 'Đã nẵng kích cầu du lịch trong năm 2026', '<p>Đ&agrave; Nẵng l&agrave; một trong những điểm đến du lịch hấp dẫn nhất Việt Nam, nổi bật với sự kết hợp h&agrave;i h&ograve;a giữa thi&ecirc;n nhi&ecirc;n, văn h&oacute;a v&agrave; hiện đại. Th&agrave;nh phố sở hữu những b&atilde;i biển đẹp như Mỹ Kh&ecirc;, Non Nước với l&agrave;n nước trong xanh v&agrave; bờ c&aacute;t mịn. B&agrave; N&agrave; Hills g&acirc;y ấn tượng với Cầu V&agrave;ng độc đ&aacute;o v&agrave; kh&iacute; hậu m&aacute;t mẻ quanh năm. Ngo&agrave;i ra, Đ&agrave; Nẵng c&ograve;n gần c&aacute;c di sản nổi tiếng như Hội An, Huế, Mỹ Sơn. Ẩm thực phong ph&uacute;, con người th&acirc;n thiện v&agrave; hạ tầng hiện đại khiến Đ&agrave; Nẵng trở th&agrave;nh điểm đến l&yacute; tưởng cho mọi du kh&aacute;ch.</p>\r\n\r\n<p><img alt=\"\" src=\"http://localhost/travel_booking/assets/uploads/1770531742_chuong-trinh-kich-cau-thu-hut-khach-du-lich-den-thanh-pho-da-nang-cac-thang-cuoi-nam-2025-de-da-nang-moi-trai-nghiem-moi-new-da-nang-new-experience-01-1024x576.jpg\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /></p>\r\n', '1770531750_chuong-trinh-kich-cau-thu-hut-khach-du-lich-den-thanh-pho-da-nang-cac-thang-cuoi-nam-2025-de-da-nang-moi-trai-nghiem-moi-new-da-nang-new-experience-01-1024x576.jpg', '2026-02-08 06:22:30'),
(2, 'GIới thiệu di tích chùa bái đính', 'gi-i-thi-u-di-t-ch-ch-a-b-i-nh', 'Khu du lịch chùa bái đính - nơi tận hưởng cảm giác trong lành thu hút du khách khắp nơi', '<p><img alt=\"\" src=\"http://localhost/travel_booking/assets/uploads/1770531879_dji202305271839200167d-1754880862074799106427.webp\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /></p>\r\n\r\n<p>Ch&ugrave;a B&aacute;i Đ&iacute;nh nằm tại tỉnh Ninh B&igrave;nh, l&agrave; quần thể ch&ugrave;a lớn v&agrave; nổi tiếng bậc nhất Việt Nam. Nơi đ&acirc;y thu h&uacute;t du kh&aacute;ch bởi kiến tr&uacute;c đồ sộ, h&agrave;i h&ograve;a giữa n&eacute;t truyền thống v&agrave; hiện đại. Ch&ugrave;a sở hữu nhiều kỷ lục như tượng Phật bằng đồng lớn, h&agrave;nh lang La H&aacute;n d&agrave;i v&agrave; th&aacute;p chu&ocirc;ng uy nghi. Kh&ocirc;ng gian ch&ugrave;a rộng lớn, y&ecirc;n b&igrave;nh, bao quanh bởi n&uacute;i non v&agrave; thi&ecirc;n nhi&ecirc;n xanh m&aacute;t. Đến với ch&ugrave;a B&aacute;i Đ&iacute;nh, du kh&aacute;ch kh&ocirc;ng chỉ chi&ecirc;m b&aacute;i, cầu an m&agrave; c&ograve;n c&oacute; cơ hội kh&aacute;m ph&aacute; văn h&oacute;a, lịch sử v&agrave; t&igrave;m lại sự thanh tịnh trong t&acirc;m hồn.</p>\r\n\r\n<p><img alt=\"\" src=\"http://localhost/travel_booking/assets/uploads/1770531892_chua-bai-dinh_68a0743d01fe7.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /></p>\r\n', '1770531897_dji202305271839200167d-1754880862074799106427.webp', '2026-02-08 06:24:57'),
(3, 'Trải nghiệm vịnh hạ long mùa lễ', 'tr-i-nghi-m-v-nh-h-long-m-a-l', 'Trải nghiệm vịnh hạ long mùa lễ', '<p>Vịnh Hạ Long thuộc tỉnh Quảng Ninh, l&agrave; một trong những kỳ quan thi&ecirc;n nhi&ecirc;n nổi tiếng của Việt Nam v&agrave; thế giới. Vịnh g&acirc;y ấn tượng với h&agrave;ng ngh&igrave;n h&ograve;n đảo đ&aacute; v&ocirc;i mang h&igrave;nh d&aacute;ng độc đ&aacute;o, nổi bật tr&ecirc;n l&agrave;n nước xanh biếc. Du kh&aacute;ch đến đ&acirc;y c&oacute; thể tham quan hang động kỳ ảo, ch&egrave;o thuyền kayak, tắm biển v&agrave; nghỉ đ&ecirc;m tr&ecirc;n du thuyền. Kh&ocirc;ng chỉ c&oacute; cảnh quan h&ugrave;ng vĩ, Vịnh Hạ Long c&ograve;n gắn liền với nhiều gi&aacute; trị lịch sử v&agrave; văn h&oacute;a đặc sắc, l&agrave; điểm đến l&yacute; tưởng cho những ai y&ecirc;u thi&ecirc;n nhi&ecirc;n v&agrave; kh&aacute;m ph&aacute;.</p>\r\n\r\n<p><img alt=\"\" src=\"http://localhost/travel_booking/assets/uploads/1770531977_kinh-nghiem-du-lich-ha-long-1_1674039271.jpg\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /></p>\r\n', '1770531984_vviqkvkrzeohe12wxjyu.jpg', '2026-02-08 06:26:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tours`
--

CREATE TABLE `tours` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price_base` decimal(15,2) NOT NULL,
  `departure_location` varchar(255) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tours`
--

INSERT INTO `tours` (`id`, `category_id`, `title`, `slug`, `description`, `content`, `image`, `price_base`, `departure_location`, `duration`, `status`, `created_at`) VALUES
(1, 1, 'Khám phá Đảo Phú Quốc', 'kh-m-ph-o-ph-qu-c', 'Tour nghỉ dưỡng tuyệt vời tại đảo ngọc', '<p><img alt=\"\" src=\"http://localhost/travel_booking/assets/uploads/1770530152_Hinh-2.jpg\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /></p>\r\n', '1770530162_1499411915_1494654356_trong nước.jpg', 6000000.00, 'Hà Nội', '3 ngày 2 đêm', 1, '2026-02-08 05:14:30'),
(2, 1, 'Du lịch phú quốc ', 'du-l-ch-ph-qu-c', 'Du lịch phú quốc 4 ngày 3 đêm hấp dẫn', '<p>Đ&acirc;y l&agrave; nội dung test</p>\r\n\r\n<p><img alt=\"\" src=\"http://localhost/travel_booking/assets/uploads/1770530435_311791127_540022854795866_1532164650908642042_n.jpeg\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" />Ngon lu&ocirc;n</p>\r\n', '1770530449_311791127_540022854795866_1532164650908642042_n.jpeg', 10000000.00, 'TP. Hồ Chí Minh', '4 ngày 3 đêm', 1, '2026-02-08 06:00:49'),
(3, 3, 'Tour du lịch tràng an ninh bình hấp dẫn', 'tour-du-l-ch-tr-ng-an-ninh-b-nh-h-p-d-n', '🌸𝐂𝐡𝐢𝐞̂́𝐜 𝐝𝐞𝐚𝐥 𝐧𝐚̀𝐲 𝐝𝐚̀𝐧𝐡 𝐜𝐡𝐨 𝐭𝐢́𝐧 đ𝐨̂̀ 𝐦𝐞̂ 𝐬𝐨̂́𝐧𝐠 𝐚̉𝐨', '<p><strong><img alt=\"🌸\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tc9/1/20/1f338.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" />𝐂𝐡𝐢𝐞̂́𝐜 𝐝𝐞𝐚𝐥 𝐧𝐚̀𝐲 𝐝𝐚̀𝐧𝐡 𝐜𝐡𝐨 𝐭𝐢́𝐧 đ𝐨̂̀ 𝐦𝐞̂ 𝐬𝐨̂́𝐧𝐠 𝐚̉𝐨</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong><img alt=\"\" src=\"http://localhost/travel_booking/assets/uploads/1770530684_ivivu-kdl-trang-an.gif\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /></strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Hiện tại Tr&agrave;ng An Travel đang c&oacute; đầy đủ lịch khởi h&agrave;nh từ Ch&acirc;u &Acirc;u - Ch&acirc;u &Aacute; - Ch&acirc;u Phi với dịch vụ chất lượng,&nbsp;<img alt=\"🌹\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t71/1/16/1f339.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /><img alt=\"🦕\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tad/1/16/1f995.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /></p>\r\n\r\n<ul>\r\n	<li>\r\n	<p><strong>Ch&acirc;u &Acirc;u</strong>: Bắc &Acirc;u, Đ&ocirc;ng T&acirc;y, T&acirc;y &Acirc;u...</p>\r\n	</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>\r\n	<p><strong>Ch&acirc;u &Aacute;: Th&aacute;i, Singapore, H&agrave;n Quốc, Nhật Bản...</strong></p>\r\n	</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>\r\n	<p><strong>Ch&acirc;u Phi: Nam Phi...</strong></p>\r\n	</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"http://localhost/travel_booking/assets/uploads/1770530751_r-40--5.jpg\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /></p>\r\n', '1770530786_du_lich_trang_an_ninh_binh_du_lich_thu_duc_travel.jpg', 1200000.00, 'Thanh Hóa', 'Trong ngày', 1, '2026-02-08 06:06:26'),
(4, 1, 'Du lịch đà lạt ', 'du-l-ch-l-t', 'Du lịch đà lạt tận hưởng không khí xuân', '<p>TOUR DU LỊCH Đ&Agrave; LẠT - CHU Đ&Aacute;O TẬN T&Igrave;NH</p>\r\n\r\n<p><img alt=\"\" src=\"http://localhost/travel_booking/assets/uploads/1770531040_Hình-Nền-ĐL-Hè.jpg\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /></p>\r\n\r\n<p>- Xe tham quan c&aacute;c điểm Đ&agrave; Lạt</p>\r\n\r\n<p>- Xe săn m&acirc;y đ&oacute;n b&igrave;nh minh</p>\r\n\r\n<p>- Xe đưa đ&oacute;n s&acirc;n bay Li&ecirc;n Khương - Đ&agrave; Lạt</p>\r\n\r\n<p>- Xe đưa đ&oacute;n li&ecirc;n tỉnh</p>\r\n\r\n<p><img alt=\"📌\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tac/1/16/1f4cc.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> Xe 4 chỗ đến 45 chỗ sạch sẽ , đời mới</p>\r\n\r\n<p><img alt=\"📲\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/td8/1/16/1f4f2.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> Li&ecirc;n hệ/ đặt xe : 0867.717.997</p>\r\n\r\n<p>&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;-</p>\r\n\r\n<p><img alt=\"✈️\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tb6/1/16/2708.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> Đ&Oacute;N S&Acirc;N BAY LI&Ecirc;N KHƯƠNG - Đ&Agrave; LẠT CHỈ TỪ 220K</p>\r\n\r\n<p><img alt=\"🚗\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tec/1/16/1f697.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> Xe ri&ecirc;ng &ndash; Kh&ocirc;ng gh&eacute;p kh&aacute;ch &ndash; Đ&oacute;n đ&uacute;ng giờ &ndash; Kh&ocirc;ng phụ ph&iacute;!</p>\r\n\r\n<p><img alt=\"✅\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t33/1/16/2705.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> Bảng gi&aacute; xe s&acirc;n bay (1 chiều):</p>\r\n\r\n<p>&bull; 4 chỗ: 220.000đ</p>\r\n\r\n<p>&bull; 7 chỗ: 250.000đ</p>\r\n\r\n<p>&bull; 16 chỗ: 600.000đ</p>\r\n\r\n<p><img alt=\"🗺\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tc8/1/16/1f5fa.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> Tour tham quan Đ&agrave; Lạt 8 tiếng (trọn g&oacute;i):</p>\r\n\r\n<p>&bull; 4 chỗ: 900.000đ</p>\r\n\r\n<p>&bull; 7 chỗ: 1.000.000đ</p>\r\n\r\n<p>&bull; 16 chỗ: 1.500.000đ</p>\r\n\r\n<p><img alt=\"🕓\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t2b/1/16/1f553.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> Tour săn m&acirc;y: Khởi h&agrave;nh 4h s&aacute;ng &ndash; kết th&uacute;c 8h30</p>\r\n\r\n<p><img alt=\"🚘\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t6d/1/16/1f698.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> Xe ri&ecirc;ng:</p>\r\n\r\n<p>&bull; 4 chỗ: 600.000đ</p>\r\n\r\n<p>&bull; 7 chỗ: 700.000đ</p>\r\n\r\n<p>&bull; 16 chỗ: 1.000.000đ</p>\r\n\r\n<p>⸻</p>\r\n\r\n<p><img alt=\"✅\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t33/1/16/2705.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> CAM KẾT DỊCH VỤ:</p>\r\n\r\n<p><img alt=\"💯\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tf1/1/16/1f4af.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> Kh&ocirc;ng ph&aacute;t sinh chi ph&iacute; &ndash; Đ&atilde; bao gồm bến b&atilde;i, v&eacute; cầu đường</p>\r\n\r\n<p><img alt=\"🎁\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t84/1/16/1f381.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> Tặng tư vấn lịch tr&igrave;nh &ndash; Thiết kế tour ri&ecirc;ng miễn ph&iacute;</p>\r\n\r\n<p><img alt=\"📸\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tde/1/16/1f4f8.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> T&agrave;i xế ki&ecirc;m HDV, vui vẻ &ndash; hỗ trợ quay phim &amp; chụp ảnh</p>\r\n\r\n<p><img alt=\"🧼\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tce/1/16/1f9fc.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /> Xe sạch &ndash; đời mới &ndash; chạy &ecirc;m &ndash; phục vụ tận t&igrave;nh</p>\r\n\r\n<p>&nbsp;</p>\r\n', '1770531050_Hình-Nền-ĐL-Hè.jpg', 15000000.00, 'Đà Lạt', '5 ngày  5 đêm', 1, '2026-02-08 06:10:50'),
(5, 3, 'Tour du lịch đà nẵng cho gia đình', 'tour-du-l-ch-n-ng-cho-gia-nh', 'Tour du lịch đà nẵng cho gia đình dịp lễ ', '<p>Chương tr&igrave;nh c&oacute; sự đồng h&agrave;nh tham gia của hơn 300 đơn vị, gồm c&aacute;c Tập đo&agrave;n Sun Group, Vingroup, Mikazuki, DHC, Hoiana&hellip;; c&aacute;c bảo t&agrave;ng, di t&iacute;ch, khu điểm du lịch; c&aacute;c h&atilde;ng h&agrave;ng kh&ocirc;ng, cơ sở lưu tr&uacute; du lịch, đơn vị lữ h&agrave;nh, cơ sở ăn uống, mua sắm, hơn 200 cơ sở kinh doanh dịch vụ du lịch tr&ecirc;n địa b&agrave;n th&agrave;nh phố; c&aacute;c đơn vị cung ứng giải ph&aacute;p c&ocirc;ng nghệ VNPAY, TripC AI.</p>\r\n\r\n<p><img alt=\"\" src=\"http://localhost/travel_booking/assets/uploads/1770531348_Tour-du-lich-Da-Nang-_-Du-lich-Lion-Trip.png\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /></p>\r\n', '1770531356_DA-NANG-CU-LAO-CHAM-2261148856800.png', 12000000.00, 'Đà nẵng', '5 ngày 4 đêm', 1, '2026-02-08 06:15:56'),
(6, 5, 'Du lịch đà nẵng', 'du-l-ch-n-ng', 'Du lịch đà nẵng cho cặp đôi 2 ngày 1 đêm', '<p>Du lịch đ&agrave; nẵng cho cặp đ&ocirc;i 2 ng&agrave;y 1 đ&ecirc;m<img alt=\"\" src=\"http://localhost/travel_booking/assets/uploads/1770531458_chuong-trinh-kich-cau-thu-hut-khach-du-lich-den-thanh-pho-da-nang-cac-thang-cuoi-nam-2025-de-da-nang-moi-trai-nghiem-moi-new-da-nang-new-experience-01-1024x576.jpg\" style=\"border-radius:1rem; display:block; height:auto; margin:10px auto; max-width:100%\" /></p>\r\n', '1770531463_chuong-trinh-kich-cau-thu-hut-khach-du-lich-den-thanh-pho-da-nang-cac-thang-cuoi-nam-2025-de-da-nang-moi-trai-nghiem-moi-new-da-nang-new-experience-01-1024x576.jpg', 5000000.00, 'Đà Nẵng', '2 ngày 1 đêm', 1, '2026-02-08 06:17:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `phone`, `role`, `created_at`) VALUES
(1, 'admin', '$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly', 'Quản trị viên', 'admin@travel.com', '0987654321', 'admin', '2026-02-08 05:14:30'),
(2, 'minhanh', '$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly', 'Minh Anh', 'minhanh@user.com', '0123456789', 'user', '2026-02-08 05:14:30'),
(3, 'bom', '$2y$10$XkJT4F/azr9KZVPyVzP6t.b5dPp.t6Y2XHtCVuqnDVd2TyNZtBiKu', 'Trần Bơm', 'bom@gmail.com', '0123456789', 'user', '2026-02-08 05:46:14'),
(4, 'huy', '$2y$10$4ctnW/DBQqHRdfrOhz9PH.48vtVPQOcHDTcgU1j2bpO6be9mVeu5C', 'Huy Nguyễn', 'huy@gmail.com', '0123456789', 'user', '2026-02-08 05:46:32'),
(5, 'huyen', '$2y$10$MCupDBcd4uLCfSgiIaSZ7.ZTr6b.foHD7tZqE1dLmj7H1oyXqEDKe', 'Trần Thị Huyền', 'huyen@gmail.com', '0123456789', 'user', '2026-02-08 05:46:53'),
(6, 'thinh', '$2y$10$y6UKHsqBk8RCSHi0liSPI.GDS7ISJ61Hh3h6w467LsyJrbZ8CIiuG', 'Thịnh Ngựa', 'thinh@gmail.com', '0123456789', 'user', '2026-02-08 05:47:12');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

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
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

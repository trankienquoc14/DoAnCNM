-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 29, 2026 lúc 03:07 AM
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
-- Cơ sở dữ liệu: `quanlydulich`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blogs`
--

CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `short_desc` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `blogs`
--

INSERT INTO `blogs` (`blog_id`, `title`, `slug`, `category`, `image`, `short_desc`, `content`, `created_at`) VALUES
(1, 'Kinh nghiệm du lịch Sapa tự túc từ A-Z mùa săn mây', 'kinh-nghiem-du-lich-sapa-tu-tuc-tu-a-z-mua-san-may', 'Kinh nghiệm', 'blog1.jpg', 'Hướng dẫn chi tiết cách di chuyển, đặt phòng và các điểm check-in không thể bỏ lỡ khi đến Sapa mùa săn mây.', '<p>Sapa luôn là điểm đến hấp dẫn du khách trong và ngoài nước. Để có một chuyến đi săn mây trọn vẹn, bạn nên ghé thăm vào khoảng tháng 9 đến tháng 11. Đừng quên mang theo áo ấm và giày thể thao để tiện di chuyển nhé!</p><ul><li>Đỉnh Fansipan</li><li>Bản Cát Cát</li><li>Cổng trời Ô Quy Hồ</li></ul>', '2026-04-20 01:30:00'),
(2, 'Top 10 món ngon đặc sản Phú Quốc nhất định phải thử', 'top-10-mon-ngon-dac-san-phu-quoc-nhat-dinh-phai-thu', 'Ẩm thực', '15-dac-san-phu-quoc.jpg', 'Bún quậy, gỏi cá trích, nhum biển... Khám phá bản đồ ẩm thực làm say đắm du khách tại Đảo Ngọc.', '<p>Đến Phú Quốc mà không thưởng thức hải sản thì quả là một thiếu sót lớn. Gỏi cá trích cuốn bánh tráng chấm nước mắm chua ngọt, hay bát bún quậy Kiến Xây trứ danh chắc chắn sẽ làm hài lòng những thực khách khó tính nhất.</p>', '2026-04-18 07:15:00'),
(3, 'Lịch trình phá đảo Đà Nẵng - Hội An 4 ngày 3 đêm', 'lich-trinh-pha-dao-da-nang-hoi-an-4-ngay-3-dem', 'Điểm đến', 'danang_hoian.jpg', 'Gợi ý lịch trình di chuyển tối ưu nhất để bạn khám phá trọn vẹn hai thành phố di sản miền Trung.', '<p>Hành trình 4 ngày 3 đêm là khoảng thời gian lý tưởng để bạn khám phá sự sôi động của Đà Nẵng và nét cổ kính của Hội An. Ngày 1: Khám phá Bán đảo Sơn Trà. Ngày 2: Vui chơi tại Bà Nà Hills. Ngày 3: Tắm biển Mỹ Khê và di chuyển vào Hội An. Ngày 4: Dạo quanh phố cổ và mua sắm.</p>', '2026-04-15 02:00:00'),
(4, 'Bí kíp xếp hành lý gọn nhẹ cho tour du lịch dài ngày', 'bi-kip-xep-hanh-ly-gon-nhe-cho-tour-du-lich-dai-ngay', 'Mẹo hay', 'blog2.png', 'Áp dụng ngay nguyên tắc cuộn tròn và sử dụng túi chiết để vali của bạn luôn gọn gàng, tiện lợi.', '<p>Để tối ưu không gian vali, hãy cuộn tròn quần áo thay vì gấp phẳng. Sử dụng các túi chiết mỹ phẩm nhỏ gọn và tận dụng khoảng trống bên trong giày để nhét tất. Đừng quên mang theo một chiếc túi zip dự phòng để đựng đồ bẩn nhé!</p>', '2026-04-10 09:45:00'),
(6, 'Khám phá Đảo Ngọc Phú Quốc 3 Ngày 2 Đêm: Trọn Bộ Bí Kíp Cho Người Mới', 'kham-pha-dao-ngoc-phu-quoc-3-ngay-2-dem-tron-bo-bi-kip-cho-nguoi-moi', 'Kinh nghiệm', '1777383011_blog_phuquoc.webp', 'Bỏ túi ngay lịch trình chi tiết khám phá Phú Quốc 3 ngày 2 đêm. Từ những bãi biển xanh ngắt vắng người, đến những khu chợ đêm sầm uất và các món hải sản địa phương ăn là ghiền!', '<p><strong>Phú Quốc</strong> - hòn đảo ngọc xinh đẹp nằm ở cực Nam Tổ quốc luôn là điểm đến hấp dẫn du khách trong và ngoài nước. Nếu bạn đang lên kế hoạch cho chuyến đi đầu tiên đến đây, đừng bỏ qua lịch trình 3 ngày 2 đêm cực kỳ tối ưu này của TravelVN nhé!</p>\r\n\r\n<h3>Ngày 1: Nhận phòng - Khám phá Bắc Đảo - Săn hoàng hôn</h3>\r\n<ul>\r\n    <li><strong>Sáng:</strong> Đáp chuyến bay đến Phú Quốc. Khởi hành về khách sạn khu vực Dương Đông để gửi hành lý. Vui chơi tại khu vực VinWonders và Safari.</li>\r\n    <li><strong>Trưa:</strong> Thưởng thức đặc sản bún quậy Kiến Xây trứ danh với phần chả tôm mực tươi rói.</li>\r\n    <li><strong>Chiều:</strong> Di chuyển đến OCSEN Beach Bar & Club hoặc Sunset Sanato để ngắm hoàng hôn rực rỡ nhất Việt Nam.</li>\r\n    <li><strong>Tối:</strong> Dạo Chợ đêm Phú Quốc, thưởng thức hải sản nướng mỡ hành và đậu phộng Chou Chou.</li>\r\n</ul>\r\n\r\n<h3>Ngày 2: Tour 4 đảo - Lặn ngắm san hô - Cáp treo Hòn Thơm</h3>\r\n<p>Đây là ngày bạn sẽ dành trọn vẹn cho biển cả. Hãy đặt ngay một tour cano khám phá các hòn đảo nhỏ phía Nam:</p>\r\n<ul>\r\n    <li><strong>Hòn Móng Tay & Hòn Gầm Ghì:</strong> Trải nghiệm lặn ngắm san hô tự nhiên tuyệt đẹp với làn nước trong vắt nhìn thấy đáy.</li>\r\n    <li><strong>Hòn Mây Rút:</strong> Nghỉ ngơi, tắm biển và chụp những bức ảnh check-in sống ảo cực \"chill\" với xích đu vô cực.</li>\r\n    <li><strong>Chiều muộn:</strong> Trải nghiệm tuyến cáp treo vượt biển dài nhất thế giới từ Hòn Thơm về lại ga An Thới.</li>\r\n</ul>\r\n\r\n<h3>Ngày 3: Mua sắm đặc sản - Tạm biệt Đảo Ngọc</h3>\r\n<p>Sáng ngày cuối cùng, hãy thuê xe máy dạo quanh thị trấn, ghé thăm nhà thùng nước mắm, vườn tiêu hoặc cơ sở sản xuất ngọc trai để mua quà cho người thân. Tầm 11h, bạn làm thủ tục trả phòng và di chuyển ra sân bay.</p>\r\n\r\n<hr>\r\n\r\n<p><em><strong>Lưu ý nhỏ từ TravelVN:</strong> Thời điểm lý tưởng nhất để vi vu Phú Quốc là từ tháng 11 đến tháng 4 năm sau (mùa khô). Đừng quên chuẩn bị kem chống nắng và một chiếc máy ảnh đầy pin nhé! Bạn có thể đặt ngay các <strong><a href=\"#\">Tour Phú Quốc trọn gói</a></strong> của chúng tôi để nhận ưu đãi bất ngờ!</em></p>', '2026-04-28 10:39:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `departure_id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `pickup_address` varchar(255) DEFAULT NULL,
  `booking_date` datetime DEFAULT current_timestamp(),
  `number_of_people` int(11) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed','checked_in') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `departure_id`, `customer_name`, `email`, `phone`, `pickup_address`, `booking_date`, `number_of_people`, `total_price`, `note`, `status`) VALUES
(7, 5, 3, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-03-17 22:29:13', 2, 10400000.00, '', ''),
(8, 5, 2, 'QKT', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-03-17 23:07:57', 2, 7000000.00, '', 'confirmed'),
(9, 5, 1, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-03-17 23:25:27', 2, 7000000.00, '', ''),
(10, 6, 1, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0345675124', NULL, '2026-03-18 09:08:36', 2, 7000000.00, '', ''),
(11, 5, 1, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-03-18 10:49:11', 2, 7000000.00, '', ''),
(12, 5, 1, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-03-19 13:08:07', 2, 7000000.00, '', 'cancelled'),
(13, 7, 1, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0345675124', NULL, '2026-03-21 00:33:38', 3, 10800000.00, '', ''),
(14, 7, 1, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0901234567', NULL, '2026-03-21 00:35:24', 1, 3600000.00, '', ''),
(15, 1, 3, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-03-22 19:10:16', 1, 5200000.00, '', 'pending'),
(16, 1, 3, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0901234567', NULL, '2026-03-22 19:10:39', 1, 5200000.00, '', 'pending'),
(17, 1, 3, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0901234567', NULL, '2026-03-22 19:13:31', 1, 5200000.00, '', 'cancelled'),
(18, 1, 3, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0345675124', NULL, '2026-03-22 19:13:43', 1, 5200000.00, '', 'pending'),
(19, 1, 3, 'QKT', 'trankienquoc12102004@gmail.com', '0345675124', NULL, '2026-03-22 21:12:38', 1, 5200000.00, '', 'pending'),
(20, 7, 3, 'QKT', 'trankienquoc12102004@gmail.com', '0345675124', NULL, '2026-03-22 22:03:28', 1, 5200000.00, '', 'cancelled'),
(21, 8, 3, 'Administrator', 'admin@gmail.com', '0345675124', NULL, '2026-03-22 22:37:13', 1, 5200000.00, '', 'cancelled'),
(22, 7, 1, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675124', NULL, '2026-03-22 23:31:42', 2, 7200000.00, '', 'cancelled'),
(23, 7, 5, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675124', NULL, '2026-03-23 01:33:54', 2, 400000.00, '', 'completed'),
(24, 3, 5, 'Phạm Mỹ Linh', 'linhpm@gmail.com', '0987654321', NULL, '2026-03-23 01:50:03', 3, 600000.00, '', 'completed'),
(25, 7, 3, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-21 07:09:12', 2, 10400000.00, '', 'cancelled'),
(26, 1, 3, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-21 07:17:19', 2, 10400000.00, '', 'pending'),
(27, 7, 3, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-21 07:31:26', 2, 10400000.00, '', 'cancelled'),
(28, 1, 3, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0901234567', NULL, '2026-04-21 07:40:32', 2, 10400000.00, '', 'confirmed'),
(29, 7, 3, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-21 07:55:10', 2, 10400000.00, '', 'cancelled'),
(30, 7, 3, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-21 07:56:01', 2, 10400000.00, '', 'cancelled'),
(31, 7, 3, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-21 08:15:17', 1, 5200000.00, '', 'confirmed'),
(32, 7, 7, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-21 08:32:59', 2, 10400000.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(33, 7, 7, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-21 08:40:48', 2, 10400000.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(34, 7, 7, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-21 08:42:42', 3, 15600000.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(35, 7, 7, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-21 08:45:28', 2, 10400000.00, '', 'confirmed'),
(36, 7, 7, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-22 21:06:29', 1, 5200000.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(37, 7, 7, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-22 21:19:54', 2, 10400000.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(38, 7, 7, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-22 22:10:05', 1, 5200000.00, '', 'checked_in'),
(39, 7, 8, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-24 21:22:08', 1, 3600000.00, '', 'cancelled'),
(40, 7, 8, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-24 21:23:00', 2, 7200000.00, '', 'cancelled'),
(41, 7, 8, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-24 22:51:41', 1, 3600000.00, '', 'cancelled'),
(42, 7, 8, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-25 00:08:04', 2, 7200000.00, '', 'checked_in'),
(43, 7, 8, 'QKT1', 'trankienquoc12102004@gmail.com', '0901234567', NULL, '2026-04-25 00:08:41', 1, 3600000.00, '', 'confirmed'),
(44, 8, 2, 'Administrator', 'admin@gmail.com', '0345675125', NULL, '2026-04-26 22:01:16', 1, 3600000.00, '', 'confirmed'),
(45, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0345675125', NULL, '2026-04-26 22:46:05', 1, 3600000.00, '', 'cancelled'),
(46, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0987654321', NULL, '2026-04-26 22:48:42', 1, 3600.00, '', 'confirmed'),
(47, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0345657678', NULL, '2026-04-26 23:32:29', 1, 3600.00, '', 'pending'),
(48, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0987654321', NULL, '2026-04-28 22:03:43', 1, 3600.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(49, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0987654321', NULL, '2026-04-28 22:10:15', 1, 3600.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(50, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0987654321', NULL, '2026-04-28 22:10:29', 1, 3600.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(51, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0987654321', NULL, '2026-04-28 22:11:01', 1, 3600.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(52, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0365745897', NULL, '2026-04-28 22:16:19', 1, 3600.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(53, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0987654321', NULL, '2026-04-28 22:23:16', 1, 3600.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(54, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0987654321', NULL, '2026-04-28 22:34:42', 1, 3600.00, '', 'pending'),
(55, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0987654321', NULL, '2026-04-28 22:34:57', 1, 3600.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(56, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0987654321', 'Tự đến Điểm hẹn tập trung', '2026-04-28 23:40:28', 1, 3600.00, '', 'pending'),
(57, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0987654321', 'Tự đến Điểm hẹn tập trung', '2026-04-28 23:40:58', 1, 3600.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled'),
(58, 7, 2, 'QKT1', 'trankienquoc12102004@gmail.com', '0365745897', 'Đón Khách sạn: Khách sạn Mường Thanh', '2026-04-28 23:43:00', 1, 3600.00, 'Đã hủy do hết thời gian thanh toán', 'cancelled');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_messages`
--

CREATE TABLE `chat_messages` (
  `message_id` int(11) NOT NULL,
  `session_id` varchar(100) NOT NULL COMMENT 'Mã phiên chat để phân biệt các khách hàng khác nhau',
  `departure_id` int(11) DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `sender_type` enum('customer','admin','tour_manager','guide') NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chat_messages`
--

INSERT INTO `chat_messages` (`message_id`, `session_id`, `departure_id`, `sender_name`, `sender_type`, `message`, `created_at`) VALUES
(12, 'user_7', NULL, 'QKT1', 'customer', 'Xin chào', '2026-04-27 08:36:20'),
(13, 'user_7', NULL, 'Administrator', 'admin', 'tôi có thể giúp gì cho bạn', '2026-04-27 08:41:11'),
(14, 'chat_69ef23631494f', NULL, 'Khách vãng lai', 'customer', 'xin chào', '2026-04-27 08:50:43'),
(16, 'user_7', NULL, 'QKT1', 'customer', 'tôi cần tư vấn về tour', '2026-04-27 09:41:34'),
(17, 'user_7', NULL, 'Administrator', 'admin', 'bạn chờ tôi một chút nhé', '2026-04-27 09:42:44'),
(18, 'user_7', NULL, 'QKT1', 'customer', 'vâng', '2026-04-27 09:43:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `checkins`
--

CREATE TABLE `checkins` (
  `checkin_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `checkin_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departures`
--

CREATE TABLE `departures` (
  `departure_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `max_seats` int(11) DEFAULT NULL,
  `available_seats` int(11) DEFAULT NULL,
  `booked_seats` int(11) DEFAULT 0,
  `status` enum('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `departures`
--

INSERT INTO `departures` (`departure_id`, `tour_id`, `start_date`, `end_date`, `max_seats`, `available_seats`, `booked_seats`, `status`) VALUES
(1, 1, '2026-04-10', '2026-04-12', 30, 16, 2, 'completed'),
(2, 1, '2026-04-28', '2026-05-01', 30, 22, 0, 'upcoming'),
(3, 2, '2026-05-01', '2026-05-04', 20, -3, 6, 'upcoming'),
(4, 11, '2026-03-30', '2026-03-31', 10, 10, 0, 'cancelled'),
(5, 11, '2026-03-30', '2026-03-31', 10, 5, 5, 'completed'),
(6, 3, '2026-04-05', '2026-04-08', 20, 20, 0, 'cancelled'),
(7, 2, '2026-04-23', '2026-04-25', 20, 14, 3, 'upcoming'),
(8, 1, '2026-04-26', '2026-04-28', 10, -2, 5, 'upcoming');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departure_guides`
--

CREATE TABLE `departure_guides` (
  `id` int(11) NOT NULL,
  `departure_id` int(11) DEFAULT NULL,
  `guide_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `departure_guides`
--

INSERT INTO `departure_guides` (`id`, `departure_id`, `guide_id`) VALUES
(3, 1, 2),
(4, 1, 4),
(6, 4, 9),
(7, 3, 2),
(8, 5, 2),
(9, 6, 9),
(10, 7, 2),
(11, 8, 2),
(12, 2, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `partners`
--

CREATE TABLE `partners` (
  `partner_id` int(11) NOT NULL,
  `partner_name` varchar(150) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `partners`
--

INSERT INTO `partners` (`partner_id`, `partner_name`, `contact_person`, `phone`, `email`, `address`, `created_at`) VALUES
(1, 'Vietravel', 'Nguyễn Văn B', '0901234567', 'contact12@vietravel.com', '190 Pasteur, Quận 3, TP.HCM', '2026-03-17 00:15:54'),
(2, 'Saigontourist', 'Lê Thị B', '0908889999', 'info@saigontourist.net', '45 Lê Thánh Tôn, Quận 1, TP.HCM', '2026-03-17 00:15:54'),
(4, 'QKTTravel', 'Nguyễn Văn K', '0345675124', 'qktravel12@gmail.com', '190 Pasteur, Quận 3, TP.HCM', '2026-03-22 05:59:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT 'QR',
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `transaction_code` varchar(100) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `amount`, `payment_method`, `payment_status`, `transaction_code`, `payment_date`) VALUES
(6, 7, 10400000.00, 'qr', 'paid', NULL, NULL),
(7, 8, 7000000.00, 'qr', 'paid', NULL, NULL),
(8, 9, 7000000.00, 'qr', 'paid', NULL, NULL),
(9, 10, 7000000.00, 'qr', 'paid', NULL, NULL),
(10, 11, 7000000.00, 'qr', 'pending', NULL, NULL),
(11, 12, 7000000.00, 'qr', '', NULL, NULL),
(12, 13, 10800000.00, 'qr', 'paid', NULL, NULL),
(13, 14, 3600000.00, 'cod', 'pending', NULL, NULL),
(14, 17, 5200000.00, 'qr', '', 'TXN1774181611399', NULL),
(15, 18, 5200000.00, 'qr', 'paid', 'TXN1774181623556', NULL),
(16, 19, 5200000.00, 'qr', 'paid', 'TXN1774188758100', NULL),
(17, 20, 5200000.00, 'qr', 'paid', 'TXN1774191808243', NULL),
(18, 21, 5200000.00, 'qr', 'paid', 'TXN1774193833414', NULL),
(19, 22, 7200000.00, 'cod', 'pending', NULL, NULL),
(20, 23, 400000.00, 'qr', 'paid', 'TXN1774204434657', NULL),
(21, 24, 600000.00, 'cod', 'pending', NULL, NULL),
(22, 25, 10400000.00, 'qr', 'paid', 'TXN1776730152233', NULL),
(23, 26, 10400000.00, 'cod', 'pending', NULL, NULL),
(24, 27, 10400000.00, 'qr', 'paid', 'TXN1776731486659', NULL),
(25, 28, 10400000.00, 'cod', 'paid', NULL, NULL),
(26, 29, 10400000.00, 'qr', 'pending', 'TXN1776732910890', NULL),
(27, 30, 10400000.00, 'qr', 'pending', 'TXN1776732961597', NULL),
(28, 31, 5200000.00, 'qr', 'paid', 'TXN1776734117372', NULL),
(29, 32, 10400000.00, 'qr', '', 'TXN1776735179360', NULL),
(30, 33, 10400000.00, 'qr', '', 'TXN1776735648621', NULL),
(31, 34, 15600000.00, 'qr', '', 'TXN1776735762904', NULL),
(32, 35, 10400000.00, 'qr', 'paid', 'TXN1776735928565', NULL),
(33, 36, 5200000.00, 'qr', '', 'TXN1776866789273', NULL),
(34, 37, 10400000.00, 'qr', 'failed', 'TXN1776867594280', NULL),
(35, 38, 5200000.00, 'qr', 'paid', 'TXN1776870605331', NULL),
(36, 39, 3600000.00, 'qr', 'pending', 'TXN1777040528435', NULL),
(37, 40, 7200000.00, 'cod', 'pending', NULL, NULL),
(38, 41, 3600000.00, 'cod', 'paid', NULL, NULL),
(39, 42, 7200000.00, 'cod', 'paid', NULL, NULL),
(40, 43, 3600000.00, 'cod', 'paid', NULL, NULL),
(41, 44, 3600000.00, 'qr', 'paid', 'TXN1777215676223', NULL),
(42, 45, 3600000.00, 'qr', 'pending', 'TXN1777218365823', NULL),
(43, 46, 3600.00, 'qr', 'paid', 'TXN1777218522901', NULL),
(44, 47, 3600.00, 'cod', 'pending', NULL, NULL),
(45, 48, 3600.00, 'qr', 'failed', 'TXN1777388623423', NULL),
(46, 49, 3600.00, 'qr', 'failed', 'TXN1777389015422', NULL),
(47, 50, 3600.00, 'qr', 'failed', 'TXN1777389029836', NULL),
(48, 51, 3600.00, 'qr', 'failed', 'TXN1777389061612', NULL),
(49, 52, 3600.00, 'qr', 'failed', 'TXN1777389379714', NULL),
(50, 53, 3600.00, 'qr', 'failed', 'TXN1777389796286', NULL),
(51, 54, 3600.00, 'cod', 'pending', NULL, NULL),
(52, 55, 3600.00, 'qr', 'failed', 'TXN1777390497788', NULL),
(53, 56, 3600.00, 'cod', 'pending', NULL, NULL),
(54, 57, 3600.00, 'qr', 'failed', 'TXN1777394458176', NULL),
(55, 58, 3600.00, 'qr', 'failed', 'TXN1777394580126', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_id` int(11) NOT NULL,
  `tour_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `booking_id`, `tour_id`, `rating`, `comment`, `created_at`) VALUES
(4, 7, 23, 11, 4, 'Hài lòng', '2026-03-22 19:34:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tours`
--

CREATE TABLE `tours` (
  `tour_id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `tour_name` varchar(200) NOT NULL,
  `destination` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `hotel` varchar(50) DEFAULT NULL,
  `include_service` text DEFAULT NULL,
  `exclude_service` text DEFAULT NULL,
  `itinerary` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tours`
--

INSERT INTO `tours` (`tour_id`, `partner_id`, `tour_name`, `destination`, `description`, `price`, `duration`, `status`, `created_by`, `hotel`, `include_service`, `exclude_service`, `itinerary`, `image`, `created_at`, `slug`) VALUES
(1, 1, 'Tour Đà Nẵng - Hội An 3N2Đ', 'Đà Nẵng', 'Trải nghiệm chuyến du lịch tuyệt vời tại Đà Nẵng.', 3600.00, 3, 'active', 1, '3 - 4 sao', 'Xe đưa đón tham quan tại điểm đến, Khách sạn, Ăn uống, Hướng dẫn viên', 'Chi phí cá nhân, Thuế VAT, Vé máy bay/Tàu xe khứ hồi di chuyển đến điểm đón', 'Ngày 1: Đà Nẵng - Bà Nà Hills | Ngày 2: Hội An | Ngày 3: Sơn Trà - Ngũ Hành Sơn', 'tour1.png', '2026-03-20 15:34:26', 'tour-da-nang-hoi-an-3n2d'),
(2, 2, 'Tour Khám phá Đảo Ngọc Phú Quốc', 'Phú Quốc', 'Nghỉ dưỡng 4 sao, lặn ngắm san hô tại Nam Đảo.', 5200000.00, 4, 'active', 1, '4 sao', 'Xe đưa đón tham quan tại điểm đến, Khách sạn, Ăn uống, Hướng dẫn viên', 'Chi phí cá nhân, Thuế VAT, Vé máy bay/Tàu xe khứ hồi di chuyển đến điểm đón', 'Ngày 1: Đến Phú Quốc | Ngày 2: VinWonders | Ngày 3: Lặn biển | Ngày 4: Trở về', 'tour2.png', '2026-03-20 15:34:26', 'tour-kham-pha-dao-ngoc-phu-quoc'),
(3, 1, 'Tour Đà Lạt Mộng Mơ 3N2Đ', 'Đà Lạt', 'Tham quan thành phố ngàn hoa với khí hậu mát mẻ.', 2900000.00, 3, 'active', 1, '3 sao', 'Xe đưa đón tham quan tại điểm đến, Khách sạn, Ăn sáng, Vé tham quan', 'Chi phí cá nhân, Vé máy bay/Tàu xe khứ hồi di chuyển đến điểm đón', 'Ngày 1: Thác Datanla | Ngày 2: Langbiang | Ngày 3: Chợ Đà Lạt', 'tour3.png', '2026-03-20 15:34:26', 'tour-da-lat-mong-mo-3n2d'),
(4, 2, 'Tour Nha Trang Biển Xanh 3N2Đ', 'Nha Trang', 'Khám phá biển đảo và các khu vui chơi tại Nha Trang.', 3300000.00, 3, 'active', 1, '4 sao', 'Xe đưa đón tham quan tại điểm đến, Khách sạn, Ăn uống, Cano ra đảo', 'Chi phí cá nhân, Thuế VAT, Vé máy bay/Tàu xe khứ hồi di chuyển đến điểm đón', 'Ngày 1: City Tour | Ngày 2: Tour đảo | Ngày 3: Tắm bùn', 'tour4.png', '2026-03-20 15:34:26', 'tour-nha-trang-bien-xanh-3n2d'),
(5, 1, 'Tour Sapa - Fansipan 3N2Đ', 'Sapa', 'Chinh phục Fansipan và khám phá văn hóa dân tộc.', 4100000.00, 3, 'active', 1, '3 sao', 'Xe, Khách sạn, Vé cáp treo, HDV', 'Chi phí cá nhân, Vé máy bay/Tàu xe khứ hồi di chuyển đến điểm đón', 'Ngày 1: Bản Cát Cát | Ngày 2: Fansipan | Ngày 3: Chợ Sapa', 'tour5.png', '2026-03-20 15:34:26', 'tour-sapa-fansipan-3n2d'),
(6, 1, 'Tour Hà Nội - Hạ Long 2N1Đ', 'Hạ Long', 'Du thuyền vịnh Hạ Long - kỳ quan thiên nhiên thế giới.', 2500000.00, 2, 'active', 1, 'Du thuyền', 'Xe đưa đón tham quan tại điểm đến, Vé tham quan, Ăn uống', 'Chi phí cá nhân, Vé máy bay/Tàu xe khứ hồi di chuyển đến điểm đón', 'Ngày 1: Hà Nội - Hạ Long | Ngày 2: Hang Sửng Sốt - Trở về', 'tour6.png', '2026-03-20 15:34:26', 'tour-ha-noi-ha-long-2n1d'),
(7, 2, 'Tour Cố Đô Huế 2N1Đ', 'Huế', 'Khám phá di tích lịch sử và văn hóa Huế.', 2200000.00, 2, 'active', 1, '3 sao', 'Xe đưa đón tham quan tại điểm đến, Khách sạn, Vé tham quan', 'Chi phí cá nhân, Vé máy bay/Tàu xe khứ hồi di chuyển đến điểm đón', 'Ngày 1: Đại Nội | Ngày 2: Chùa Thiên Mụ', 'tour7.png', '2026-03-20 15:34:26', 'tour-co-do-hue-2n1d'),
(8, 1, 'Tour Côn Đảo 3N2Đ', 'Côn Đảo', 'Du lịch tâm linh và nghỉ dưỡng biển đảo.', 4800000.00, 3, 'active', 1, '4 sao', 'Khách sạn, Xe đưa đón tham quan tại điểm đến, HDV địa phương, Bảo hiểm du lịch', 'Chi phí cá nhân, Vé máy bay/Tàu xe khứ hồi di chuyển đến điểm đón', 'Ngày 1: Nghĩa trang Hàng Dương | Ngày 2: Tắm biển | Ngày 3: Trở về', 'tour8.png', '2026-03-20 15:34:26', 'tour-con-dao-3n2d'),
(11, 4, 'Tour Vũng Tàu 2N1Đ', 'Vũng Tàu', 'Nghỉ dưỡng biển, tham quan tượng Chúa Kitô.', 200000.00, 2, 'active', NULL, '4 sao', 'Xe đưa đón tham quan tại điểm đến, Khách sạn, Ăn sáng', 'Chi phí cá nhân, Vé máy bay/Tàu xe khứ hồi di chuyển đến điểm đón', 'Ngày 1: Tắm biển | Ngày 2: Tham quan', '1774159445_vungtau.webp', '2026-03-22 13:04:05', 'tour-vung-tau-2n1d');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_guides`
--

CREATE TABLE `tour_guides` (
  `assignment_id` int(11) NOT NULL,
  `departure_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_schedules`
--

CREATE TABLE `tour_schedules` (
  `schedule_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `day_number` int(11) DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `activity` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_schedules`
--

INSERT INTO `tour_schedules` (`schedule_id`, `tour_id`, `day_number`, `location`, `activity`) VALUES
(1, 1, 1, 'Đà Nẵng', 'Đón sân bay, tham quan Bán đảo Sơn Trà, tắm biển Mỹ Khê.'),
(2, 1, 2, 'Bà Nà Hills', 'Vui chơi tại Fantasy Park, check-in Cầu Vàng.'),
(3, 1, 3, 'Hội An', 'Tham quan Phố cổ, mua sắm đặc sản và tiễn khách ra sân bay.'),
(4, 2, 1, 'Phú Quốc', 'Tham quan Dinh Cậu, vườn tiêu và nhà thùng nước mắm.'),
(5, 2, 2, 'Nam Đảo', 'Lặn ngắm san hô, tham quan Hòn Móng Tay.'),
(6, 2, 3, 'VinWonders', 'Vui chơi công viên giải trí, thủy cung.'),
(7, 2, 4, 'Phú Quốc', 'Tự do mua sắm đặc sản, tiễn khách.'),
(8, 3, 1, 'Đà Lạt', 'Tham quan Thác Datanla, Thiền Viện Trúc Lâm.'),
(9, 3, 2, 'Langbiang', 'Chinh phục đỉnh Langbiang, giao lưu cồng chiêng.'),
(10, 3, 3, 'Chợ Đà Lạt', 'Mua sắm đặc sản và check-out.'),
(11, 4, 1, 'Nha Trang', 'Tham quan Tháp Bà Ponagar, tắm biển.'),
(12, 4, 2, 'Tour đảo', 'Đi cano tham quan Hòn Mun, lặn biển.'),
(13, 4, 3, 'Tắm bùn', 'Trải nghiệm tắm bùn khoáng nóng.'),
(14, 5, 1, 'Bản Cát Cát', 'Khám phá bản làng người H’Mông.'),
(15, 5, 2, 'Fansipan', 'Đi cáp treo chinh phục đỉnh Fansipan.'),
(16, 5, 3, 'Sapa', 'Tham quan chợ Sapa, mua sắm.'),
(17, 6, 1, 'Hạ Long', 'Du thuyền tham quan vịnh Hạ Long.'),
(18, 6, 2, 'Hang Sửng Sốt', 'Tham quan hang động và trở về.'),
(19, 7, 1, 'Đại Nội', 'Tham quan Hoàng Thành Huế.'),
(20, 7, 2, 'Chùa Thiên Mụ', 'Tham quan chùa, nghe giới thiệu lịch sử.'),
(21, 8, 1, 'Nghĩa trang Hàng Dương', 'Viếng mộ cô Sáu, tham quan di tích.'),
(22, 8, 2, 'Biển Côn Đảo', 'Tắm biển, nghỉ dưỡng.'),
(23, 8, 3, 'Côn Đảo', 'Mua sắm đặc sản, kết thúc tour.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','tour_manager','guide','admin') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Trần Kiến Quốc', 'trankienquoc@gmail.com', '0326753674', 'e10adc3949ba59abbe56e057f20f883e', 'admin', 'active', '2026-03-16 01:38:25'),
(2, 'Lý Hải Nam', 'namlh@gmail.com', '0912345678', '$2y$10$v/WSy1jKCKfMrGgBiMwqj.fQju95PrUvpQ97juJUu543BC1/ndtj.', 'guide', 'active', '2026-03-17 00:16:35'),
(3, 'Phạm Mỹ Linh', 'linhpm@gmail.com', '0987654321', 'e10adc3949ba59abbe56e057f20f883e', 'customer', 'active', '2026-03-17 00:16:35'),
(4, 'Hoàng Gia Bảo', 'baohg@gmail.com', '0933445566', 'e10adc3949ba59abbe56e057f20f883e', 'guide', 'active', '2026-03-17 00:16:35'),
(5, 'TranKienQuoc', 'trankienquoc12@gmail.com', NULL, '$2y$10$v/WSy1jKCKfMrGgBiMwqj.fQju95PrUvpQ97juJUu543BC1/ndtj.', 'tour_manager', 'active', '2026-03-17 08:01:03'),
(6, '6aye', 'atwbd12@gmail.com', NULL, '$2y$10$T.PnqQ8oMu1jsXaVeHO78.kbIVfLF7yJpi0YZAXULJIexACfqTLnG', 'customer', 'active', '2026-03-18 02:04:15'),
(7, 'QKT1', 'trankienquoc12102004@gmail.com', '0987654321', '$2y$10$liIOybR9WT1TcFnSG4LsbeEdsQe4k3IvfyGda1opo3DOSQswwMSAO', 'customer', 'active', '2026-03-20 14:55:55'),
(8, 'Administrator', 'admin@gmail.com', '', '$2y$10$5/Zqv5EgceqkgeE7zCh0o.KCo.vSA6a0jMkafdDMIHrkDd4Jenr8q', 'admin', 'active', '2026-03-20 19:42:41'),
(9, 'Trần Văn K', 'tranvank@gmail.com', '0345675124', '$2y$10$S/Grk8n4TIH9idUOzXiHS.ihpUGLjG3gesDHRj5MsRkqQHTLuDDje', 'guide', 'active', '2026-03-22 06:17:12'),
(10, 'Tour_manager', 'manager@gmail.com', '0345675124', '$2y$10$7eA91p4YpQgXpfoC48F9ZOnRR14qCwz.1WatrpnGtLZAjLsz1e12m', 'tour_manager', 'active', '2026-03-22 14:09:51');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`);

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `departure_id` (`departure_id`);

--
-- Chỉ mục cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Chỉ mục cho bảng `checkins`
--
ALTER TABLE `checkins`
  ADD PRIMARY KEY (`checkin_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Chỉ mục cho bảng `departures`
--
ALTER TABLE `departures`
  ADD PRIMARY KEY (`departure_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `departure_guides`
--
ALTER TABLE `departure_guides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departure_id` (`departure_id`),
  ADD KEY `guide_id` (`guide_id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`partner_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`tour_id`),
  ADD KEY `partner_id` (`partner_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Chỉ mục cho bảng `tour_guides`
--
ALTER TABLE `tour_guides`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `departure_id` (`departure_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Chỉ mục cho bảng `tour_schedules`
--
ALTER TABLE `tour_schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `checkins`
--
ALTER TABLE `checkins`
  MODIFY `checkin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `departures`
--
ALTER TABLE `departures`
  MODIFY `departure_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `departure_guides`
--
ALTER TABLE `departure_guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `partners`
--
ALTER TABLE `partners`
  MODIFY `partner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `tour_guides`
--
ALTER TABLE `tour_guides`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tour_schedules`
--
ALTER TABLE `tour_schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`departure_id`) REFERENCES `departures` (`departure_id`);

--
-- Các ràng buộc cho bảng `checkins`
--
ALTER TABLE `checkins`
  ADD CONSTRAINT `checkins_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`),
  ADD CONSTRAINT `checkins_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `departures`
--
ALTER TABLE `departures`
  ADD CONSTRAINT `departures_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`tour_id`);

--
-- Các ràng buộc cho bảng `departure_guides`
--
ALTER TABLE `departure_guides`
  ADD CONSTRAINT `departure_guides_ibfk_1` FOREIGN KEY (`departure_id`) REFERENCES `departures` (`departure_id`),
  ADD CONSTRAINT `departure_guides_ibfk_2` FOREIGN KEY (`guide_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`tour_id`);

--
-- Các ràng buộc cho bảng `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`partner_id`),
  ADD CONSTRAINT `tours_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `tour_guides`
--
ALTER TABLE `tour_guides`
  ADD CONSTRAINT `tour_guides_ibfk_1` FOREIGN KEY (`departure_id`) REFERENCES `departures` (`departure_id`),
  ADD CONSTRAINT `tour_guides_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `tour_schedules`
--
ALTER TABLE `tour_schedules`
  ADD CONSTRAINT `tour_schedules_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`tour_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

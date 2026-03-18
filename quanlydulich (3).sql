-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 18, 2026 lúc 03:23 AM
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
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `departure_id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `booking_date` datetime DEFAULT current_timestamp(),
  `number_of_people` int(11) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `departure_id`, `customer_name`, `email`, `phone`, `booking_date`, `number_of_people`, `total_price`, `note`, `status`) VALUES
(7, 5, 3, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0345675125', '2026-03-17 22:29:13', 2, 10400000.00, '', 'confirmed'),
(8, 5, 2, 'QKT', 'trankienquoc12102004@gmail.com', '0345675125', '2026-03-17 23:07:57', 2, 7000000.00, '', 'confirmed'),
(9, 5, 1, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0345675125', '2026-03-17 23:25:27', 2, 7000000.00, '', 'confirmed'),
(10, 6, 1, 'Quốc Trần Kiến', 'trankienquoc12102004@gmail.com', '0345675124', '2026-03-18 09:08:36', 2, 7000000.00, '', 'confirmed');

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
  `available_seats` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `departures`
--

INSERT INTO `departures` (`departure_id`, `tour_id`, `start_date`, `end_date`, `max_seats`, `available_seats`) VALUES
(1, 1, '2026-04-10', '2026-04-12', 30, 24),
(2, 1, '2026-04-20', '2026-04-22', 30, 28),
(3, 2, '2026-05-01', '2026-05-04', 20, 5);

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
(1, 'Vietravel', 'Nguyễn Văn A', '0901234567', 'contact@vietravel.com', '190 Pasteur, Quận 3, TP.HCM', '2026-03-17 00:15:54'),
(2, 'Saigontourist', 'Lê Thị B', '0908889999', 'info@saigontourist.net', '45 Lê Thánh Tôn, Quận 1, TP.HCM', '2026-03-17 00:15:54');

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
(9, 10, 7000000.00, 'qr', 'paid', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tour_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tours`
--

INSERT INTO `tours` (`tour_id`, `partner_id`, `tour_name`, `destination`, `description`, `price`, `duration`, `status`, `created_by`, `hotel`, `include_service`, `exclude_service`, `itinerary`, `image`) VALUES
(1, 1, 'Tour Đà Nẵng - Hội An 3N2Đ', 'Đà Nẵng', 'Trải nghiệm chuyến du lịch tuyệt vời tại Đà Nẵng.', 3500000.00, 3, 'active', 1, '3 - 4 sao', 'Xe du lịch, Khách sạn, Ăn uống, Hướng dẫn viên', 'Chi phí cá nhân, Thuế VAT', 'Ngày 1: Đà Nẵng - Bà Nà Hills | Ngày 2: Hội An | Ngày 3: Sơn Trà - Ngũ Hành Sơn', 'tour1.png'),
(2, 2, 'Tour Khám phá Đảo Ngọc Phú Quốc', 'Phú Quốc', 'Nghỉ dưỡng 4 sao, lặn ngắm san hô tại Nam Đảo.', 5200000.00, 4, 'active', 1, NULL, NULL, NULL, NULL, 'tour2.png'),
(3, 1, 'Tour Đà Lạt Mộng Mơ 3N2Đ', 'Đà Lạt', 'Tham quan thành phố ngàn hoa với khí hậu mát mẻ.', 2900000.00, 3, 'active', 1, '3 sao', 'Xe du lịch, Khách sạn, Ăn sáng, Vé tham quan', 'Chi phí cá nhân', 'Ngày 1: Thác Datanla | Ngày 2: Langbiang | Ngày 3: Chợ Đà Lạt', 'tour3.png'),
(4, 2, 'Tour Nha Trang Biển Xanh 3N2Đ', 'Nha Trang', 'Khám phá biển đảo và các khu vui chơi tại Nha Trang.', 3300000.00, 3, 'active', 1, '4 sao', 'Xe, Khách sạn, Ăn uống, Cano ra đảo', 'Chi phí cá nhân, Thuế VAT', 'Ngày 1: City Tour | Ngày 2: Tour đảo | Ngày 3: Tắm bùn', 'tour4.png'),
(5, 1, 'Tour Sapa - Fansipan 3N2Đ', 'Sapa', 'Chinh phục Fansipan và khám phá văn hóa dân tộc.', 4100000.00, 3, 'active', 1, '3 sao', 'Xe, Khách sạn, Vé cáp treo, HDV', 'Chi phí cá nhân', 'Ngày 1: Bản Cát Cát | Ngày 2: Fansipan | Ngày 3: Chợ Sapa', 'tour5.png'),
(6, 1, 'Tour Hà Nội - Hạ Long 2N1Đ', 'Hạ Long', 'Du thuyền vịnh Hạ Long - kỳ quan thiên nhiên thế giới.', 2500000.00, 2, 'active', 1, 'Du thuyền', 'Xe, Vé tham quan, Ăn uống', 'Chi phí cá nhân', 'Ngày 1: Hà Nội - Hạ Long | Ngày 2: Hang Sửng Sốt - Trở về', 'tour6.png'),
(7, 2, 'Tour Cố Đô Huế 2N1Đ', 'Huế', 'Khám phá di tích lịch sử và văn hóa Huế.', 2200000.00, 2, 'active', 1, '3 sao', 'Xe, Khách sạn, Vé tham quan', 'Chi phí cá nhân', 'Ngày 1: Đại Nội | Ngày 2: Chùa Thiên Mụ', 'tour7.png'),
(8, 1, 'Tour Côn Đảo 3N2Đ', 'Côn Đảo', 'Du lịch tâm linh và nghỉ dưỡng biển đảo.', 4800000.00, 3, 'active', 1, '4 sao', 'Vé máy bay, Khách sạn, Xe đưa đón', 'Chi phí cá nhân', 'Ngày 1: Nghĩa trang Hàng Dương | Ngày 2: Tắm biển | Ngày 3: Trở về', 'tour8.png');

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
  `role` enum('customer','tour_manager','staff','admin') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Trần Kiến Quốc', 'trankienquoc@gmail.com', '0326753674', 'e10adc3949ba59abbe56e057f20f883e', 'admin', 'active', '2026-03-16 01:38:25'),
(2, 'Lý Hải Nam', 'namlh@gmail.com', '0912345678', 'e10adc3949ba59abbe56e057f20f883e', 'staff', 'active', '2026-03-17 00:16:35'),
(3, 'Phạm Mỹ Linh', 'linhpm@gmail.com', '0987654321', 'e10adc3949ba59abbe56e057f20f883e', 'customer', 'active', '2026-03-17 00:16:35'),
(4, 'Hoàng Gia Bảo', 'baohg@gmail.com', '0933445566', 'e10adc3949ba59abbe56e057f20f883e', 'customer', 'active', '2026-03-17 00:16:35'),
(5, 'TranKienQuoc', 'trankienquoc12@gmail.com', NULL, '$2y$10$v/WSy1jKCKfMrGgBiMwqj.fQju95PrUvpQ97juJUu543BC1/ndtj.', 'customer', 'active', '2026-03-17 08:01:03'),
(6, '6aye', 'atwbd12@gmail.com', NULL, '$2y$10$T.PnqQ8oMu1jsXaVeHO78.kbIVfLF7yJpi0YZAXULJIexACfqTLnG', 'customer', 'active', '2026-03-18 02:04:15');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `departure_id` (`departure_id`);

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
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `checkins`
--
ALTER TABLE `checkins`
  MODIFY `checkin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `departures`
--
ALTER TABLE `departures`
  MODIFY `departure_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `partners`
--
ALTER TABLE `partners`
  MODIFY `partner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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

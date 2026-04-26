<?php
require_once __DIR__ . '/../config/database.php';

class ManagerController
{
    private $db;

    public function __construct()
    {
        // Khởi tạo session ở đây để dùng chung cho toàn bộ controller (hiển thị thông báo)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = (new Database())->connect();
    }

    public function dashboard()
    {
        // check quyền
        if (
            !isset($_SESSION['user']) ||
            ($_SESSION['user']['role'] != 'tour_manager' && $_SESSION['user']['role'] != 'admin')
        ) {
            header("Location: ../views/login.php");
            exit();
        }

        // ===== DATA =====
        $totalTours = $this->db->query("SELECT COUNT(*) FROM tours")->fetchColumn();

        $totalBookings = $this->db->query("SELECT COUNT(*) FROM bookings")->fetchColumn();

        $totalRevenue = $this->db->query("
            SELECT COALESCE(SUM(total_price),0) 
            FROM bookings 
            WHERE status='confirmed'
        ")->fetchColumn();

        $userName = $_SESSION['user']['full_name']
            ?? $_SESSION['user']['name']
            ?? 'Quản trị viên';

        // ===== LOAD VIEW =====
        require __DIR__ . '/../views/manager/dashboard.php';
    }

    // ================= TOUR LIST =================
    public function tours()
    {
        require_once __DIR__ . '/../models/Tour.php';

        $tourModel = new Tour($this->db);
        $tours = $tourModel->getAllTours();

        require __DIR__ . '/../views/manager/manager_tours.php';
    }

    // ================= CREATE =================
    public function createTour()
    {
        // Lấy danh sách đối tác từ DB
        $partners = $this->db
            ->query("SELECT * FROM partners")
            ->fetchAll(PDO::FETCH_ASSOC);

        // Truyền sang view
        require __DIR__ . '/../views/manager/create_tour.php';
    }

    // ================= STORE =================
    public function storeTour()
    {
        // upload ảnh
        $imageName = null;
        if (!empty($_FILES['image']['name'])) {
            $imageName = time() . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "../public/uploads/" . $imageName);
        }

        $stmt = $this->db->prepare("
        INSERT INTO tours 
        (partner_id, tour_name, destination, description, price, duration, status, created_by, hotel, include_service, exclude_service, itinerary, image)
        VALUES (?, ?, ?, ?, ?, ?, 'active', ?, ?, ?, ?, ?, ?)
    ");

        $stmt->execute([
            $_POST['partner_id'],
            $_POST['tour_name'],
            $_POST['destination'],
            $_POST['description'],
            $_POST['price'],
            $_POST['duration'],
            $_SESSION['user']['user_id'],
            $_POST['hotel'],
            $_POST['include_service'],
            $_POST['exclude_service'],
            $_POST['itinerary'],
            $imageName
        ]);

        $_SESSION['success'] = "Đã thêm tour mới thành công!";
        header("Location: manager.php?action=tours");
        exit;
    }

    // ================= EDIT =================
    public function editTour()
    {
        require_once __DIR__ . '/../models/Tour.php';

        $id = $_GET['id'];

        $tourModel = new Tour($this->db);
        $tour = $tourModel->getTourById($id);

        $partners = $this->db->query("SELECT * FROM partners")->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/manager/edit_tour.php';
    }

    // ================= UPDATE =================
    public function updateTour()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['tour_id'];
            $name = $_POST['tour_name'];
            $destination = $_POST['destination'];
            $price = $_POST['price'];
            $duration = $_POST['duration'];

            // Lấy ảnh cũ
            $stmt = $this->db->prepare("SELECT image FROM tours WHERE tour_id=?");
            $stmt->execute([$id]);
            $old = $stmt->fetch(PDO::FETCH_ASSOC);

            $imageName = $old['image'];

            // Nếu có ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

                $targetDir = __DIR__ . '/../public/uploads/';
                $imageName = time() . '_' . $_FILES['image']['name'];

                // XÓA ẢNH CŨ
                if (!empty($old['image']) && file_exists($targetDir . $old['image'])) {
                    unlink($targetDir . $old['image']);
                }

                move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imageName);
            }

            $stmt = $this->db->prepare("
    UPDATE tours 
    SET 
        partner_id=?,
        tour_name=?,
        destination=?,
        description=?,
        price=?,
        duration=?,
        hotel=?,
        include_service=?,
        exclude_service=?,
        itinerary=?,
        image=?
    WHERE tour_id=?
");

            $stmt->execute([
                $_POST['partner_id'],
                $_POST['tour_name'],
                $_POST['destination'],
                $_POST['description'],
                $_POST['price'],
                $_POST['duration'],
                $_POST['hotel'],
                $_POST['include_service'],
                $_POST['exclude_service'],
                $_POST['itinerary'],
                $imageName,
                $id
            ]);

            $_SESSION['success'] = "Đã cập nhật thông tin tour thành công!";
            header("Location: manager.php?action=tours");
            exit();
        }
    }

    // ================= DELETE =================
    public function deleteTour()
    {
        $id = $_GET['id'];

        // Lấy ảnh
        $stmt = $this->db->prepare("SELECT image FROM tours WHERE tour_id=?");
        $stmt->execute([$id]);
        $tour = $stmt->fetch(PDO::FETCH_ASSOC);

        // Xóa file ảnh
        $path = __DIR__ . '/../public/uploads/';
        if (!empty($tour['image']) && file_exists($path . $tour['image'])) {
            unlink($path . $tour['image']);
        }

        // Xóa DB
        $stmt = $this->db->prepare("DELETE FROM tours WHERE tour_id=?");
        $stmt->execute([$id]);

        $_SESSION['success'] = "Đã xóa tour thành công!";
        header("Location: manager.php?action=tours");
        exit;
    }

    public function partners()
    {
        $partners = $this->db->query("SELECT * FROM partners")->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__ . '/../views/manager/partners.php';
    }

    public function createPartner()
    {
        require __DIR__ . '/../views/manager/create_partner.php';
    }

    public function storePartner()
    {
        $stmt = $this->db->prepare("
        INSERT INTO partners 
        (partner_name, contact_person, phone, email, address, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");

        $stmt->execute([
            $_POST['partner_name'],
            $_POST['contact_person'],
            $_POST['phone'],
            $_POST['email'],
            $_POST['address']
        ]);

        $_SESSION['success'] = "Đã thêm đối tác thành công!";
        header("Location: manager.php?action=partners");
        exit;
    }

    public function editPartner()
    {
        $id = $_GET['id'];

        $stmt = $this->db->prepare("SELECT * FROM partners WHERE partner_id=?");
        $stmt->execute([$id]);
        $partner = $stmt->fetch(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/manager/edit_partner.php';
    }

    public function updatePartner()
    {
        $stmt = $this->db->prepare("
        UPDATE partners 
        SET 
            partner_name=?, 
            contact_person=?, 
            phone=?, 
            email=?, 
            address=?
        WHERE partner_id=?
    ");

        $stmt->execute([
            $_POST['partner_name'],
            $_POST['contact_person'],
            $_POST['phone'],
            $_POST['email'],
            $_POST['address'],
            $_POST['partner_id']
        ]);

        $_SESSION['success'] = "Đã cập nhật thông tin đối tác!";
        header("Location: manager.php?action=partners");
        exit;
    }

    public function deletePartner()
    {
        $id = $_GET['id'];

        // check có tour không
        $check = $this->db->prepare("SELECT COUNT(*) FROM tours WHERE partner_id=?");
        $check->execute([$id]);

        if ($check->fetchColumn() > 0) {
            $_SESSION['error'] = "Không thể xóa! Đối tác này hiện đang có tour liên kết.";
            header("Location: manager.php?action=partners");
            exit;
        }

        $stmt = $this->db->prepare("DELETE FROM partners WHERE partner_id=?");
        $stmt->execute([$id]);

        $_SESSION['success'] = "Đã xóa đối tác thành công!";
        header("Location: manager.php?action=partners");
        exit;
    }

    public function createDeparture()
    {
        $tours = $this->db->query("SELECT tour_id, tour_name FROM tours")
            ->fetchAll(PDO::FETCH_ASSOC);

        $guides = $this->db->query("SELECT user_id, full_name FROM users WHERE role='guide'")
            ->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/manager/create_departure.php';
    }

    public function editDeparture()
    {
        $id = $_GET['id'];

        // departure
        $stmt = $this->db->prepare("SELECT * FROM departures WHERE departure_id=?");
        $stmt->execute([$id]);
        $departure = $stmt->fetch(PDO::FETCH_ASSOC);

        // tours
        $tours = $this->db->query("SELECT tour_id, tour_name FROM tours")
            ->fetchAll(PDO::FETCH_ASSOC);

        // guides
        $guides = $this->db->query("SELECT user_id, full_name FROM users WHERE role='guide'")
            ->fetchAll(PDO::FETCH_ASSOC);

        // ✅ guide đã chọn
        $stmt = $this->db->prepare("SELECT guide_id FROM departure_guides WHERE departure_id=?");
        $stmt->execute([$id]);
        $selectedGuides = $stmt->fetchAll(PDO::FETCH_COLUMN);

        require __DIR__ . '/../views/manager/edit_departure.php';
    }

    public function storeDeparture()
    {
        // validate ngày
        if ($_POST['end_date'] < $_POST['start_date']) {
            $_SESSION['error'] = "Ngày kết thúc không được nhỏ hơn ngày khởi hành!";
            header("Location: manager.php?action=departures");
            exit;
        }

        // insert departure
        $stmt = $this->db->prepare("
        INSERT INTO departures 
        (tour_id, start_date, end_date, max_seats, available_seats, booked_seats, status)
        VALUES (?, ?, ?, ?, ?, 0, 'upcoming')
    ");

        $stmt->execute([
            $_POST['tour_id'],
            $_POST['start_date'],
            $_POST['end_date'],
            $_POST['max_seats'],
            $_POST['max_seats']
        ]);

        $departure_id = $this->db->lastInsertId();

        // ✅ GÁN GUIDE
        if (!empty($_POST['guides'])) {
            $stmt = $this->db->prepare("
            INSERT INTO departure_guides (departure_id, guide_id)
            VALUES (?, ?)"
            );

            foreach ($_POST['guides'] as $g) {
                $stmt->execute([$departure_id, $g]);
            }
        }

        $_SESSION['success'] = "Đã tạo chuyến khởi hành mới!";
        header("Location: manager.php?action=departures");
        exit;
    }

    public function updateDeparture()
    {
        $id = $_POST['departure_id'];

        // check ngày
        if ($_POST['end_date'] < $_POST['start_date']) {
            $_SESSION['error'] = "Ngày kết thúc không được nhỏ hơn ngày khởi hành!";
            header("Location: manager.php?action=departures");
            exit;
        }

        // update departure
        $stmt = $this->db->prepare("
        UPDATE departures
        SET tour_id=?, start_date=?, end_date=?, max_seats=?
        WHERE departure_id=?
    ");

        $stmt->execute([
            $_POST['tour_id'],
            $_POST['start_date'],
            $_POST['end_date'],
            $_POST['max_seats'],
            $id
        ]);

        // ✅ XÓA GUIDE CŨ
        $this->db->prepare("DELETE FROM departure_guides WHERE departure_id=?")
            ->execute([$id]);

        // ✅ INSERT LẠI GUIDE
        if (!empty($_POST['guides'])) {
            $stmt = $this->db->prepare("
            INSERT INTO departure_guides (departure_id, guide_id)
            VALUES (?, ?)
        ");

            foreach ($_POST['guides'] as $g) {
                $stmt->execute([$id, $g]);
            }
        }

        $_SESSION['success'] = "Đã cập nhật thông tin chuyến khởi hành!";
        header("Location: manager.php?action=departures");
        exit;
    }

    public function departures()
    {
        $stmt = $this->db->query("
        SELECT 
            d.*,
            t.tour_name,
            GROUP_CONCAT(u.full_name SEPARATOR ', ') AS guides
        FROM departures d
        JOIN tours t ON d.tour_id = t.tour_id
        LEFT JOIN departure_guides dg ON d.departure_id = dg.departure_id
        LEFT JOIN users u ON dg.guide_id = u.user_id
        WHERE d.status != 'cancelled'
        GROUP BY d.departure_id
        ORDER BY d.start_date DESC
    ");

        $departures = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/manager/departures.php';
    }

    public function deleteDeparture()
    {
        $id = $_GET['id'];

        // 1. kiểm tra có booking chưa
        $stmt = $this->db->prepare("
        SELECT COUNT(*) 
        FROM bookings 
        WHERE departure_id=?
    ");
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();

        // 2. nếu đã có khách đặt → không cho huỷ
        if ($count > 0) {
            $_SESSION['error'] = "Không thể huỷ! Chuyến đi này đã có khách hàng đặt chỗ.";
            header("Location: manager.php?action=departures");
            exit;
        }

        // 3. nếu chưa có ai → cho huỷ (soft delete)
        $stmt = $this->db->prepare("
        UPDATE departures 
        SET status='cancelled'
        WHERE departure_id=?
    ");
        $stmt->execute([$id]);

        $_SESSION['success'] = "Đã hủy bỏ chuyến đi thành công.";
        header("Location: manager.php?action=departures");
        exit;
    }

    public function bookings()
    {
        $stmt = $this->db->query("
        SELECT b.*, t.tour_name, d.start_date, 
               p.payment_method, p.payment_status 
        FROM bookings b
        JOIN departures d ON b.departure_id = d.departure_id
        JOIN tours t ON d.tour_id = t.tour_id
        LEFT JOIN payments p ON b.booking_id = p.booking_id
        ORDER BY b.booking_date DESC
        ");

        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/manager/bookings.php';
    }

    public function confirmBooking()
    {
        $id = $_GET['id'];

        // 1. Lấy thông tin đơn hàng và tên khách hàng
        $stmtBooking = $this->db->prepare("SELECT departure_id, number_of_people, status, customer_name FROM bookings WHERE booking_id = ?");
        $stmtBooking->execute([$id]);
        $booking = $stmtBooking->fetch(PDO::FETCH_ASSOC);

        // Chống duyệt lại đơn đã duyệt rồi
        if (!$booking || $booking['status'] === 'confirmed') {
            header("Location: manager.php?action=bookings");
            exit;
        }

        // 2. Cập nhật trạng thái đơn hàng thành 'confirmed'
        $stmtUpdateStatus = $this->db->prepare("UPDATE bookings SET status='confirmed' WHERE booking_id=?");
        $stmtUpdateStatus->execute([$id]);

        // 3. Cập nhật số chỗ
        $stmtUpdateSeats = $this->db->prepare("
            UPDATE departures 
            SET 
                booked_seats = booked_seats + ?, 
                available_seats = available_seats - ?
            WHERE departure_id = ?
        ");
        $stmtUpdateSeats->execute([
            $booking['number_of_people'],
            $booking['number_of_people'],
            $booking['departure_id']
        ]);

        $customerName = htmlspecialchars($booking['customer_name'] ?? 'Khách hàng');
        $_SESSION['success'] = "Đã duyệt thành công đơn hàng <strong>#{$id}</strong> của khách <strong>{$customerName}</strong>!";
        header("Location: manager.php?action=bookings");
        exit;
    }

    public function cancelBooking()
    {
        $id = $_GET['id'];

        // 1. Lấy thông tin đơn hàng (trạng thái, số lượng người, mã chuyến đi)
        $stmtBooking = $this->db->prepare("SELECT departure_id, number_of_people, status, customer_name FROM bookings WHERE booking_id = ?");
        $stmtBooking->execute([$id]);
        $booking = $stmtBooking->fetch(PDO::FETCH_ASSOC);

        if ($booking) {
            // 2. Nếu đơn này TRƯỚC ĐÓ ĐÃ DUYỆT (tức là đã trừ chỗ), thì bây giờ phải hoàn lại chỗ
            if ($booking['status'] === 'confirmed') {
                $stmtRestoreSeats = $this->db->prepare("
                    UPDATE departures 
                    SET 
                        booked_seats = booked_seats - ?, 
                        available_seats = available_seats + ?
                    WHERE departure_id = ?
                ");
                $stmtRestoreSeats->execute([
                    $booking['number_of_people'],
                    $booking['number_of_people'],
                    $booking['departure_id']
                ]);
            }

            // 3. Cập nhật trạng thái thành Đã hủy
            $stmt = $this->db->prepare("UPDATE bookings SET status='cancelled' WHERE booking_id=?");
            $stmt->execute([$id]);

            $customerName = htmlspecialchars($booking['customer_name'] ?? 'Khách hàng');
            $_SESSION['success'] = "Đã hủy đơn <strong>#{$id}</strong> của khách <strong>{$customerName}</strong> (Đã cập nhật lại chỗ trống).";
        } else {
            $_SESSION['error'] = "Không tìm thấy thông tin đơn hàng cần hủy!";
        }

        header("Location: manager.php?action=bookings");
        exit;
    }

    public function refundBooking()
    {
        $id = $_GET['id'];

        // Lấy tên khách hàng
        $stmtName = $this->db->prepare("SELECT customer_name FROM bookings WHERE booking_id = ?");
        $stmtName->execute([$id]);
        $customerName = htmlspecialchars($stmtName->fetchColumn() ?: 'Khách hàng');

        $stmt = $this->db->prepare("
        UPDATE bookings 
        SET status='refunded' 
        WHERE booking_id=?
    ");
        $stmt->execute([$id]);

        $_SESSION['success'] = "Đã đánh dấu hoàn tiền cho đơn <strong>#{$id}</strong> của khách <strong>{$customerName}</strong>!";
        header("Location: manager.php?action=bookings");
        exit;
    }

    public function report()
    {
        // ===== Tổng quan =====
        $totalRevenue = $this->db->query("
        SELECT COALESCE(SUM(total_price),0) 
        FROM bookings 
        WHERE status='confirmed'
    ")->fetchColumn();

        $totalBookings = $this->db->query("
        SELECT COUNT(*) FROM bookings
    ")->fetchColumn();

        $totalTours = $this->db->query("
        SELECT COUNT(*) FROM tours
    ")->fetchColumn();

        // ===== Doanh thu theo tháng =====
        $revenueByMonth = $this->db->query("
        SELECT 
            DATE_FORMAT(booking_date, '%m/%Y') as month,
            SUM(total_price) as revenue
        FROM bookings
        WHERE status='confirmed'
        GROUP BY month
        ORDER BY booking_date ASC
    ")->fetchAll(PDO::FETCH_ASSOC);

        // ===== Top tour =====
        $topTours = $this->db->query("
        SELECT t.tour_name, COUNT(b.booking_id) as total
        FROM bookings b
        JOIN departures d ON b.departure_id = d.departure_id
        JOIN tours t ON d.tour_id = t.tour_id
        WHERE b.status='confirmed'
        GROUP BY t.tour_id
        ORDER BY total DESC
        LIMIT 5
    ")->fetchAll(PDO::FETCH_ASSOC);

        // ===== Trạng thái =====
        $statusStats = $this->db->query("
        SELECT status, COUNT(*) as total
        FROM bookings
        GROUP BY status
    ")->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/manager/report.php';
    }

    // ================= BOOKING DETAIL (XEM CHI TIẾT ĐƠN HÀNG) =================
    public function bookingDetail()
    {
        $booking_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($booking_id <= 0) {
            $_SESSION['error'] = "Mã đơn hàng không hợp lệ!";
            header("Location: manager.php?action=bookings");
            exit;
        }

        $stmt = $this->db->prepare("
            SELECT b.*, 
                   u.email as account_email, 
                   t.tour_name, t.image, 
                   d.start_date, d.end_date, 
                   p.payment_method, p.payment_status, p.transaction_code, p.payment_date
            FROM bookings b
            LEFT JOIN users u ON b.user_id = u.user_id
            JOIN departures d ON b.departure_id = d.departure_id
            JOIN tours t ON d.tour_id = t.tour_id
            LEFT JOIN payments p ON b.booking_id = p.booking_id
            WHERE b.booking_id = ?
        ");
        $stmt->execute([$booking_id]);
        $detail = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$detail) {
            $_SESSION['error'] = "Không tìm thấy thông tin của đơn hàng này!";
            header("Location: manager.php?action=bookings");
            exit;
        }

        require __DIR__ . '/../views/manager/booking_detail.php';
    }

    // ================= XÁC NHẬN ĐÃ THU TIỀN MẶT =================
    public function confirmCash()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($id > 0) {
            // 1. Cập nhật trạng thái thanh toán trong bảng payments thành 'paid'
            $stmtPayment = $this->db->prepare("UPDATE payments SET payment_status = 'paid' WHERE booking_id = ?");
            $stmtPayment->execute([$id]);

            // 2. Lấy thông tin booking và tên khách hàng để cập nhật trạng thái đơn và trừ số chỗ
            $stmtBooking = $this->db->prepare("SELECT departure_id, number_of_people, status, customer_name FROM bookings WHERE booking_id = ?");
            $stmtBooking->execute([$id]);
            $booking = $stmtBooking->fetch(PDO::FETCH_ASSOC);

            // 3. Nếu đơn chưa được duyệt thì tiến hành duyệt và trừ chỗ luôn
            if ($booking && $booking['status'] !== 'confirmed') {
                $this->db->prepare("UPDATE bookings SET status='confirmed' WHERE booking_id=?")->execute([$id]);

                $stmtUpdateSeats = $this->db->prepare("
                    UPDATE departures 
                    SET booked_seats = booked_seats + ?, 
                        available_seats = available_seats - ?
                    WHERE departure_id = ?
                ");
                $stmtUpdateSeats->execute([
                    $booking['number_of_people'],
                    $booking['number_of_people'],
                    $booking['departure_id']
                ]);
            }

            $customerName = htmlspecialchars($booking['customer_name'] ?? 'Khách hàng');
            $_SESSION['success'] = "Đã thu tiền mặt thành công đơn <strong>#{$id}</strong> của khách <strong>{$customerName}</strong>!";
        } else {
            $_SESSION['error'] = "Mã đơn hàng không hợp lệ để thu tiền!";
        }

        header("Location: manager.php?action=bookings");
        exit;
    }
    // ================= QUẢN LÝ BÀI VIẾT (CẨM NANG) =================

    public function blogs()
    {
        $stmt = $this->db->query("SELECT * FROM blogs ORDER BY created_at DESC");
        $blogsList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Bạn cần khai báo biến activeMenu để sidebar sáng màu
        $activeMenu = 'blogs';
        require __DIR__ . '/../views/manager/manager_blogs.php';
    }

    public function blogForm()
    {
        $id = $_GET['id'] ?? 0;
        $blog = null;

        if ($id > 0) {
            $stmt = $this->db->prepare("SELECT * FROM blogs WHERE blog_id = ?");
            $stmt->execute([$id]);
            $blog = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        $activeMenu = 'blogs';
        require __DIR__ . '/../views/manager/blog_form.php';
    }

    public function saveBlog()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['blog_id'] ?? 0;
            $title = $_POST['title'] ?? '';
            $category = $_POST['category'] ?? 'Cẩm nang';
            $short_desc = $_POST['short_desc'] ?? '';
            $content = $_POST['content'] ?? '';
            
            // Xử lý upload ảnh (Giống phong cách storeTour của bạn)
            $imageName = $_POST['old_image'] ?? ''; 
            
            if (!empty($_FILES['image']['name'])) {
                $targetDir = __DIR__ . '/../public/uploads/';
                $newImageName = time() . '_' . $_FILES['image']['name'];
                
                // XÓA ẢNH CŨ nếu có update ảnh mới
                if (!empty($imageName) && strpos($imageName, 'http') === false && file_exists($targetDir . $imageName)) {
                    unlink($targetDir . $imageName);
                }

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $newImageName)) {
                    $imageName = $newImageName; 
                }
            }

            if ($id > 0) {
                // SỬA BÀI
                $stmt = $this->db->prepare("UPDATE blogs SET title=?, category=?, short_desc=?, content=?, image=? WHERE blog_id=?");
                $stmt->execute([$title, $category, $short_desc, $content, $imageName, $id]);
                $_SESSION['success'] = "Đã cập nhật bài viết thành công!";
            } else {
                // THÊM BÀI MỚI
                $stmt = $this->db->prepare("INSERT INTO blogs (title, category, short_desc, content, image) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$title, $category, $short_desc, $content, $imageName]);
                $_SESSION['success'] = "Đã thêm bài viết mới thành công!";
            }

            header("Location: manager.php?action=blogs");
            exit;
        }
    }

    public function deleteBlog()
    {
        $id = $_GET['id'] ?? 0;

        if ($id > 0) {
            // Lấy ảnh để xóa file vật lý
            $stmt = $this->db->prepare("SELECT image FROM blogs WHERE blog_id=?");
            $stmt->execute([$id]);
            $blog = $stmt->fetch(PDO::FETCH_ASSOC);

            $path = __DIR__ . '/../public/uploads/';
            if (!empty($blog['image']) && strpos($blog['image'], 'http') === false && file_exists($path . $blog['image'])) {
                unlink($path . $blog['image']);
            }

            // Xóa khỏi DB
            $stmtDel = $this->db->prepare("DELETE FROM blogs WHERE blog_id = ?");
            $stmtDel->execute([$id]);
            
            $_SESSION['success'] = "Đã xóa bài viết thành công!";
        } else {
            $_SESSION['error'] = "Không tìm thấy bài viết để xóa!";
        }

        header("Location: manager.php?action=blogs");
        exit;
    }

}
<?php
require_once __DIR__ . '/../config/database.php';

class ManagerController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function dashboard()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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

        header("Location: manager.php?action=tours");
    }

    // ================= EDIT =================
    public function editTour()
    {
        require_once __DIR__ . '/../models/Tour.php';

        $id = $_GET['id'];

        $tourModel = new Tour($this->db);
        $tour = $tourModel->getTourById($id);

        // 🔥 THÊM DÒNG NÀY
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

        header("Location: manager.php?action=tours");
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

        header("Location: manager.php?action=partners");
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

        header("Location: manager.php?action=partners");
    }
    public function deletePartner()
    {
        $id = $_GET['id'];

        // check có tour không
        $check = $this->db->prepare("SELECT COUNT(*) FROM tours WHERE partner_id=?");
        $check->execute([$id]);

        if ($check->fetchColumn() > 0) {
            echo "<script>alert('Không thể xóa! Đối tác đang có tour'); window.location='manager.php?action=partners';</script>";
            return;
        }

        $stmt = $this->db->prepare("DELETE FROM partners WHERE partner_id=?");
        $stmt->execute([$id]);

        header("Location: manager.php?action=partners");
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
            die("Ngày không hợp lệ");
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

        header("Location: manager.php?action=departures");
    }
    public function updateDeparture()
    {
        $id = $_POST['departure_id'];

        // check ngày
        if ($_POST['end_date'] < $_POST['start_date']) {
            die("Ngày không hợp lệ");
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

        header("Location: manager.php?action=departures");
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
        GROUP BY d.departure_id
        ORDER BY d.start_date DESC
    ");

        $departures = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/manager/departures.php';
    }
    public function deleteDeparture()
    {
        $id = $_GET['id'];

        $stmt = $this->db->prepare("DELETE FROM departures WHERE departure_id=?");
        $stmt->execute([$id]);

        header("Location: manager.php?action=departures");
    }
    public function bookings()
    {
        $stmt = $this->db->query("
        SELECT b.*, t.tour_name, d.start_date
        FROM bookings b
        JOIN departures d ON b.departure_id = d.departure_id
        JOIN tours t ON d.tour_id = t.tour_id
        ORDER BY b.booking_date DESC
    ");

        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/manager/bookings.php';
    }
    public function confirmBooking()
    {
        $id = $_GET['id'];

        // cập nhật trạng thái
        $stmt = $this->db->prepare("
        UPDATE bookings 
        SET status='confirmed' 
        WHERE booking_id=?
    ");
        $stmt->execute([$id]);

        // cập nhật số chỗ
        $stmt = $this->db->prepare("
        UPDATE departures 
        SET 
            booked_seats = booked_seats + 1,
            available_seats = available_seats - 1
        WHERE departure_id = (
            SELECT departure_id FROM bookings WHERE booking_id=?
        )
    ");
        $stmt->execute([$id]);

        header("Location: manager.php?action=bookings");
    }
    public function cancelBooking()
    {
        $id = $_GET['id'];

        $stmt = $this->db->prepare("
        UPDATE bookings 
        SET status='cancelled' 
        WHERE booking_id=?
    ");
        $stmt->execute([$id]);

        header("Location: manager.php?action=bookings");
    }
    public function refundBooking()
    {
        $id = $_GET['id'];

        $stmt = $this->db->prepare("
        UPDATE bookings 
        SET status='refunded' 
        WHERE booking_id=?
    ");
        $stmt->execute([$id]);

        header("Location: manager.php?action=bookings");
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


}
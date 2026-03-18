<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once '../config/database.php';

$db = (new Database())->connect();
$user_id = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'];
$user_name = $_SESSION['user']['name'] ?? 'Khách hàng';
$user_email = $_SESSION['user']['email'] ?? 'Chưa cập nhật email';

// Lấy danh sách booking
$stmt = $db->prepare("
    SELECT 
        b.booking_id, b.customer_name, b.number_of_people, b.total_price, b.status, b.booking_date,
        d.start_date, d.end_date,
        t.tour_name, t.image,
        p.payment_method, p.payment_status, p.payment_id
    FROM bookings b
    JOIN departures d ON b.departure_id = d.departure_id
    JOIN tours t ON d.tour_id = t.tour_id
    LEFT JOIN payments p ON b.booking_id = p.booking_id
    WHERE b.user_id = ?
    ORDER BY b.booking_id DESC
");

$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Đếm số lượng đơn
$totalBookings = count($bookings);
?>

<?php include '../views/layouts/header.php'; ?>

<style>
    :root {
        --primary-color: #0194f3;
        --primary-hover: #007bc2;
        --accent-color: #f96d00;
        --text-dark: #1a202c;
        --text-muted: #64748b;
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
    }

    body { background-color: #f1f5f9; }

    /* --- SIDEBAR MENU CÁ NHÂN --- */
    .user-sidebar-info {
        background: white; border-radius: 20px; padding: 30px 20px;
        text-align: center; border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin-bottom: 20px;
    }
    
    .avatar-circle {
        width: 80px; height: 80px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), #00d2ff);
        color: white; font-size: 2rem; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 15px; box-shadow: 0 4px 10px rgba(1, 148, 243, 0.3);
    }

    .user-sidebar-menu {
        background: white; border-radius: 20px; padding: 15px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .menu-link {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 20px; border-radius: 12px; color: var(--text-dark);
        font-weight: 600; text-decoration: none; transition: 0.2s;
        margin-bottom: 5px;
    }
    .menu-link i { font-size: 1.2rem; color: var(--text-muted); transition: 0.2s; }
    .menu-link:hover { background-color: var(--bg-light); color: var(--primary-color); }
    .menu-link:hover i { color: var(--primary-color); }
    
    .menu-link.active {
        background-color: #eef7ff; color: var(--primary-color);
    }
    .menu-link.active i { color: var(--primary-color); }

    .menu-link.text-danger:hover { background-color: #fef2f2; color: #dc2626; }
    .menu-link.text-danger:hover i { color: #dc2626; }

    /* --- PREMIUM BOOKING CARD (Đã tối ưu lại cho khung to hơn) --- */
    .premium-card {
        background: #ffffff; border-radius: 20px; border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin-bottom: 24px;
        overflow: hidden; transition: all 0.3s ease;
    }
    .premium-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); border-color: #cbd5e1; }

    .card-head {
        background-color: var(--bg-light); padding: 16px 24px;
        border-bottom: 1px solid var(--border-color); display: flex;
        justify-content: space-between; align-items: center;
    }
    .order-info { display: flex; align-items: center; gap: 15px; }
    .order-id { font-weight: 700; color: var(--text-dark); }
    .order-date { color: var(--text-muted); font-size: 0.85rem; }

    .status-badge { padding: 6px 14px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; }
    .badge-pending { background-color: #fef3c7; color: #d97706; }
    .badge-confirmed { background-color: #d1fae5; color: #059669; }
    .badge-cancelled { background-color: #fee2e2; color: #dc2626; }
    .badge-completed { background-color: #e0f2fe; color: #0284c7; }

    .card-body-custom { padding: 24px; }
    .tour-thumbnail { width: 100%; height: 160px; border-radius: 12px; object-fit: cover; }
    
    .tour-title { font-size: 1.25rem; font-weight: 800; color: var(--text-dark); margin-bottom: 12px; }
    .tour-detail-list { list-style: none; padding: 0; margin: 0; }
    .tour-detail-list li { color: #475569; font-size: 0.95rem; margin-bottom: 8px; display: flex; gap: 10px; }
    .tour-detail-list li i { color: var(--primary-color); font-size: 1.1rem; }

    .action-column {
        display: flex; flex-direction: column; justify-content: center; align-items: flex-end;
        height: 100%; padding-left: 20px; border-left: 1px dashed var(--border-color);
    }
    
    .pay-status { font-size: 0.9rem; font-weight: 600; margin-bottom: 8px; }
    .pay-paid { color: #059669; }
    .pay-unpaid { color: #ea580c; }
    
    .total-price { font-size: 1.6rem; font-weight: 800; color: var(--accent-color); margin-bottom: 16px; line-height: 1; }
    
    .btn-action { padding: 10px 24px; border-radius: 10px; font-weight: 600; font-size: 0.95rem; transition: 0.2s; text-align: center; width: 100%; text-decoration: none; display: inline-block;}
    .btn-detail { background-color: #f1f5f9; color: var(--text-dark); border: 1px solid var(--border-color); }
    .btn-detail:hover { background-color: #e2e8f0; color: var(--text-dark); }
    .btn-payment { background-color: var(--primary-color); color: white; box-shadow: 0 4px 10px rgba(1, 148, 243, 0.3); }
    .btn-payment:hover { background-color: var(--primary-hover); color: white; }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .action-column { align-items: flex-start; border-left: none; border-top: 1px dashed var(--border-color); padding-left: 0; padding-top: 20px; margin-top: 15px; }
        .action-buttons { display: flex; gap: 10px; width: 100%; }
        .btn-action { width: auto; flex: 1;}
        .tour-thumbnail { margin-bottom: 15px; height: 200px; }
    }
</style>

<div class="container mt-5 mb-5">
    
    <div class="row g-4">
        
        <div class="col-lg-3">
            <div class="sticky-top" style="top: 100px; z-index: 1;">
                
                <div class="user-sidebar-info">
                    <div class="avatar-circle">
                        <?= mb_strtoupper(mb_substr($user_name, 0, 1, 'UTF-8')) ?>
                    </div>
                    <h5 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($user_name) ?></h5>
                    <p class="text-muted small mb-3"><?= htmlspecialchars($user_email) ?></p>
                    <span class="badge bg-light text-dark border"><i class="bi bi-award text-warning me-1"></i>Thành viên hạng Bạc</span>
                </div>

                <div class="user-sidebar-menu">
                    <a href="profile.php" class="menu-link">
                        <i class="bi bi-person-circle"></i> Tài khoản của tôi
                    </a>
                    <a href="my_booking.php" class="menu-link active">
                        <i class="bi bi-briefcase"></i> Chuyến đi của tôi
                        <span class="badge bg-primary rounded-pill ms-auto"><?= $totalBookings ?></span>
                    </a>
                    <hr class="my-2" style="border-color: var(--border-color);">
                    <a href="../controllers/logout.php" class="menu-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </a>
                </div>

            </div>
        </div>

        <div class="col-lg-9">
            <h3 class="fw-bold text-dark mb-4">Danh sách chuyến đi</h3>

            <?php if (empty($bookings)): ?>
                <div class="text-center bg-white p-5 rounded-4 shadow-sm border" style="border-radius: 20px !important;">
                    <img src="https://cdn-icons-png.flaticon.com/512/3284/3284615.png" alt="Empty" width="120" class="mb-3 opacity-50">
                    <h4 class="fw-bold text-dark">Bạn chưa có chuyến đi nào</h4>
                    <p class="text-muted">Hãy lên kế hoạch cho kỳ nghỉ tuyệt vời tiếp theo của bạn ngay hôm nay!</p>
                    <a href="tours.php" class="btn btn-primary btn-lg mt-3 px-5" style="border-radius: 50px;">Khám phá tour ngay</a>
                </div>
            <?php else: ?>
                
                <?php foreach ($bookings as $b): ?>
                    <?php 
                        $statusClass = 'badge-pending'; $statusText = 'Chờ xác nhận';
                        if ($b['status'] == 'confirmed') { $statusClass = 'badge-confirmed'; $statusText = 'Đã xác nhận'; }
                        elseif ($b['status'] == 'cancelled') { $statusClass = 'badge-cancelled'; $statusText = 'Đã hủy'; }
                        elseif ($b['status'] == 'completed') { $statusClass = 'badge-completed'; $statusText = 'Hoàn tất'; }

                        $payMethod = strtoupper($b['payment_method'] ?? '');
                        $payMethodText = ($payMethod == 'QR') ? 'Chuyển khoản QR' : (($payMethod == 'CASH') ? 'Tiền mặt' : 'Chưa chọn');
                        
                        $payStatus = $b['payment_status'] ?? 'pending';
                        if ($payStatus == 'paid') {
                            $payHTML = '<div class="pay-status pay-paid"><i class="bi bi-shield-check"></i> Đã thanh toán</div>';
                        } else {
                            $payHTML = '<div class="pay-status pay-unpaid"><i class="bi bi-exclamation-circle"></i> Chưa thanh toán</div>';
                        }
                    ?>

                    <div class="premium-card">
                        <div class="card-head">
                            <div class="order-info">
                                <span class="order-id"><i class="bi bi-receipt me-1 text-muted"></i> Mã đơn: #<?= str_pad($b['booking_id'], 6, '0', STR_PAD_LEFT) ?></span>
                                <span class="order-date d-none d-sm-inline-block"><i class="bi bi-clock"></i> Đặt lúc: <?= !empty($b['booking_date']) ? date('H:i - d/m/Y', strtotime($b['booking_date'])) : '--' ?></span>
                            </div>
                            <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
                        </div>

                        <div class="card-body-custom">
                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    <img src="<?= !empty($b['image']) ? '../public/uploads/'.$b['image'] : 'https://images.unsplash.com/photo-1501785888041-af3ef285b470' ?>" class="tour-thumbnail" alt="Tour">
                                </div>
                                
                                <div class="col-lg-6 col-md-8">
                                    <h4 class="tour-title"><?= htmlspecialchars($b['tour_name']) ?></h4>
                                    <ul class="tour-detail-list">
                                        <li><i class="bi bi-calendar2-check"></i><span>Khởi hành: <strong><?= date('d/m/Y', strtotime($b['start_date'])) ?></strong> <i class="bi bi-arrow-right mx-1 text-muted"></i> <?= date('d/m/Y', strtotime($b['end_date'])) ?></span></li>
                                        <li><i class="bi bi-people"></i><span>Hành khách: <strong><?= $b['number_of_people'] ?> người</strong> <span class="text-muted">(<?= htmlspecialchars($b['customer_name']) ?>)</span></span></li>
                                        <li><i class="bi bi-wallet2"></i><span>Phương thức: <strong><?= $payMethodText ?></strong></span></li>
                                    </ul>
                                </div>

                                <div class="col-lg-3 col-12">
                                    <div class="action-column">
                                        <div class="text-lg-end text-start w-100">
                                            <?= $payHTML ?>
                                            <div class="text-muted" style="font-size: 0.85rem;">Tổng tiền</div>
                                            <div class="total-price"><?= number_format($b['total_price']) ?> <span style="font-size: 1rem;">đ</span></div>
                                        </div>
                                        
                                        <div class="action-buttons w-100 d-flex flex-column gap-2 mt-auto">
                                            <?php if ($payMethod == 'QR' && $payStatus == 'pending' && $b['status'] != 'cancelled'): ?>
                                                <a href="payment_qr.php?payment_id=<?= $b['payment_id'] ?>" class="btn-action btn-payment">Thanh toán ngay</a>
                                            <?php endif; ?>
                                            <a href="success.php?booking_id=<?= $b['booking_id'] ?>" class="btn-action btn-detail">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../views/layouts/footer.php'; ?>
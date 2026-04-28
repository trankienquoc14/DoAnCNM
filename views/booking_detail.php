<?php
// Không cần session_start() hay truy vấn DB ở đây nữa vì Controller đã làm rồi.
// Dữ liệu bây giờ nằm trong biến $booking (được truyền từ TourController).
$data = $booking;

// Xử lý hiển thị trạng thái
$isPaid = (isset($data['payment_status']) && $data['payment_status'] == 'paid');
$iconClass = $isPaid ? "bi-check-circle-fill text-success" : "bi-exclamation-circle-fill text-warning";
$titleText = $isPaid ? "Đặt tour & Thanh toán thành công!" : "Đã ghi nhận đơn đặt tour!";
?>

<?php include 'layouts/header.php'; ?>

<style>
    :root {
        --primary-color: #0194f3;
        --accent-color: #f96d00;
        --text-dark: #1a202c;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
    }

    body {
        background-color: #f1f5f9;
    }

    .receipt-container {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        padding: 40px;
    }

    .success-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .success-icon {
        font-size: 5rem;
        line-height: 1;
        margin-bottom: 15px;
    }

    .success-title {
        font-weight: 800;
        color: var(--text-dark);
        font-size: 1.8rem;
        margin-bottom: 8px;
    }

    .order-id-badge {
        display: inline-block;
        background: var(--bg-light);
        padding: 8px 20px;
        border-radius: 50px;
        color: var(--text-muted);
        font-weight: 600;
        border: 1px dashed #cbd5e1;
    }

    .info-section h5 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 2px solid var(--bg-light);
        padding-bottom: 10px;
    }

    .info-row {
        margin-bottom: 12px;
        display: flex;
        flex-direction: column;
    }

    .info-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 4px;
    }

    .info-value {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.05rem;
    }

    .total-box {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 16px;
        padding: 25px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid var(--border-color);
        margin-top: 10px;
    }

    .total-amount {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--accent-color);
        line-height: 1;
    }

    .sidebar-img-card {
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        height: 220px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .sidebar-img-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sidebar-img-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        padding: 20px;
        color: white;
    }

    .support-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .support-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .support-list li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 15px;
    }

    .support-list i {
        color: var(--primary-color);
        font-size: 1.2rem;
    }

    .badge-status {
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .bg-success-soft {
        background-color: #d1fae5;
        color: #059669;
    }

    .bg-warning-soft {
        background-color: #fef3c7;
        color: #d97706;
    }
</style>

<div class="container mt-5 mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=myBookings"
                    class="text-decoration-none text-muted">Đơn của tôi</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">Chi tiết đơn hàng</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="receipt-container">
                <div class="success-header">
                    <div class="success-icon"><i class="bi <?= $iconClass ?>"></i></div>
                    <h2 class="success-title"><?= $titleText ?></h2>
                    <div class="order-id-badge">Mã đơn hàng: #<?= str_pad($data['booking_id'], 6, '0', STR_PAD_LEFT) ?>
                    </div>
                </div>

                <?php if (strtoupper($data['payment_method'] ?? '') == 'QR' && !$isPaid && $data['status'] != 'cancelled'): ?>
                    <div class="alert alert-warning d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 border-0 shadow-sm"
                        style="background-color: #fffbeb; border-radius: 12px; padding: 20px;">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <i class="bi bi-info-circle-fill fs-2 text-warning me-3"></i>
                            <div>
                                <strong class="fs-5 text-dark">Vui lòng thanh toán!</strong><br>
                                <span class="text-muted">Hệ thống đang chờ bạn chuyển khoản để hoàn tất giữ chỗ.</span>
                            </div>
                        </div>
                        <a href="index.php?action=payment&payment_id=<?= encode_id($data['payment_id'] ?? 0) ?>&booking_id=<?= encode_id($data['booking_id'] ?? 0) ?>"
                            class="btn btn-warning px-4 py-2 fw-bold text-white shadow-sm"
                            style="background-color: #f59e0b; border: none; white-space: nowrap;">
                            <i class="bi bi-qr-code-scan me-1"></i> Thanh toán ngay
                        </a>
                    </div>
                <?php endif; ?>

                <div class="row g-5">
                    <div class="col-md-6 info-section">
                        <h5><i class="bi bi-person-vcard text-primary"></i> Thông tin liên hệ</h5>
                        <div class="info-row"><span class="info-label">Người đặt:</span><span
                                class="info-value"><?= htmlspecialchars($data['customer_name']) ?></span></div>
                        <div class="info-row"><span class="info-label">Số điện thoại:</span><span
                                class="info-value"><?= htmlspecialchars($data['phone'] ?? 'Đang cập nhật') ?></span>
                        </div>
                        <div class="info-row"><span class="info-label">Email:</span><span
                                class="info-value"><?= htmlspecialchars($data['email'] ?? 'Đang cập nhật') ?></span>
                        </div>
                        <div class="info-row"><span class="info-label">Số khách:</span><span
                                class="info-value"><?= $data['number_of_people'] ?> người</span></div>
                    </div>

                    <div class="col-md-6 info-section">
                        <h5><i class="bi bi-map text-primary"></i> Chi tiết dịch vụ</h5>
                        <div class="info-row"><span class="info-label">Tên Tour:</span><span
                                class="info-value text-primary"><?= htmlspecialchars($data['tour_name'] ?? '--') ?></span>
                        </div>
                        <div class="info-row"><span class="info-label">Ngày khởi hành:</span><span
                                class="info-value"><?= !empty($data['start_date']) ? date('d/m/Y', strtotime($data['start_date'])) : '--' ?></span>
                        </div>

                        <!-- BẮT ĐẦU: HIỂN THỊ ĐIỂM ĐÓN VỪA THÊM -->
                        <div class="info-row">
                            <span class="info-label">Điểm đón / Tập trung:</span>
                            <span class="info-value text-primary">
                                <i class="bi bi-geo-alt-fill me-1"></i>
                                <?= htmlspecialchars($data['pickup_address'] ?? 'Đang cập nhật') ?>
                            </span>
                        </div>
                        <!-- KẾT THÚC: HIỂN THỊ ĐIỂM ĐÓN -->

                        <div class="info-row"><span class="info-label">Trạng thái đơn:</span>
                            <div>
                                <?php if ($data['status'] == 'confirmed'): ?>
                                    <span class="badge-status bg-success-soft">Đã xác nhận</span>
                                <?php elseif ($data['status'] == 'cancelled'): ?>
                                    <span class="badge-status bg-danger text-white">Đã hủy</span>
                                <?php else: ?>
                                    <span class="badge-status bg-warning-soft">Chờ xử lý</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="total-box mt-5">
                    <div>
                        <span class="d-block text-muted fw-bold mb-2">Tổng thanh toán</span>
                        <span class="badge-status <?= $isPaid ? 'bg-success-soft' : 'bg-warning-soft' ?>">
                            <i class="bi bi-wallet2 me-1"></i><?= $isPaid ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                        </span>
                    </div>
                    <div class="total-amount"><?= number_format($data['total_price']) ?> <span
                            style="font-size: 1.2rem;">đ</span></div>
                </div>

                <div class="d-flex flex-wrap gap-3 mt-4 justify-content-center">
                    <a href="index.php?action=myBookings" class="btn btn-light px-4 py-2 fw-semibold border">Quản lý
                        đơn</a>
                    <a href="index.php?action=tours" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm">Xem Tour
                        khác</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sidebar-img-card">
                <img src="<?= !empty($data['image']) ? '../public/uploads/' . $data['image'] : 'https://images.unsplash.com/photo-1501785888041-af3ef285b470' ?>"
                    alt="Destination">
                <div class="sidebar-img-overlay">
                    <h5 class="mb-0 fw-bold"><i
                            class="bi bi-geo-alt-fill text-danger me-1"></i><?= htmlspecialchars($data['destination'] ?? 'Khám phá mới') ?>
                    </h5>
                </div>
            </div>
            <div class="support-card">
                <h5 class="fw-bold mb-4">Cần sự trợ giúp?</h5>
                <ul class="support-list">
                    <li><i class="bi bi-telephone-inbound"></i>
                        <div>
                            <div class="text-muted small">Hotline 24/7</div>
                            <div class="fw-bold">1900 1234</div>
                        </div>
                    </li>
                    <li><i class="bi bi-envelope-paper"></i>
                        <div>
                            <div class="text-muted small">Email hỗ trợ</div>
                            <div class="fw-bold">support@travelvn.com</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
<?php 
    $activeMenu = 'bookings';
    include __DIR__ . '/../layouts/header.php'; 
?>

<style>
    :root {
        --admin-primary: #0194f3;
        --admin-bg: #f1f5f9; 
        --admin-surface: #ffffff;
        --admin-border: #e2e8f0;
        --admin-text-main: #0f172a; 
        --admin-text-muted: #475569; 
    }

    body { background-color: var(--admin-bg); font-family: 'Inter', sans-serif; }
    .admin-container { max-width: 1300px; margin: 40px auto; padding: 0 15px; }
    .admin-card { background: var(--admin-surface); border-radius: 20px; padding: 24px; border: 1px solid var(--admin-border); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .info-group { margin-bottom: 20px; }
    .info-label { font-size: 0.85rem; color: var(--admin-text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 5px; }
    .info-value { font-size: 1.1rem; color: var(--admin-text-main); font-weight: 600; }
    .tour-img { width: 100%; height: 80px; object-fit: cover; border-radius: 12px; }

    /* Style cho thanh hành động dưới cùng */
    .action-bar {
        background: white;
        padding: 20px;
        border-radius: 20px;
        margin-top: 25px;
        border: 1px solid var(--admin-border);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.02);
    }
    .btn-lg-custom {
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
    }
</style>

<div class="admin-container">
    <div class="row g-4">
        
        <?php include __DIR__ . '/../layouts/sidebar_manager.php'; ?>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Đơn hàng #<?= str_pad($detail['booking_id'], 6, '0', STR_PAD_LEFT) ?></h2>
                    <p class="text-muted mb-0">Trạng thái: 
                        <?php if($detail['status'] == 'pending'): ?>
                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                        <?php elseif($detail['status'] == 'confirmed'): ?>
                            <span class="badge bg-success text-white">Đã duyệt</span>
                        <?php elseif($detail['status'] == 'cancelled'): ?>
                            <span class="badge bg-danger text-white">Đã hủy</span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?= $detail['status'] ?></span>
                        <?php endif; ?>
                    </p>
                </div>
                <a href="manager.php?action=bookings" class="btn btn-light border shadow-sm fw-bold"><i class="bi bi-arrow-left"></i> Quay lại</a>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="admin-card h-100">
                        <h5 class="fw-bold text-primary mb-4"><i class="bi bi-person-lines-fill me-2"></i>Thông tin người đặt</h5>
                        
                        <div class="info-group">
                            <div class="info-label">Họ và tên</div>
                            <div class="info-value"><?= htmlspecialchars($detail['customer_name']) ?></div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Số điện thoại</div>
                            <div class="info-value text-primary"><?= htmlspecialchars($detail['phone'] ?? 'Chưa cung cấp') ?></div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?= htmlspecialchars($detail['email'] ?? 'Chưa cung cấp') ?></div>
                        </div>
                        <div class="info-group mb-0">
                            <div class="info-label">Ghi chú của khách</div>
                            <div class="info-value text-danger" style="font-style: italic; font-size: 0.95rem;">
                                <?= !empty($detail['note']) ? nl2br(htmlspecialchars($detail['note'])) : 'Không có ghi chú' ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="admin-card h-100">
                        <h5 class="fw-bold text-primary mb-4"><i class="bi bi-wallet2 me-2"></i>Dịch vụ & Thanh toán</h5>
                        
                        <div class="d-flex gap-3 mb-4 bg-light p-2 rounded-3">
                            <img src="<?= !empty($detail['image']) ? '../public/uploads/'.$detail['image'] : 'https://images.unsplash.com/photo-1501785888041-af3ef285b470' ?>" class="tour-img" alt="Tour">
                            <div class="overflow-hidden">
                                <h6 class="fw-bold text-truncate mb-1"><?= htmlspecialchars($detail['tour_name']) ?></h6>
                                <p class="mb-0 text-muted small"><i class="bi bi-calendar-check"></i> Đi: <?= date('d/m/Y', strtotime($detail['start_date'])) ?></p>
                                <p class="mb-0 text-muted small"><i class="bi bi-people"></i> Số khách: <?= $detail['number_of_people'] ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 info-group">
                                <div class="info-label">Phương thức</div>
                                <div class="info-value small"><?= strtoupper($detail['payment_method'] ?? 'CASH') ?></div>
                            </div>
                            <div class="col-6 info-group">
                                <div class="info-label">Thanh toán</div>
                                <div>
                                    <?php if (($detail['payment_status'] ?? '') === 'paid'): ?>
                                        <span class="text-success fw-bold small"><i class="bi bi-patch-check-fill"></i> Đã trả tiền</span>
                                    <?php else: ?>
                                        <span class="text-warning fw-bold small"><i class="bi bi-hourglass-split"></i> Chờ tiền</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="info-group mb-0 bg-dark text-white p-3 rounded-3 mt-2">
                            <div class="info-label text-white-50">Tổng cộng đơn hàng</div>
                            <div class="info-value text-warning fs-3 fw-bold"><?= number_format($detail['total_price']) ?> đ</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-bar shadow-sm">
                
                <?php if ($detail['status'] != 'cancelled' && $detail['status'] != 'refunded'): ?>
                    <a href="manager.php?action=cancelBooking&id=<?= $detail['booking_id'] ?>" 
                       class="btn btn-outline-danger btn-lg-custom" 
                       onclick="return confirm('Bạn có chắc muốn hủy đơn đặt này?')">
                        <i class="bi bi-x-circle"></i> Hủy đơn hàng
                    </a>
                <?php endif; ?>

                <?php if ($detail['status'] == 'confirmed'): ?>
                    <a href="manager.php?action=refundBooking&id=<?= $detail['booking_id'] ?>" 
                       class="btn btn-warning btn-lg-custom" 
                       onclick="return confirm('Xác nhận hoàn tiền cho đơn này?')">
                        <i class="bi bi-arrow-counterclockwise"></i> Hoàn tiền khách
                    </a>
                <?php endif; ?>

                <?php if ($detail['status'] == 'pending'): ?>
                    <a href="manager.php?action=confirmBooking&id=<?= $detail['booking_id'] ?>" 
                       class="btn btn-success btn-lg-custom shadow" 
                       onclick="return confirm('Xác nhận duyệt đơn hàng này?')">
                        <i class="bi bi-check2-circle"></i> Duyệt đơn ngay
                    </a>
                <?php endif; ?>

            </div>
            
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
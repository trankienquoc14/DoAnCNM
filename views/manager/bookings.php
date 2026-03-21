<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    /* --- BIẾN MÀU & CẤU TRÚC CHUNG --- */
    :root {
        --admin-primary: #0194f3;
        --admin-primary-light: #eef7ff;
        --admin-success: #10b981;
        --admin-warning: #f59e0b;
        --admin-danger: #ef4444;
        --admin-bg: #f1f5f9; 
        --admin-surface: #ffffff;
        --admin-border: #e2e8f0;
        --admin-text-main: #0f172a; 
        --admin-text-muted: #475569; 
    }

    body {
        background-color: var(--admin-bg);
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    .admin-container {
        max-width: 1300px;
        margin: 40px auto;
        padding: 0 15px;
    }

    /* --- HEADER PHẢI --- */
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 30px;
    }

    .admin-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--admin-text-main);
        margin-bottom: 5px;
    }

    /* --- TÙY CHỈNH BẢNG (TABLE) --- */
    .admin-card {
        background: var(--admin-surface);
        border-radius: 20px;
        padding: 24px;
        border: 1px solid var(--admin-border);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    .table th {
        background-color: var(--admin-bg);
        color: var(--admin-text-muted);
        font-weight: 600;
        border-bottom-width: 1px;
        padding: 15px;
        white-space: nowrap;
    }
    
    .table td {
        padding: 15px;
        vertical-align: middle;
        color: var(--admin-text-main);
        border-bottom: 1px solid var(--admin-border);
    }

    .table-hover tbody tr:hover {
        background-color: var(--admin-primary-light);
    }
    
    /* Làm đẹp nút bấm Action */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        transition: 0.2s;
    }
</style>

<div class="admin-container">
    <div class="row g-4">
        
        <?php 
            $activeMenu = 'bookings'; 
            include __DIR__ . '/../layouts/sidebar_manager.php'; 
        ?>

        <div class="col-lg-9">
            
            <div class="admin-header">
                <div>
                    <h1 class="admin-title">Đơn Đặt (Bookings)</h1>
                    <p class="text-muted mb-0 fw-medium">Quản lý giao dịch, trạng thái thanh toán và thông tin khách đặt tour.</p>
                </div>
            </div>

            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th width="20%" class="border-top-0">Khách hàng</th>
                                <th width="30%" class="border-top-0">Thông tin chuyến đi</th>
                                <th width="15%" class="border-top-0 text-end">Tổng tiền</th>
                                <th width="15%" class="text-center border-top-0">Trạng thái</th>
                                <th width="20%" class="text-center border-top-0">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bookings)): ?>
                                <?php foreach ($bookings as $b): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($b['customer_name']) ?></div>
                                            <div class="small text-muted mt-1">
                                                <i class="bi bi-people-fill me-1"></i> <?= $b['number_of_people'] ?> người
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="fw-bold text-primary text-wrap" style="max-width: 250px;">
                                                <?= htmlspecialchars($b['tour_name']) ?>
                                            </div>
                                            <div class="small text-muted mt-1 fw-medium">
                                                <i class="bi bi-calendar-check me-1"></i> Khởi hành: <?= date('d/m/Y', strtotime($b['start_date'])) ?>
                                            </div>
                                        </td>
                                        
                                        <td class="text-end">
                                            <div class="fw-bold text-danger fs-6">
                                                <?= number_format($b['total_price']) ?> đ
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <?php if ($b['status'] == 'pending'): ?>
                                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Chờ duyệt</span>
                                            <?php elseif ($b['status'] == 'confirmed'): ?>
                                                <span class="badge bg-success rounded-pill px-3 py-2">Đã duyệt</span>
                                            <?php elseif ($b['status'] == 'cancelled'): ?>
                                                <span class="badge bg-danger rounded-pill px-3 py-2">Đã hủy</span>
                                            <?php elseif ($b['status'] == 'refunded'): ?>
                                                <span class="badge bg-secondary rounded-pill px-3 py-2">Đã hoàn tiền</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center flex-wrap gap-2">
                                                
                                                <?php if ($b['status'] == 'pending'): ?>
                                                    <a href="manager.php?action=confirmBooking&id=<?= $b['booking_id'] ?>" class="btn btn-success fw-bold btn-action shadow-sm" onclick="return confirm('Xác nhận duyệt đơn đặt này?')">
                                                        <i class="bi bi-check-circle-fill"></i> Duyệt
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($b['status'] == 'confirmed'): ?>
                                                    <a href="manager.php?action=refundBooking&id=<?= $b['booking_id'] ?>" class="btn btn-warning fw-bold text-dark btn-action shadow-sm" onclick="return confirm('Xác nhận hoàn tiền cho đơn này?')">
                                                        <i class="bi bi-arrow-counterclockwise"></i> Hoàn tiền
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($b['status'] != 'cancelled'): ?>
                                                    <a href="manager.php?action=cancelBooking&id=<?= $b['booking_id'] ?>" class="btn btn-outline-danger fw-bold btn-action bg-white" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn đặt này?')">
                                                        <i class="bi bi-x-circle-fill"></i> Hủy
                                                    </a>
                                                <?php endif; ?>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-receipt-cutoff fs-1 d-block mb-2 text-secondary"></i>
                                        <p class="fw-medium mb-0">Chưa có đơn đặt tour nào trên hệ thống.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
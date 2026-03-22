<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    /* --- BIẾN MÀU & CẤU TRÚC CHUNG --- */
    :root {
        --admin-primary: #0194f3;
        --admin-primary-light: #eef7ff;
        --admin-success: #10b981;
        --admin-warning: #f59e0b;
        --admin-danger: #ef4444;
        --admin-info: #0ea5e9;
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
        max-width: 1350px; /* Tăng nhẹ độ rộng để bảng thoải mái hơn */
        margin: 40px auto;
        padding: 0 15px;
    }

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

    .admin-card {
        background: var(--admin-surface);
        border-radius: 20px;
        padding: 24px;
        border: 1px solid var(--admin-border);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    .table th {
        background-color: #f8fafc;
        color: var(--admin-text-muted);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 15px;
        border-bottom: 2px solid var(--admin-border);
    }
    
    .table td {
        padding: 15px;
        vertical-align: middle;
        color: var(--admin-text-main);
        border-bottom: 1px solid var(--admin-border);
    }

    /* Style riêng cho các nút hành động dạng dọc */
    .btn-manage {
        width: 55px;
        height: 52px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 2px;
        border-radius: 12px;
        font-size: 0.65rem;
        font-weight: 800;
        transition: all 0.2s;
        border: 1px solid transparent;
        text-decoration: none !important;
    }

    .btn-manage i {
        font-size: 1.2rem;
    }

    .btn-manage-info { background-color: #f0f9ff; color: #0369a1; border-color: #bae6fd; }
    .btn-manage-info:hover { background-color: #0369a1; color: white; }

    .btn-manage-success { background-color: #ecfdf5; color: #059669; border-color: #a7f3d0; }
    .btn-manage-success:hover { background-color: #059669; color: white; }

    .btn-manage-warning { background-color: #fffbeb; color: #d97706; border-color: #fef3c7; }
    .btn-manage-warning:hover { background-color: #d97706; color: white; }

    .btn-manage-danger { background-color: #fef2f2; color: #dc2626; border-color: #fecdd3; }
    .btn-manage-danger:hover { background-color: #dc2626; color: white; }

    .badge-pill {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
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
                    <h1 class="admin-title">Quản Lý Đơn Đặt Tour</h1>
                    <p class="text-muted mb-0 fw-medium">Theo dõi giao dịch và cập nhật trạng thái đơn hàng của hệ thống.</p>
                </div>
            </div>

            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th width="18%">Khách hàng</th>
                                <th width="32%">Tour & Khởi hành</th>
                                <th width="15%" class="text-end">Tổng tiền</th>
                                <th width="15%" class="text-center">Trạng thái</th>
                                <th width="20%" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bookings)): ?>
                                <?php foreach ($bookings as $b): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($b['customer_name']) ?></div>
                                            <div class="small text-muted mt-1">
                                                <i class="bi bi-people-fill me-1"></i> <?= $b['number_of_people'] ?> khách
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="fw-bold text-primary mb-1" style="font-size: 0.95rem;">
                                                <?= htmlspecialchars($b['tour_name']) ?>
                                            </div>
                                            <div class="small text-muted fw-medium">
                                                <i class="bi bi-calendar3 me-1"></i> <?= date('d/m/Y', strtotime($b['start_date'])) ?>
                                            </div>
                                        </td>
                                        
                                        <td class="text-end">
                                            <div class="fw-bold text-danger" style="font-size: 1.05rem;">
                                                <?= number_format($b['total_price']) ?> đ
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <?php if ($b['status'] == 'pending'): ?>
                                                <span class="badge badge-pill bg-warning text-dark">Chờ duyệt</span>
                                            <?php elseif ($b['status'] == 'confirmed'): ?>
                                                <span class="badge badge-pill bg-success text-white">Đã duyệt</span>
                                            <?php elseif ($b['status'] == 'cancelled'): ?>
                                                <span class="badge badge-pill bg-danger text-white">Đã hủy</span>
                                            <?php elseif ($b['status'] == 'refunded'): ?>
                                                <span class="badge badge-pill bg-secondary text-white">Hoàn tiền</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center align-items-center gap-1">
                                                
                                                <a href="manager.php?action=bookingDetail&id=<?= $b['booking_id'] ?>" 
                                                   class="btn-manage btn-manage-info" title="Xem chi tiết">
                                                    <i class="bi bi-eye-fill"></i>
                                                    <span>Xem</span>
                                                </a>
                                                
                                                <?php if ($b['status'] == 'pending'): ?>
                                                    <a href="manager.php?action=confirmBooking&id=<?= $b['booking_id'] ?>" 
                                                       class="btn-manage btn-manage-success" title="Duyệt đơn" 
                                                       onclick="return confirm('Bạn chắc chắn muốn duyệt đơn này?')">
                                                        <i class="bi bi-check-lg"></i>
                                                        <span>Duyệt</span>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($b['status'] == 'confirmed'): ?>
                                                    <a href="manager.php?action=refundBooking&id=<?= $b['booking_id'] ?>" 
                                                       class="btn-manage btn-manage-warning" title="Hoàn tiền" 
                                                       onclick="return confirm('Xác nhận hoàn tiền cho đơn này?')">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                        <span>Hoàn tiền</span>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($b['status'] != 'cancelled' && $b['status'] != 'refunded'): ?>
                                                    <a href="manager.php?action=cancelBooking&id=<?= $b['booking_id'] ?>" 
                                                       class="btn-manage btn-manage-danger" title="Hủy đơn" 
                                                       onclick="return confirm('Bạn có chắc muốn hủy đơn đặt này?')">
                                                        <i class="bi bi-x-circle"></i>
                                                        <span>Hủy</span>
                                                    </a>
                                                <?php endif; ?>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-25"></i>
                                        <p class="fw-medium mb-0">Hiện chưa có dữ liệu đơn đặt tour nào.</p>
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
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

    .date-pill {
        background: white;
        border: 1px solid var(--admin-border);
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--admin-text-muted);
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    /* --- STAT CARDS NÂNG CẤP --- */
    .stat-card {
        background: var(--admin-surface);
        border-radius: 20px;
        padding: 24px;
        border: 1px solid var(--admin-border);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        transform: translateY(-3px);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-icon.blue { background: #e0f2fe; color: #0284c7; }
    .stat-icon.green { background: #d1fae5; color: #059669; }
    .stat-icon.orange { background: #ffedd5; color: #d97706; }

    .stat-label {
        font-weight: 700;
        color: var(--admin-text-muted);
        font-size: 0.95rem;
    }

    .stat-value {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--admin-text-main);
        margin: 0;
        line-height: 1.2;
    }

    .stat-trend {
        font-size: 0.85rem;
        font-weight: 600;
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .trend-up { color: var(--admin-success); }

    /* --- THAO TÁC NHANH --- */
    .quick-actions-box {
        background: white;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid var(--admin-border);
        margin-top: 30px;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 20px;
        border-radius: 16px;
        font-weight: 700;
        text-decoration: none;
        transition: 0.3s;
        border: 1px solid transparent;
    }

    .action-btn i { font-size: 2rem; margin-bottom: 5px; transition: 0.3s; }
    .action-btn:hover { transform: translateY(-3px); }
    .action-btn:hover i { transform: scale(1.1); }

    .btn-tour { background-color: #e0f2fe; color: #0284c7; border-color: #bae6fd; }
    .btn-tour:hover { background-color: #bae6fd; box-shadow: 0 5px 15px rgba(2, 132, 199, 0.2); }

    .btn-schedule { background-color: #ffedd5; color: #d97706; border-color: #fed7aa; }
    .btn-schedule:hover { background-color: #fed7aa; box-shadow: 0 5px 15px rgba(217, 119, 6, 0.2); }

    .btn-booking { background-color: #d1fae5; color: #059669; border-color: #a7f3d0; }
    .btn-booking:hover { background-color: #a7f3d0; box-shadow: 0 5px 15px rgba(5, 150, 105, 0.2); }

    .btn-report { background-color: #f3e8ff; color: #7e22ce; border-color: #e9d5ff; }
    .btn-report:hover { background-color: #e9d5ff; box-shadow: 0 5px 15px rgba(126, 34, 206, 0.2); }
</style>

<div class="admin-container">
    <div class="row g-4">
        
        <?php 
            $activeMenu = 'dashboard'; 
            include __DIR__ . '/../layouts/sidebar_manager.php'; 
        ?>

        <div class="col-lg-9">
            
            <div class="admin-header">
                <div>
                    <h1 class="admin-title">Báo cáo hoạt động</h1>
                    <p class="text-muted mb-0 fw-medium">Theo dõi các chỉ số quan trọng của hệ thống TravelVN.</p>
                </div>
                <div class="d-none d-md-block">
                    <div class="date-pill">
                        <i class="bi bi-calendar3 text-primary"></i> <?= date('d/m/Y') ?>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Tổng Tour Hệ Thống</span>
                            <div class="stat-icon blue"><i class="bi bi-map-fill"></i></div>
                        </div>
                        <h3 class="stat-value"><?= number_format($totalTours ?? 0) ?></h3>
                        <div class="stat-trend trend-up">
                            <i class="bi bi-arrow-up-right-circle-fill"></i> Đang hoạt động tốt
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Đơn Đặt (Bookings)</span>
                            <div class="stat-icon green"><i class="bi bi-bag-check-fill"></i></div>
                        </div>
                        <h3 class="stat-value"><?= number_format($totalBookings ?? 0) ?></h3>
                        <div class="stat-trend trend-up">
                            <i class="bi bi-arrow-up-right-circle-fill"></i> Tỷ lệ chuyển đổi cao
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Tổng Doanh Thu</span>
                            <div class="stat-icon orange"><i class="bi bi-wallet2"></i></div>
                        </div>
                        <h3 class="stat-value text-danger">
                            <?= number_format($totalRevenue ?? 0) ?> <span style="font-size: 1.2rem; font-weight: 600; color: var(--admin-text-muted);">đ</span>
                        </h3>
                        <div class="stat-trend trend-up">
                            <i class="bi bi-arrow-up-right-circle-fill"></i> Doanh thu đã xác nhận
                        </div>
                    </div>
                </div>
            </div>

            <div class="quick-actions-box">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Truy cập nhanh</h5>
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <a href="../public/manager.php?action=createTour" class="action-btn btn-tour">
                            <i class="bi bi-map"></i>
                            Tạo Tour
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="../public/manager.php?action=createDeparture" class="action-btn btn-schedule">
                            <i class="bi bi-calendar-plus"></i>
                            Tạo Lịch
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="../public/manager.php?action=bookings" class="action-btn btn-booking">
                            <i class="bi bi-check2-circle"></i>
                            Duyệt Đơn
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="../public/manager.php?action=report" class="action-btn btn-report">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                            Thống kê
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
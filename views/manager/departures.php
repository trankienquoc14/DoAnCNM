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

    /* --- GIAO DIỆN THẺ LỊCH TRÌNH (NEW DESIGN) --- */
    .departure-card {
        background: var(--admin-surface);
        border-radius: 16px;
        border: 1px solid var(--admin-border);
        padding: 20px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .departure-card:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        border-color: #bae6fd;
    }

    /* Khối ngày tháng như tờ lịch */
    .date-block {
        background: var(--admin-primary-light);
        color: var(--admin-primary);
        border-radius: 12px;
        min-width: 80px;
        text-align: center;
        padding: 10px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .date-block .month { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; }
    .date-block .day { font-size: 1.8rem; font-weight: 800; line-height: 1; margin: 5px 0; }
    .date-block .year { font-size: 0.8rem; font-weight: 600; opacity: 0.8; }

    /* Thông tin chính */
    .info-block {
        flex: 1;
    }
    .tour-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--admin-text-main);
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .meta-info {
        font-size: 0.9rem;
        color: var(--admin-text-muted);
        display: flex;
        gap: 15px;
        align-items: center;
    }

    /* Thanh tiến trình (Progress Bar) */
    .seats-block {
        width: 200px;
    }
    .seats-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: var(--admin-text-muted);
    }
    .progress {
        height: 8px;
        border-radius: 10px;
        background-color: var(--admin-border);
    }
    .progress-bar {
        border-radius: 10px;
    }

    /* Nút hành động */
    .action-block {
        display: flex;
        gap: 8px;
        border-left: 1px dashed var(--admin-border);
        padding-left: 20px;
    }
    
    @media (max-width: 768px) {
        .departure-card { flex-direction: column; align-items: stretch; text-align: center; }
        .action-block { border-left: none; border-top: 1px dashed var(--admin-border); padding-top: 15px; padding-left: 0; justify-content: center; }
        .seats-block { width: 100%; margin-top: 10px; }
        .meta-info { justify-content: center; flex-wrap: wrap; }
    }
</style>

<div class="admin-container">
    <div class="row g-4">
        
        <?php 
            $activeMenu = 'departures'; 
            include __DIR__ . '/../layouts/sidebar_manager.php'; 
        ?>

        <div class="col-lg-9">
            
            <div class="admin-header">
                <div>
                    <h1 class="admin-title">Lịch Vận Hành</h1>
                    <p class="text-muted mb-0 fw-medium">Theo dõi tiến độ bán chỗ và phân công lịch trình.</p>
                </div>
                <div>
                    <a href="../public/manager.php?action=createDeparture" class="btn btn-primary fw-bold shadow-sm rounded-pill px-4">
                        <i class="bi bi-calendar-plus me-1"></i> Thêm Lịch Mới
                    </a>
                </div>
            </div>

            <div class="departure-list">
                <?php if (!empty($departures)): ?>
                    <?php foreach ($departures as $d): ?>
                        
                        <?php 
                            // Tính toán phần trăm ghế đã đặt
                            $max = (int)$d['max_seats'];
                            $booked = (int)$d['booked_seats'];
                            $percent = ($max > 0) ? round(($booked / $max) * 100) : 0;
                            
                            // Đổi màu thanh tiến trình tùy theo tỷ lệ lấp đầy
                            $progressColor = 'bg-success'; // Xanh lá nếu còn nhiều chỗ
                            if ($percent >= 80 && $percent < 100) $progressColor = 'bg-warning'; // Vàng nếu sắp đầy
                            if ($percent >= 100) $progressColor = 'bg-danger'; // Đỏ nếu đã full
                        ?>

                        <div class="departure-card">
                            
                            <div class="date-block">
                                <span class="month">Tháng <?= date('m', strtotime($d['start_date'])) ?></span>
                                <span class="day"><?= date('d', strtotime($d['start_date'])) ?></span>
                                <span class="year"><?= date('Y', strtotime($d['start_date'])) ?></span>
                            </div>

                            <div class="info-block">
                                <div class="tour-name">
                                    <?= htmlspecialchars($d['tour_name']) ?>
                                    <span class="badge bg-light text-dark border fw-normal" style="font-size: 0.75rem;">
                                        <?= htmlspecialchars($d['status']) ?>
                                    </span>
                                </div>
                                <div class="meta-info">
                                    <span><i class="bi bi-arrow-right-circle text-danger"></i> Về: <?= date('d/m/Y', strtotime($d['end_date'])) ?></span>
                                    <span>
                                        <i class="bi bi-person-badge text-warning"></i> 
                                        <?= !empty($d['guides']) ? htmlspecialchars($d['guides']) : '<i>Chưa phân công</i>' ?>
                                    </span>
                                </div>
                            </div>

                            <div class="seats-block">
                                <div class="seats-label">
                                    <span>Đã đặt: <?= $booked ?>/<?= $max ?></span>
                                    <span class="<?= $percent >= 100 ? 'text-danger' : 'text-success' ?>">
                                        <?= $percent ?>%
                                    </span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar <?= $progressColor ?>" role="progressbar" style="width: <?= $percent ?>%;" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="text-end mt-1 text-muted" style="font-size: 0.75rem;">
                                    Còn trống: <?= $d['available_seats'] ?>
                                </div>
                            </div>

                            <div class="action-block">
                                <a href="../public/manager.php?action=editDeparture&id=<?= $d['departure_id'] ?>" class="btn btn-light border text-warning rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" title="Sửa">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <a href="../public/manager.php?action=deleteDeparture&id=<?= $d['departure_id'] ?>" class="btn btn-light border text-danger rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" title="Xóa" onclick="return confirm('Xóa lịch vận hành này?')">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-5 bg-white rounded-4 border">
                        <i class="bi bi-calendar-x fs-1 d-block mb-2 text-muted"></i>
                        <p class="text-muted fw-medium">Chưa có lịch vận hành nào được tạo.</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
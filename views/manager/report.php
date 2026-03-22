<?php include __DIR__ . '/../layouts/header.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
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

    /* --- SIDEBAR (Giữ nguyên đồng bộ) --- */
    .admin-sidebar {
        background: var(--admin-surface);
        border-radius: 20px;
        border: 1px solid var(--admin-border);
        padding: 24px 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        height: 100%;
        z-index: 10;
    }

    .admin-profile {
        text-align: center;
        padding-bottom: 20px;
        border-bottom: 1px dashed var(--admin-border);
        margin-bottom: 20px;
    }

    .admin-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--admin-primary), #00d2ff);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 800;
        margin: 0 auto 15px;
        box-shadow: 0 4px 10px rgba(1, 148, 243, 0.3);
    }

    .admin-menu {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .admin-menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 12px;
        color: var(--admin-text-muted);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .admin-menu-item i {
        font-size: 1.25rem;
        transition: 0.2s;
    }

    .admin-menu-item:hover {
        background-color: var(--admin-bg);
        color: var(--admin-text-main);
    }

    .admin-menu-item.active {
        background-color: var(--admin-primary-light);
        color: var(--admin-primary);
    }

    .admin-menu-item.active i {
        color: var(--admin-primary);
    }

    /* --- REPORT UI LÕI --- */
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 25px;
    }

    .admin-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--admin-text-main);
        margin-bottom: 5px;
    }

    /* Bộ lọc nâng cao */
    .filter-box {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid var(--admin-border);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        margin-bottom: 25px;
    }

    .filter-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--admin-text-muted);
        text-transform: uppercase;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-custom {
        border-radius: 10px;
        padding: 10px 15px;
        border: 1px solid #cbd5e1;
        font-weight: 500;
        background-color: #f8fafc;
    }

    .form-control-custom:focus {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(1, 148, 243, 0.1);
        background-color: white;
    }

    .btn-filter {
        background: var(--admin-primary);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 700;
        transition: 0.3s;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-filter:hover {
        background: #007bc2;
        transform: translateY(-2px);
    }

    /* Thẻ thống kê nhỏ */
    .summary-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid var(--admin-border);
        text-align: center;
        transition: 0.3s;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
    }

    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    .summary-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 15px;
    }

    .summary-label {
        color: var(--admin-text-muted);
        font-size: 0.95rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .summary-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--admin-text-main);
        margin: 0;
        line-height: 1;
    }

    /* Vùng chứa Chart */
    .chart-container {
        background: white;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid var(--admin-border);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        height: 100%;
    }

    .chart-title {
        font-weight: 800;
        font-size: 1.15rem;
        color: var(--admin-text-main);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chart-wrapper {
        position: relative;
        height: 300px;
        width: 100%;
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
                    <h1 class="admin-title">Báo cáo & Thống kê</h1>
                    <p class="text-muted mb-0 fw-medium">Phân tích hiệu quả kinh doanh của TravelVN.</p>
                </div>
            </div>

            <div class="filter-box">
                <form method="GET" action="">
                    <input type="hidden" name="action" value="report">

                    <div class="row g-3 align-items-end">
                        <div class="col-lg-3 col-md-6">
                            <label class="filter-label"><i class="bi bi-calendar-event text-primary"></i> Từ
                                ngày</label>
                            <input type="date" name="start_date" class="form-control form-control-custom"
                                value="<?= $_GET['start_date'] ?? '' ?>">
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="filter-label"><i class="bi bi-calendar-event text-danger"></i> Đến
                                ngày</label>
                            <input type="date" name="end_date" class="form-control form-control-custom"
                                value="<?= $_GET['end_date'] ?? '' ?>">
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="filter-label"><i class="bi bi-funnel text-success"></i> Trạng thái đơn</label>
                            <select name="status" class="form-select form-control-custom">
                                <option value="">Tất cả trạng thái</option>
                                <option value="confirmed" <?= (isset($_GET['status']) && $_GET['status'] == 'confirmed') ? 'selected' : '' ?>>Đã xác nhận (Thành công)</option>
                                <option value="pending" <?= (isset($_GET['status']) && $_GET['status'] == 'pending') ? 'selected' : '' ?>>Chờ xử lý</option>
                                <option value="cancelled" <?= (isset($_GET['status']) && $_GET['status'] == 'cancelled') ? 'selected' : '' ?>>Đã hủy</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <button type="submit" class="btn-filter w-100"><i class="bi bi-bar-chart-fill"></i> Xem báo
                                cáo</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="summary-card" style="border-top: 4px solid var(--admin-danger);">
                        <div class="summary-icon bg-danger bg-opacity-10 text-danger"><i class="bi bi-cash-coin"></i>
                        </div>
                        <div class="summary-label">Tổng Doanh Thu</div>
                        <div class="summary-value text-danger"><?= number_format($totalRevenue ?? 0) ?> <span
                                style="font-size: 1rem; color: #64748b;">đ</span></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card" style="border-top: 4px solid var(--admin-success);">
                        <div class="summary-icon bg-success bg-opacity-10 text-success"><i class="bi bi-bag-check"></i>
                        </div>
                        <div class="summary-label">Số Đơn Đặt</div>
                        <div class="summary-value"><?= $totalBookings ?? 0 ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card" style="border-top: 4px solid var(--admin-primary);">
                        <div class="summary-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-map"></i></div>
                        <div class="summary-label">Tour Đang Hoạt Động</div>
                        <div class="summary-value"><?= $totalTours ?? 0 ?></div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="chart-container">
                        <div class="chart-title"><i class="bi bi-graph-up text-primary"></i> Biểu đồ Doanh thu (Theo
                            tháng)</div>
                        <div class="chart-wrapper">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="chart-container">
                        <div class="chart-title"><i class="bi bi-pie-chart-fill text-warning"></i> Tỷ lệ trạng thái đơn
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="chart-container">
                        <div class="chart-title"><i class="bi bi-trophy-fill text-success"></i> Top Tour bán chạy nhất
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="topTourChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // ===== LẤY DATA TỪ PHP =====
    const revenueLabels = <?= json_encode(array_column($revenueByMonth ?? [], 'month')) ?>;
    const revenueData = <?= json_encode(array_column($revenueByMonth ?? [], 'revenue')) ?>;

    const statusLabels = <?= json_encode(array_column($statusStats ?? [], 'status')) ?>;
    const statusData = <?= json_encode(array_column($statusStats ?? [], 'total')) ?>;

    const tourLabels = <?= json_encode(array_column($topTours ?? [], 'tour_name')) ?>;
    const tourData = <?= json_encode(array_column($topTours ?? [], 'total')) ?>;

    // Config chung cho font chữ của Chart
    Chart.defaults.font.family = "'Inter', 'Segoe UI', sans-serif";
    Chart.defaults.color = '#64748b';

    // ===== LINE CHART (Doanh thu) =====
    // Tạo gradient màu xanh cho Line chart
    const ctxRev = document.getElementById('revenueChart').getContext('2d');
    const gradientRev = ctxRev.createLinearGradient(0, 0, 0, 300);
    gradientRev.addColorStop(0, 'rgba(1, 148, 243, 0.4)'); // Xanh dương nhạt
    gradientRev.addColorStop(1, 'rgba(1, 148, 243, 0.0)'); // Trong suốt

    new Chart(ctxRev, {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: revenueData,
                borderColor: '#0194f3',
                backgroundColor: gradientRev,
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#0194f3',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4 // Làm đường cong mềm mại
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { dash: [4, 4] } },
                x: { grid: { display: false } }
            }
        }
    });

    // ===== DOUGHNUT CHART (Trạng thái đơn) =====
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: [
                    '#10b981', // Xanh lá (Confirmed)
                    '#f59e0b', // Vàng (Pending)
                    '#ef4444', // Đỏ (Cancelled)
                    '#64748b'  // Xám (Khác)
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%', // Làm vòng tròn mỏng đi cho sang
            plugins: {
                legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } }
            }
        }
    });

    // ===== BAR CHART (Top Tour) =====
    new Chart(document.getElementById('topTourChart'), {
        type: 'bar',
        data: {
            labels: tourLabels,
            datasets: [{
                label: 'Số đơn đặt',
                data: tourData,
                backgroundColor: '#10b981', // Xanh lá pastel đậm
                borderRadius: 8, // Bo góc cột
                barPercentage: 0.5 // Độ rộng cột
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
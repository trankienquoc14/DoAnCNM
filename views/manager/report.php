<?php include __DIR__ . '/../layouts/header.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    :root {
        --admin-primary: #0194f3;
        --admin-success: #10b981;
        --admin-warning: #f59e0b;
        --admin-danger: #ef4444;
        --admin-bg: #f1f5f9;
        --admin-surface: #ffffff;
        --admin-border: #e2e8f0;
        --admin-text-main: #0f172a;
        --admin-text-muted: #64748b;
    }

    body {
        background: var(--admin-bg);
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    .admin-container {
        max-width: 1300px;
        margin: 40px auto;
        padding: 0 15px;
    }

    /* SIDEBAR */

    .admin-sidebar {
        background: white;
        border-radius: 18px;
        border: 1px solid var(--admin-border);
        padding: 24px 16px;
    }

    /* TITLE */

    .admin-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--admin-text-main);
    }

    /* FILTER */

    .filter-box {
        background: white;
        border-radius: 14px;
        padding: 20px;
        border: 1px solid var(--admin-border);
        margin-bottom: 25px;
    }

    .filter-label {
        font-size: .8rem;
        font-weight: 700;
        color: var(--admin-text-muted);
        text-transform: uppercase;
    }

    .form-control-custom {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        padding: 8px 12px;
    }

    .btn-filter {
        background: var(--admin-primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        padding: 9px 20px;
    }

    /* SUMMARY */

    .summary-card {
        background: white;
        border-radius: 14px;
        padding: 18px;
        border: 1px solid var(--admin-border);
        text-align: center;
    }

    .summary-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin: auto;
        margin-bottom: 10px;
    }

    .summary-label {
        font-size: .85rem;
        color: var(--admin-text-muted);
        font-weight: 700;
    }

    .summary-value {
        font-size: 1.5rem;
        font-weight: 800;
    }

    /* CHART */

    .chart-container {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid var(--admin-border);
    }

    .chart-title {
        font-weight: 800;
        font-size: 1rem;
        margin-bottom: 15px;
    }

    .chart-wrapper {
        position: relative;
        width: 100%;
        min-height: 300px;
    }
</style>

<div class="admin-container">
    <div class="row g-4">

        <?php
        $activeMenu = 'report';
        include __DIR__ . '/../layouts/sidebar_manager.php';
        ?>

        <div class="col-lg-9">

            <div class="admin-header mb-4">
                <h1 class="admin-title">Báo cáo & Thống kê</h1>
                <p class="text-muted mb-0">
                    Từ <strong><?= date('d/m/Y', strtotime($_GET['start_date'] ?? date('Y-m-01'))) ?></strong>
                    đến <strong><?= date('d/m/Y', strtotime($_GET['end_date'] ?? date('Y-m-d'))) ?></strong>
                </p>
            </div>

            <!-- FILTER -->

            <div class="filter-box">
                <form method="GET">

                    <input type="hidden" name="action" value="report">

                    <div class="row g-3">

                        <div class="col-md-3">
                            <label class="filter-label">Từ ngày</label>
                            <input type="date" name="start_date" class="form-control form-control-custom"
                                value="<?= $_GET['start_date'] ?? date('Y-m-01') ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="filter-label">Đến ngày</label>
                            <input type="date" name="end_date" class="form-control form-control-custom"
                                value="<?= $_GET['end_date'] ?? date('Y-m-d') ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="filter-label">Trạng thái</label>
                            <select name="status" class="form-select form-control-custom">

                                <option value="">Tất cả</option>

                                <option value="pending">Chờ xử lý</option>
                                <option value="confirmed">Đã xác nhận</option>
                                <option value="checked_in">Khách đã đến</option>
                                <option value="completed">Hoàn thành</option>
                                <option value="cancelled">Đã hủy</option>

                            </select>
                        </div>

                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <!-- Nút Lọc hiện tại -->
                            <button type="submit" class="btn-filter flex-grow-1">
                                <i class="bi bi-filter"></i> Lọc
                            </button>

                            <!-- Nút Xóa bộ lọc mới -->
                            <a href="manager.php?action=report"
                                class="btn btn-outline-secondary d-flex align-items-center justify-content-center"
                                style="border-radius: 8px; width: 45px; height: 38px;" title="Xóa bộ lọc">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>

                    </div>
                </form>
            </div>

            <!-- SUMMARY -->

            <div class="row g-3 mb-4">

                <div class="col-md-4">
                    <div class="summary-card">

                        <div class="summary-icon bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-cash"></i>
                        </div>

                        <div class="summary-label">Doanh thu</div>
                        <div class="summary-value text-danger">
                            <?= number_format($totalRevenue ?? 0) ?> VNĐ
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="summary-card">

                        <div class="summary-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-bag"></i>
                        </div>

                        <div class="summary-label">Tổng đơn</div>
                        <div class="summary-value">
                            <?= $totalBookings ?? 0 ?>
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="summary-card">

                        <div class="summary-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-map"></i>
                        </div>

                        <div class="summary-label">Tour đang bán</div>
                        <div class="summary-value">
                            <?= $totalTours ?? 0 ?>
                        </div>

                    </div>
                </div>

            </div>

            <!-- CHART -->

            <div class="row g-4 mb-4">

                <div class="col-lg-8">

                    <div class="chart-container">

                        <div class="chart-title">
                            Biểu đồ doanh thu
                        </div>

                        <div class="chart-wrapper" style="height:360px">
                            <canvas id="revenueChart"></canvas>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4">

                    <div class="chart-container">

                        <div class="chart-title">
                            Tỷ lệ trạng thái đơn
                        </div>

                        <div class="chart-wrapper" style="height:360px">
                            <canvas id="statusChart"></canvas>
                        </div>

                    </div>
                </div>

            </div>

            <div class="chart-container">

                <div class="chart-title">
                    Top tour bán chạy
                </div>

                <div class="chart-wrapper" id="topTourWrapper">
                    <canvas id="topTourChart"></canvas>
                </div>

            </div>

        </div>
    </div>
</div>

<script>

    const statusVN = {
        pending: 'Chờ xử lý',
        confirmed: 'Đã xác nhận',
        cancelled: 'Đã hủy',
        completed: 'Hoàn thành',
        checked_in: 'Khách đã đến'
    };

    const rawLabels = <?= json_encode(array_column($statusStats ?? [], 'status')) ?> || [];
    const rawData = <?= json_encode(array_column($statusStats ?? [], 'total')) ?> || [];

    const statLabels = [];
    const statData = [];

    rawLabels.forEach((s, i) => {
        if (s) {
            statLabels.push(statusVN[s] || s);
            statData.push(rawData[i]);
        }
    });

    const revLabels = <?= json_encode(array_column($revenueByMonth ?? [], 'month')) ?> || [];
    const revData = <?= json_encode(array_column($revenueByMonth ?? [], 'revenue')) ?> || [];

    const tourLabels = <?= json_encode(array_column($topTours ?? [], 'tour_name')) ?> || [];
    const tourData = <?= json_encode(array_column($topTours ?? [], 'total')) ?> || [];

    Chart.defaults.font.family = "'Inter',sans-serif";

    /* revenue chart */

    new Chart(
        document.getElementById('revenueChart'),
        {
            type: 'line',

            data: {
                labels: revLabels.length ? revLabels : ['Chưa có dữ liệu'],

                datasets: [{

                    data: revData.length ? revData : [0],

                    borderColor: '#0194f3',
                    backgroundColor: 'rgba(1,148,243,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4

                }]
            },

            options: {
                maintainAspectRatio: false,

                plugins: {
                    legend: { display: false }
                },

                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }

        });

    /* status chart */

    new Chart(
        document.getElementById('statusChart'),
        {
            type: 'doughnut',

            data: {
                labels: statLabels.length ? statLabels : ['Trống'],

                datasets: [{
                    data: statData.length ? statData : [1],
                    backgroundColor: [
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                        '#3b82f6',
                        '#8b5cf6'
                    ]
                }]
            },

            options: {
                maintainAspectRatio: false,
                cutout: '70%'
            }

        });

    /* top tour chart */

    const dynamicHeight = Math.max(tourLabels.length * 70, 220);
    document.getElementById('topTourWrapper').style.height = dynamicHeight + 'px';

    new Chart(
        document.getElementById('topTourChart'),
        {
            type: 'bar',

            data: {
                labels: tourLabels.length ? tourLabels : ['Chưa có dữ liệu'],

                datasets: [{

                    data: tourData.length ? tourData : [0],

                    backgroundColor: '#10b981',

                    borderRadius: 6,

                    barThickness: 18,

                    maxBarThickness: 22,

                    categoryPercentage: 0.6,

                    barPercentage: 0.7

                }]
            },

            options: {

                indexAxis: 'y',

                maintainAspectRatio: false,

                plugins: {
                    legend: { display: false }
                },

                scales: {

                    x: {
                        beginAtZero: true
                    },

                    y: {
                        grid: { display: false },

                        ticks: {
                            callback: function (v) {
                                let label = this.getLabelForValue(v);
                                return label.length > 30 ? label.substr(0, 30) + '...' : label;
                            }
                        }

                    }

                }

            }

        });

</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
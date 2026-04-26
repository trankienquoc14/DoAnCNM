<?php
// --- 1. LOGIC TÍNH TOÁN TIẾN ĐỘ THỰC TẾ (CHẠY THẬT) ---
$totalPax = 0;
$checkedInPax = 0;

if (!empty($bookings)) {
    foreach ($bookings as $b) {
        $totalPax += (int) $b['number_of_people'];
        if (isset($b['status']) && trim($b['status']) === 'checked_in') {
            $checkedInPax += (int) $b['number_of_people'];
        }
    }
}

// Tính phần trăm làm tròn
$progress = ($totalPax > 0) ? round(($checkedInPax / $totalPax) * 100) : 0;
$imgUrl = !empty($departure['image']) ? '../public/uploads/' . $departure['image'] : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800';
?>

<?php include __DIR__ . '/../layouts/header.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

<style>
    :root {
        --app-primary: #0ea5e9;
        --app-primary-bg: #e0f2fe;
        --app-success: #10b981;
        --app-success-bg: #d1fae5;
        --app-warning: #f59e0b;
        --app-warning-bg: #fef3c7;
        --app-danger: #ef4444;
        --app-danger-bg: #fee2e2;
        --app-bg: #f8fafc;
        --app-card: #ffffff;
        --app-text: #0f172a;
        --app-muted: #64748b;
        --app-border: #e2e8f0;
        --font-main: 'Plus Jakarta Sans', sans-serif;
    }

    body {
        background-color: var(--app-bg);
        font-family: var(--font-main);
        color: var(--app-text);
    }

    /* --- THANH TIẾN TRÌNH CHẠY THẬT --- */
    .progress-container-custom {
        width: 100%;
        height: 10px;
        background: #e2e8f0;
        border-radius: 10px;
        margin-top: 12px;
        overflow: hidden;
    }

    .progress-bar-fill-custom {
        height: 100%;
        background: var(--app-success);
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.3);
    }

    /* --- TIMELINE MỚI --- */
    .timeline {
        border-left: 2px solid #e2e8f0;
        padding-left: 25px;
        margin-left: 10px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-item::before {
        content: "";
        position: absolute;
        left: -31px;
        top: 2px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: white;
        border: 3px solid var(--app-primary);
    }

    .timeline-item strong {
        display: block;
        color: var(--app-text);
        font-weight: 700;
        margin-bottom: 5px;
        font-size: 1.05rem;
    }

    .timeline-item span {
        color: var(--app-muted);
        line-height: 1.6;
    }

    .timeline-item.past-day::before {
        background: var(--app-success);
        border-color: var(--app-success-bg);
    }

    .timeline-item.past-day strong,
    .timeline-item.past-day span {
        color: #94a3b8;
        text-decoration: line-through;
    }

    .timeline-item.active-day::before {
        background: var(--app-warning);
        border-color: #fef3c7;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.2);
    }

    .timeline-item.active-day strong {
        color: var(--app-warning);
        font-size: 1.15rem;
    }

    .timeline-item.active-day span {
        color: var(--app-text);
        font-weight: 600;
    }

    /* --- GIỮ NGUYÊN STYLE BAN ĐẦU --- */
    .hero-banner {
        height: 280px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.2));
        padding: 0 5%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .hero-title {
        color: white;
        font-weight: 800;
        font-size: 2.2rem;
        margin-top: 20px;
    }

    .hero-meta {
        color: #cbd5e1;
        font-weight: 500;
        font-size: 1.05rem;
        display: flex;
        gap: 20px;
    }

    .hero-meta i {
        color: var(--app-primary);
        margin-right: 5px;
    }

    .top-stats-container {
        margin-top: -50px;
        position: relative;
        z-index: 10;
        padding: 0 5%;
    }

    .stat-card {
        background: var(--app-card);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.8);
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 5px;
        height: 100%;
    }

    .stat-header-flex {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: 800;
    }

    .stat-info h6 {
        color: var(--app-muted);
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .stat-info h4 {
        color: var(--app-text);
        font-size: 1.2rem;
        font-weight: 800;
        margin: 0;
    }

    .status-select {
        border: 2px solid var(--app-border);
        border-radius: 10px;
        font-weight: 700;
        color: var(--app-primary);
        padding: 8px 12px;
    }

    .btn-update {
        background: var(--app-text);
        color: white;
        font-weight: 700;
        border-radius: 10px;
        padding: 8px 15px;
        border: none;
        transition: 0.2s;
    }

    .btn-update:hover {
        background: var(--app-primary);
    }

    .main-container {
        padding: 30px 5%;
    }

    .ui-box {
        background: var(--app-card);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--app-border);
        margin-bottom: 25px;
        height: fit-content;
    }

    .box-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        border-bottom: 1px dashed var(--app-border);
        padding-bottom: 15px;
    }

    .box-header i {
        font-size: 1.4rem;
        color: var(--app-primary);
    }

    .box-header h5 {
        font-weight: 800;
        margin: 0;
        color: var(--app-text);
        font-size: 1.2rem;
    }

    .service-tag {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 15px;
    }

    .service-tag i {
        font-size: 1.2rem;
        margin-top: 2px;
    }

    .service-tag p {
        margin: 0;
        font-size: 0.95rem;
        color: var(--app-muted);
        line-height: 1.5;
        white-space: pre-wrap;
    }

    .pax-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 15px;
    }

    .pax-card {
        background: var(--app-bg);
        border: 1px solid var(--app-border);
        border-radius: 16px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: 0.2s;
    }

    .pax-card:hover {
        border-color: #cbd5e1;
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04);
        transform: translateY(-3px);
    }

    .pax-card.is-checked {
        border-left: 5px solid var(--app-success);
        background: #f0fdf4;
    }

    .pax-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .pax-info h6 {
        font-weight: 800;
        font-size: 1.1rem;
        margin-bottom: 5px;
        color: var(--app-text);
    }

    .pax-info p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--app-muted);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .pax-qty {
        background: var(--app-warning-bg);
        color: var(--app-warning);
        padding: 5px 10px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .btn-checkin {
        background: var(--app-success);
        color: white;
        border: none;
        padding: 10px;
        border-radius: 10px;
        font-weight: 700;
        width: 100%;
        transition: 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-checkin:hover {
        background: #047857;
    }

    .status-checked {
        background: var(--app-success-bg);
        color: var(--app-success);
        padding: 10px;
        border-radius: 10px;
        font-weight: 700;
        text-align: center;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
</style>

<div class="hero-banner" style="background-image: url('<?= $imgUrl ?>');">
    <div class="hero-overlay">
        <h1 class="hero-title"><?= htmlspecialchars($departure['tour_name'] ?? 'Chưa cập nhật tên tour') ?></h1>
        <div class="hero-meta">
            <span><i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($departure['destination'] ?? '--') ?></span>
            <span><i class="bi bi-calendar-event"></i>
                <?= !empty($departure['start_date']) ? date('d/m/Y', strtotime($departure['start_date'])) : '--' ?> -
                <?= !empty($departure['end_date']) ? date('d/m/Y', strtotime($departure['end_date'])) : '--' ?></span>
        </div>
    </div>
</div>

<?php if (isset($departure['status']) && $departure['status'] === 'completed'): ?>
    <div class="container mt-3">
        <div class="p-3 text-center rounded-4 shadow-sm"
            style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
            <h5 class="mb-1 fw-bold"><i class="bi bi-trophy-fill me-2"></i> TOUR NÀY ĐÃ HOÀN THÀNH XUẤT SẮC</h5>
            <p class="mb-0 opacity-75 small">Chức năng đánh giá đã được mở cho tất cả hành khách.</p>
        </div>
    </div>
<?php endif; ?>

<div class="top-stats-container">
    <div class="row g-3">
        <div class="col-lg-4 col-md-6">
            <div class="stat-card">
                <div class="stat-header-flex">
                    <div class="stat-icon" style="background: var(--app-primary-bg); color: var(--app-primary);">
                        <?= $progress ?>%</div>
                    <div class="stat-info">
                        <h6>Tiến độ điểm danh</h6>
                        <h4><?= $checkedInPax ?> / <?= $totalPax ?> khách</h4>
                    </div>
                </div>
                <div class="progress-container-custom">
                    <div class="progress-bar-fill-custom" style="width: <?= $progress ?>%;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="stat-card">
                <div class="stat-header-flex">
                    <div class="stat-icon" style="background: var(--app-warning-bg); color: var(--app-warning);"><i
                            class="bi bi-building"></i></div>
                    <div class="stat-info">
                        <h6>Khách sạn lưu trú</h6>
                        <h4><?= htmlspecialchars($departure['hotel'] ?? 'Đang cập nhật') ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <div class="stat-card">
                <form method="POST" action="guide.php?action=updateStatus" class="w-100">
                    <input type="hidden" name="departure_id" value="<?= $departure['departure_id'] ?>">
                    <h6 class="text-muted fw-bold mb-2" style="font-size: 0.9rem; text-transform: uppercase;">Trạng thái
                        Tour</h6>
                    <div class="d-flex gap-2">
                        <select name="status" class="form-select status-select flex-grow-1">
                            <option value="upcoming" <?= ($departure['status'] == 'upcoming') ? 'selected' : '' ?>>Chờ khởi
                                hành</option>
                            <option value="ongoing" <?= ($departure['status'] == 'ongoing') ? 'selected' : '' ?>>Đang diễn
                                ra</option>
                            <option value="completed" <?= ($departure['status'] == 'completed') ? 'selected' : '' ?>>Đã
                                hoàn thành</option>
                        </select>
                        <button type="submit" class="btn-update">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="main-container">
    <div class="row g-4">
        <div class="col-xl-4 col-lg-5">
            <div class="ui-box">
                <div class="box-header"><i class="bi bi-map-fill text-warning"></i>
                    <h5>Lịch trình Tour</h5>
                </div>
                <div class="timeline">
                    <?php
                    $itineraryText = $departure['itinerary'] ?? '';
                    if (empty($itineraryText)) {
                        echo "<p class='text-muted'>Chưa có thông tin lịch trình.</p>";
                    } else {
                        $days = explode('|', $itineraryText);

                        // LOGIC TÍNH NGÀY HIỆN TẠI (TÍNH TOÁN BẰNG PHP)
                        $today = new DateTime('today');
                        $start = new DateTime($departure['start_date'] ?? 'today');
                        $interval = $start->diff($today);
                        $currentDayIndex = ($today >= $start) ? $interval->days : -1;
                        if ($departure['status'] == 'completed')
                            $currentDayIndex = 999;

                        foreach ($days as $index => $day):
                            $day = trim($day);
                            if (empty($day))
                                continue;

                            $timelineClass = '';
                            if ($index < $currentDayIndex)
                                $timelineClass = 'past-day';
                            if ($index == $currentDayIndex)
                                $timelineClass = 'active-day';

                            $parts = explode(':', $day, 2);
                            ?>
                            <div class="timeline-item <?= $timelineClass ?>">
                                <?php if (count($parts) == 2): ?>
                                    <strong><?= htmlspecialchars(trim($parts[0])) ?>
                                        <?= ($index == $currentDayIndex) ? '<span class="badge bg-warning text-dark ms-2" style="font-size:0.7rem;">Hôm nay</span>' : '' ?></strong>
                                    <span><?= htmlspecialchars(trim($parts[1])) ?></span>
                                <?php else: ?>
                                    <span><?= htmlspecialchars($day) ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach;
                    } ?>
                </div>
            </div>

            <div class="ui-box">
                <div class="box-header"><i class="bi bi-bag-check-fill text-primary"></i>
                    <h5>Thông tin Dịch vụ</h5>
                </div>
                <div class="service-tag">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <div><strong class="text-success d-block mb-1">Bao gồm</strong>
                        <p><?= htmlspecialchars($departure['include_service'] ?? 'Chưa cập nhật') ?></p>
                    </div>
                </div>
                <div class="service-tag mt-4">
                    <i class="bi bi-x-circle-fill text-danger"></i>
                    <div><strong class="text-danger d-block mb-1">Không bao gồm</strong>
                        <p><?= htmlspecialchars($departure['exclude_service'] ?? 'Chưa cập nhật') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="ui-box">
                <div class="box-header"><i class="bi bi-people-fill text-success"></i>
                    <h5>Danh sách Điểm danh (<?= count($bookings) ?> khách)</h5>
                </div>

                <div class="mb-4">
                    <button id="btn-scan-qr" class="btn w-100 fw-bold"
                        style="background: #0f172a; color: white; border-radius: 12px; padding: 12px;">
                        <i class="bi bi-qr-code-scan me-2"></i> Mở Camera Quét QR Khách Hàng
                    </button>
                    <div id="qr-reader" class="mt-3 rounded-4 overflow-hidden"
                        style="display: none; border: 2px solid var(--app-primary);"></div>
                    <div id="qr-result" class="text-center mt-2 text-success fw-bold"></div>
                </div>

                <?php if (empty($bookings)): ?>
                    <div class="text-center p-5 border rounded-4 bg-light border-dashed">
                        <i class="bi bi-person-x text-muted fs-1 mb-2 d-block"></i>
                        <span class="text-muted fw-medium">Chưa có hành khách nào đặt tour này.</span>
                    </div>
                <?php else: ?>
                    <div class="pax-grid">
                        <?php foreach ($bookings as $b): ?>
                            <div class="pax-card <?= ($b['status'] == 'checked_in') ? 'is-checked' : '' ?>">
                                <div class="pax-header">
                                    <div class="pax-info">
                                        <h6><?= htmlspecialchars($b['customer_name']) ?></h6>
                                        <p><i class="bi bi-telephone text-primary"></i> <?= htmlspecialchars($b['phone']) ?></p>
                                    </div>
                                    <div class="pax-qty"><?= $b['number_of_people'] ?> pax</div>
                                </div>
                                <div class="pax-action mt-3">
                                    <?php if ($b['status'] != 'checked_in'): ?>
                                        <form method="POST" action="guide.php?action=checkin" class="m-0">
                                            <input type="hidden" name="booking_id" value="<?= $b['booking_id'] ?>">
                                            <button type="submit" class="btn-checkin"><i class="bi bi-check-circle"></i> Xác nhận
                                                thủ công</button>
                                        </form>
                                    <?php else: ?>
                                        <div class="status-checked shadow-sm"><i class="bi bi-check-circle-fill"></i> Đã có mặt
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['show_complete_alert'])): ?>
    <script>
        Swal.fire({
            title: 'Chốt Tour Thành Công!',
            text: 'Toàn bộ dữ liệu đoàn đã được lưu trữ. Khách hàng đã có thể gửi đánh giá!',
            icon: 'success',
            confirmButtonText: 'Tuyệt vời',
            confirmButtonColor: '#10b981',
            backdrop: `rgba(16, 185, 129, 0.15)`
        });
    </script>
    <?php unset($_SESSION['show_complete_alert']); ?>
<?php endif; ?>

<script>
    let html5QrcodeScanner;

    document.getElementById('btn-scan-qr').addEventListener('click', function () {
        const readerDiv = document.getElementById('qr-reader');

        if (readerDiv.style.display === 'block') {
            readerDiv.style.display = 'none';
            if (html5QrcodeScanner) html5QrcodeScanner.clear();
            this.innerHTML = '<i class="bi bi-qr-code-scan me-2"></i> Mở Camera Quét QR Khách Hàng';
            return;
        }

        readerDiv.style.display = 'block';
        this.innerHTML = '<i class="bi bi-x-circle me-2"></i> Đóng Camera';

        html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: { width: 250, height: 250 } }, false);

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    });

    function onScanSuccess(decodedText, decodedResult) {
        document.getElementById('qr-result').innerText = "Đã quét thành công Booking ID: " + decodedText;
        html5QrcodeScanner.clear();
        document.getElementById('qr-reader').style.display = 'none';

        let input = document.querySelector(`input[name="booking_id"][value="${decodedText}"]`);
        if (input) {
            Swal.fire('Thành công', 'Đang check-in cho khách...', 'success');
            input.closest('form').submit();
        } else {
            Swal.fire('Lỗi', 'Mã QR không hợp lệ hoặc khách không thuộc đoàn này!', 'error');
        }
    }

    function onScanFailure(error) {
        // Bỏ qua lỗi
    }
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
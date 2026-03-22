<?php 
// Kiểm tra nếu không có dữ liệu tour
if (empty($detail)) {
    echo "<div class='container mt-5 text-center'>
            <h2 class='fw-bold mt-5 text-muted'>Tour không tồn tại hoặc đã ngừng hoạt động</h2>
            <a href='index.php?action=tours' class='btn btn-primary mt-3'>Quay lại danh sách</a>
          </div>";
    exit;
}
include 'layouts/header.php'; 
?>

<style>
    :root {
        --primary-color: #0194f3;
        --accent-color: #ff5e1f;
        --text-main: #2c3e50;
    }

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    /* --- HERO SECTION --- */
    .hero-detail {
        position: relative;
        height: 480px;
        display: flex;
        align-items: flex-end;
        padding-bottom: 40px;
        background-size: cover;
        background-position: center;
    }

    .hero-detail::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.85) 100%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
    }

    .hero-title {
        font-size: 2.8rem;
        font-weight: 800;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        margin-top: 15px;
    }

    .location-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: white;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }

    /* --- INFO BOXES --- */
    .info-box {
        background: white;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        gap: 15px;
        height: 100%;
        border: 1px solid #f0f0f0;
    }

    .info-icon {
        width: 50px;
        height: 50px;
        background: #eef7ff;
        color: var(--primary-color);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .info-text h5 {
        margin: 0;
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }

    .info-text p {
        margin: 0;
        font-weight: 700;
        color: var(--text-main);
        font-size: 1.1rem;
    }

    /* --- SERVICES --- */
    .service-list {
        list-style: none;
        padding-left: 0;
    }

    .service-list li {
        margin-bottom: 10px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .service-list .bi-check-circle-fill {
        color: #28a745;
        font-size: 1.1rem;
        margin-top: 2px;
    }

    .service-list .bi-x-circle-fill {
        color: #dc3545;
        font-size: 1.1rem;
        margin-top: 2px;
    }

    /* --- ITINERARY ACCORDION --- */
    .accordion-button:not(.collapsed) {
        background-color: #eef7ff;
        color: var(--primary-color);
        font-weight: 700;
    }

    .accordion-button {
        font-weight: 600;
        color: var(--text-main);
    }

    .accordion-item {
        border-radius: 12px !important;
        border: 1px solid #eee;
        margin-bottom: 15px;
        overflow: hidden;
    }

    /* --- BOOKING CARD --- */
    .booking-card {
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
        position: sticky;
        top: 100px;
    }

    .price-amount {
        font-size: 2rem;
        font-weight: 800;
        color: var(--accent-color);
        margin-bottom: 15px;
    }

    .price-amount span {
        font-size: 1.1rem;
        color: #6c757d;
        font-weight: 600;
    }

    .btn-book-now {
        background-color: var(--primary-color);
        color: white;
        font-weight: 700;
        border-radius: 12px;
        padding: 14px;
        transition: 0.3s;
        border: none;
        font-size: 1.1rem;
    }

    .btn-book-now:hover {
        background-color: #007bc2;
        transform: translateY(-2px);
        color: white;
    }

    .btn-login-require {
        background-color: #ffc107;
        color: #000;
        font-weight: 700;
        border-radius: 12px;
        padding: 14px;
        text-decoration: none;
        display: block;
        text-align: center;
        transition: 0.3s;
    }

    .btn-login-require:hover {
        background-color: #e0a800;
        color: #000;
    }

    select option:disabled {
        color: #999;
    }
</style>

<div class="hero-detail"
    style="background-image: url('<?= !empty($detail['image']) ? '../public/uploads/' . $detail['image'] : 'https://images.unsplash.com/photo-1501785888041-af3ef285b470' ?>');">
    <div class="container hero-content">
        <div class="location-badge">
            <i class="bi bi-geo-alt-fill me-2"></i><?= htmlspecialchars($detail['destination']); ?>
        </div>
        <h1 class="hero-title"><?= htmlspecialchars($detail['tour_name']); ?></h1>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="row g-4">

        <div class="col-lg-8">

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="info-box">
                        <div class="info-icon"><i class="bi bi-clock-history"></i></div>
                        <div class="info-text">
                            <h5>Thời gian</h5>
                            <p><?= htmlspecialchars($detail['duration'] ?? '--'); ?> Ngày</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <div class="info-icon"><i class="bi bi-building"></i></div>
                        <div class="info-text">
                            <h5>Khách sạn</h5>
                            <p><?= htmlspecialchars($detail['hotel'] ?? 'Đang cập nhật'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <div class="info-icon"><i class="bi bi-briefcase"></i></div>
                        <div class="info-text">
                            <h5>Tổ chức bởi</h5>
                            <p><?= htmlspecialchars($detail['partner_name'] ?? 'TravelVN'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="fw-bold mt-5 mb-3">Tổng quan Tour</h4>
            <p class="text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                <?= nl2br(htmlspecialchars($detail['description'])); ?>
            </p>

            <div class="row mt-4 mb-4">
                <div class="col-md-6">
                    <div class="p-4 bg-white rounded-4 border">
                        <h5 class="fw-bold mb-3"><i class="bi bi-check-circle text-success me-2"></i>Dịch vụ bao gồm
                        </h5>
                        <ul class="service-list text-muted">
                            <?php
                            $includes = explode(',', $detail['include_service'] ?? 'Đang cập nhật');
                            foreach ($includes as $item):
                                ?>
                                <li><i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars(trim($item)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <div class="p-4 bg-white rounded-4 border">
                        <h5 class="fw-bold mb-3"><i class="bi bi-x-circle text-danger me-2"></i>Không bao gồm</h5>
                        <ul class="service-list text-muted">
                            <?php
                            $excludes = explode(',', $detail['exclude_service'] ?? 'Đang cập nhật');
                            foreach ($excludes as $item):
                                ?>
                                <li><i class="bi bi-x-circle-fill"></i> <?= htmlspecialchars(trim($item)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <h4 class="fw-bold mt-5 mb-4">Lịch trình chi tiết</h4>

            <?php if (!empty($schedules) && count($schedules) > 0): ?>
                <div class="accordion" id="itineraryAccordion">
                    <?php foreach ($schedules as $index => $sched): ?>
                        <div class="accordion-item shadow-sm border-0 mb-3 rounded-3 overflow-hidden">
                            <h2 class="accordion-header" id="heading<?= $sched['day_number'] ?>">
                                <button class="accordion-button <?= $index !== 0 ? 'collapsed' : '' ?>" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse<?= $sched['day_number'] ?>"
                                    aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>"
                                    aria-controls="collapse<?= $sched['day_number'] ?>">
                                    <span class="badge bg-primary me-2">Ngày <?= $sched['day_number'] ?></span>
                                    <?= htmlspecialchars($sched['location'] ?? 'Hoạt động') ?>
                                </button>
                            </h2>
                            <div id="collapse<?= $sched['day_number'] ?>"
                                class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>"
                                aria-labelledby="heading<?= $sched['day_number'] ?>" data-bs-parent="#itineraryAccordion">
                                <div class="accordion-body text-muted bg-white" style="line-height: 1.7;">
                                    <?= nl2br(htmlspecialchars($sched['activity'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-4 bg-white rounded-4 border text-muted" style="line-height: 1.8;">
                    <?= nl2br(htmlspecialchars($detail['itinerary'] ?? 'Lịch trình chi tiết đang được cập nhật.')); ?>
                </div>
            <?php endif; ?>

        </div>

        <div class="col-lg-4">
            <div class="booking-card" id="bookingSection">
                <span class="d-block text-muted fw-bold mb-1">Giá trọn gói</span>
                <div class="price-amount">
                    <?= number_format($detail['price']); ?> <span>VNĐ/khách</span>
                </div>

                <form action="index.php" method="GET">
                    <input type="hidden" name="action" value="booking">
                    <input type="hidden" name="tour_id" value="<?= $detail['tour_id']; ?>">

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark"><i class="bi bi-calendar-event me-2"></i>Chọn ngày
                            khởi hành</label>
                        <?php if (!empty($departures) && count($departures) > 0): ?>
                            <select name="departure_id" class="form-select form-select-lg" required>
                                <option value="" disabled selected>-- Chọn ngày đi --</option>

                                <?php foreach ($departures as $dep): ?>
                                    <option value="<?= $dep['departure_id'] ?>" <?= $dep['available_seats'] <= 0 ? 'disabled' : '' ?>>
                                        <?= date("d/m/Y", strtotime($dep['start_date'])) ?>
                                        (<?= $dep['available_seats'] > 0 ? 'Còn ' . $dep['available_seats'] . ' chỗ' : 'Hết chỗ' ?>)
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        <?php else: ?>
                            <div class="alert alert-warning py-2 mb-0">Hiện chưa có lịch khởi hành mới.</div>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($_SESSION['user'])): ?>
                        <button type="submit" class="btn btn-book-now w-100 mb-3" <?= empty($departures) ? 'disabled' : '' ?>>
                            Đặt tour ngay
                        </button>
                    <?php else: ?>
                        <a href="index.php?action=login" class="btn btn-login-require w-100 mb-3 fw-bold">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Đăng nhập để đặt tour
                        </a>
                        <p class="text-center small text-muted">Vui lòng đăng nhập để tiếp tục đặt tour.</p>
                    <?php endif; ?>
                </form>

                <div class="text-center mt-3 border-top pt-3">
                    <small class="text-muted"><i class="bi bi-shield-check text-success me-1"></i>Thanh toán an toàn bảo
                        mật</small>
                </div>
            </div>
        </div>

    </div>
    <script>
        window.onload = function () {
           const bookMode = "<?= $_GET['book'] ?? '0' ?>";

            if (bookMode === "1") {
                const section = document.getElementById("bookingSection");

                if (section) {
                    section.scrollIntoView({ behavior: "smooth", block: "center" });
                    section.style.boxShadow = "0 0 0 4px rgba(1,148,243,0.2)";
                    setTimeout(() => {
                        section.style.boxShadow = "";
                    }, 2000);
                }
            }
        };
    </script>
</div>

<?php include 'layouts/footer.php'; ?>
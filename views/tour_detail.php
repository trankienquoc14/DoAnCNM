<?php 
// Kiểm tra nếu không có dữ liệu tour
if (empty($detail)) {
    echo "<div class='container mt-5 text-center'>
            <img src='https://cdn-icons-png.flaticon.com/512/7486/7486744.png' alt='No Result' width='120' class='mb-3 opacity-50 mt-5'>
            <h3 class='fw-bold text-dark'>Tour không tồn tại hoặc đã ngừng hoạt động</h3>
            <p class='text-muted'>Hành trình bạn tìm kiếm hiện không có sẵn trên hệ thống.</p>
            <a href='index.php?action=tours' class='btn btn-primary mt-3 rounded-pill px-4'>Quay lại danh sách</a>
          </div>";
    exit;
}
include 'layouts/header.php'; 
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    :root {
        --tvlk-blue: #0194f3;
        --tvlk-dark-blue: #0770cd;
        --tvlk-orange: #ff5e1f;
        --tvlk-orange-hover: #e04d14;
        --tvlk-bg: #f7f9fa;
        --tvlk-text: #03121a;
        --tvlk-gray: #687176;
        --tvlk-border: #e1e8ee;
        --radius-md: 12px;
        --radius-lg: 20px;
    }

    body {
        background-color: var(--tvlk-bg);
        font-family: 'Inter', sans-serif;
        color: var(--tvlk-text);
    }

    /* --- BREADCRUMB --- */
    .tour-breadcrumb { padding: 15px 0; font-size: 0.9rem; font-weight: 500; color: var(--tvlk-gray); }
    .tour-breadcrumb a { color: var(--tvlk-blue); text-decoration: none; }
    .tour-breadcrumb i { margin: 0 8px; font-size: 0.8rem; }

    /* --- HERO SECTION --- */
    .hero-detail {
        position: relative; height: 450px; display: flex; align-items: flex-end; padding-bottom: 40px;
        background-size: cover; background-position: center; border-radius: var(--radius-lg); overflow: hidden;
        margin-bottom: 30px;
    }
    .hero-detail::before {
        content: ""; position: absolute; inset: 0;
        background: linear-gradient(to bottom, rgba(3,18,26, 0.1) 0%, rgba(3,18,26, 0.9) 100%);
    }
    .hero-content { position: relative; z-index: 2; color: white; }
    .hero-title { font-size: 2.5rem; font-weight: 800; text-shadow: 0 4px 12px rgba(0, 0, 0, 0.4); margin-top: 15px; line-height: 1.3;}
    .location-badge {
        background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.3);
        color: white; padding: 6px 16px; border-radius: 50px; font-weight: 700; font-size: 0.9rem; display: inline-flex; align-items: center;
    }

    /* --- CONTENT CARDS --- */
    .content-section {
        background: white; border-radius: var(--radius-md); padding: 30px;
        box-shadow: 0 2px 8px rgba(3, 18, 26, 0.04); border: 1px solid var(--tvlk-border); margin-bottom: 24px;
    }
    .section-title { font-size: 1.3rem; font-weight: 800; color: var(--tvlk-text); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .section-title i { color: var(--tvlk-blue); font-size: 1.5rem; }

    /* --- QUICK INFO BOXES --- */
    .info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 24px; }
    .info-box {
        background: var(--tvlk-bg); padding: 15px; border-radius: var(--radius-md);
        display: flex; align-items: center; gap: 15px; border: 1px solid var(--tvlk-border);
    }
    .info-icon {
        width: 45px; height: 45px; background: white; color: var(--tvlk-blue);
        border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .info-text h5 { margin: 0 0 4px 0; font-size: 0.85rem; color: var(--tvlk-gray); font-weight: 600; text-transform: uppercase; }
    .info-text p { margin: 0; font-weight: 700; color: var(--tvlk-text); font-size: 1rem; }

    /* --- HIGHLIGHTS (ĐIỂM NHẤN) --- */
    .highlight-list { list-style: none; padding: 0; margin: 0; }
    .highlight-list li {
        position: relative; padding-left: 30px; margin-bottom: 12px; font-size: 1rem; color: var(--tvlk-text); line-height: 1.6;
    }
    .highlight-list li::before {
        content: "\F26A"; font-family: "bootstrap-icons"; position: absolute; left: 0; top: 2px;
        color: var(--tvlk-orange); font-size: 1.2rem;
    }

    /* --- GALLERY PHỤ --- */
    .tour-gallery { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 20px; }
    .tour-gallery img { width: 100%; height: 120px; object-fit: cover; border-radius: 8px; transition: 0.3s; cursor: pointer; }
    .tour-gallery img:hover { filter: brightness(0.8); }

    /* --- TEXT CONTENT --- */
    .text-content { font-size: 1rem; color: #4a5568; line-height: 1.8; }

    /* --- SERVICES --- */
    .service-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .service-list { list-style: none; padding-left: 0; margin: 0;}
    .service-list li { margin-bottom: 12px; display: flex; align-items: flex-start; gap: 10px; font-size: 0.95rem; color: var(--tvlk-text); }
    .service-list .bi-check-circle-fill { color: #10b981; font-size: 1.2rem; margin-top: 1px; }
    .service-list .bi-x-circle-fill { color: #ef4444; font-size: 1.2rem; margin-top: 1px; }

    /* --- ITINERARY ACCORDION --- */
    .accordion-button:not(.collapsed) { background-color: #f0f9ff; color: var(--tvlk-blue); font-weight: 700; box-shadow: none; }
    .accordion-button { font-weight: 600; color: var(--tvlk-text); padding: 15px 20px; box-shadow: none;}
    .accordion-button:focus { box-shadow: none; border-color: rgba(0,0,0,.125); }
    .accordion-item { border-radius: 12px !important; border: 1px solid var(--tvlk-border); margin-bottom: 15px; overflow: hidden; }
    .day-badge { background: var(--tvlk-blue); color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; margin-right: 12px; }

    /* --- POLICY ALERT --- */
    .policy-box { background: #fffbeb; border: 1px solid #fed7aa; border-radius: var(--radius-md); padding: 20px; }
    .policy-box ul { padding-left: 15px; margin: 0; color: #9a3412; font-size: 0.95rem; line-height: 1.7; }

    /* --- BOOKING CARD --- */
    .booking-card {
        background: white; padding: 25px; border-radius: var(--radius-lg);
        box-shadow: 0 10px 30px rgba(3, 18, 26, 0.08); border: 1px solid var(--tvlk-border);
        position: sticky; top: 20px;
    }
    .price-amount { font-size: 1.8rem; font-weight: 800; color: var(--tvlk-orange); margin-bottom: 15px; }
    .price-amount span { font-size: 1rem; color: var(--tvlk-gray); font-weight: 600; }
    
    .btn-book-now {
        background-color: var(--tvlk-orange); color: white; font-weight: 700;
        border-radius: var(--radius-sm); padding: 14px; transition: 0.3s; border: none; font-size: 1.1rem;
    }
    .btn-book-now:hover { background-color: var(--tvlk-orange-hover); color: white; }
    
    .btn-login-require {
        background-color: var(--tvlk-blue); color: white; font-weight: 700;
        border-radius: var(--radius-sm); padding: 14px; text-decoration: none; display: block; text-align: center; transition: 0.3s;
    }
    .btn-login-require:hover { background-color: var(--tvlk-dark-blue); color: white; }

    select option:disabled { color: #a0aab2; }
    
    @media (max-width: 991px) { .info-grid { grid-template-columns: 1fr; } .service-grid { grid-template-columns: 1fr; } }
</style>

<div class="container mt-3">
    <div class="tour-breadcrumb">
        <a href="index.php">Trang chủ</a> <i class="bi bi-chevron-right"></i>
        <a href="index.php?action=tours">Khám phá Tours</a> <i class="bi bi-chevron-right"></i>
        <span class="text-dark fw-bold"><?= htmlspecialchars($detail['tour_name']); ?></span>
    </div>

    <?php 
        $imgSrc = !empty($detail['image']) ? (strpos($detail['image'], 'http') === 0 ? $detail['image'] : '../public/uploads/' . $detail['image']) : 'https://images.unsplash.com/photo-1501785888041-af3ef285b470';
    ?>
    <div class="hero-detail" style="background-image: url('<?= $imgSrc ?>');">
        <div class="hero-content p-4 w-100">
            <div class="location-badge">
                <i class="bi bi-geo-alt-fill me-2"></i><?= htmlspecialchars($detail['destination']); ?>
            </div>
            <h1 class="hero-title"><?= htmlspecialchars($detail['tour_name']); ?></h1>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-8">

            <div class="info-grid">
                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-clock-history"></i></div>
                    <div class="info-text">
                        <h5>Thời lượng</h5>
                        <p><?= htmlspecialchars($detail['duration'] ?? '--'); ?> Ngày</p>
                    </div>
                </div>
                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-building"></i></div>
                    <div class="info-text">
                        <h5>Lưu trú</h5>
                        <p class="text-truncate" title="<?= htmlspecialchars($detail['hotel'] ?? 'Đang cập nhật'); ?>"><?= htmlspecialchars($detail['hotel'] ?? 'Đang cập nhật'); ?></p>
                    </div>
                </div>
                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-shield-check"></i></div>
                    <div class="info-text">
                        <h5>Tổ chức bởi</h5>
                        <p class="text-truncate" title="<?= htmlspecialchars($detail['partner_name'] ?? 'TravelVN'); ?>"><?= htmlspecialchars($detail['partner_name'] ?? 'TravelVN'); ?></p>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <h3 class="section-title"><i class="bi bi-stars"></i> Điểm nhấn hành trình</h3>
                <ul class="highlight-list">
                    <li>Trải nghiệm trọn vẹn cảnh quan thiên nhiên tuyệt đẹp và văn hóa đặc sắc tại <strong><?= htmlspecialchars($detail['destination']); ?></strong>.</li>
                    <li>Dịch vụ lưu trú tại <strong><?= htmlspecialchars($detail['hotel'] ?? 'khách sạn tiêu chuẩn') ?></strong> tiện nghi, vị trí trung tâm dễ dàng di chuyển.</li>
                    <li>Thưởng thức ẩm thực địa phương phong phú với các bữa ăn được chuẩn bị chu đáo.</li>
                    <li>Hướng dẫn viên kinh nghiệm, nhiệt tình chăm sóc suốt hành trình.</li>
                </ul>
                
                <div class="tour-gallery">
                    <img src="https://images.unsplash.com/photo-1528127269322-539801943592?w=400&q=80" alt="Ảnh 1">
                    <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?w=400&q=80" alt="Ảnh 2">
                    <img src="https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?w=400&q=80" alt="Ảnh 3">
                </div>
            </div>

            <div class="content-section">
                <h3 class="section-title"><i class="bi bi-card-text"></i> Tổng quan Tour</h3>
                <div class="text-content">
                    <?= nl2br(htmlspecialchars($detail['description'])); ?>
                </div>
            </div>

            <div class="content-section bg-light border-0">
                <div class="service-grid">
                    <div>
                        <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-check-circle text-success me-2"></i>Bao gồm</h5>
                        <ul class="service-list">
                            <?php
                            $includes = explode(',', $detail['include_service'] ?? 'Xe đưa đón đời mới,Hướng dẫn viên suốt tuyến,Bảo hiểm du lịch');
                            foreach ($includes as $item): ?>
                                <li><i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars(trim($item)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-x-circle text-danger me-2"></i>Không bao gồm</h5>
                        <ul class="service-list">
                            <?php
                            $excludes = explode(',', $detail['exclude_service'] ?? 'Chi phí cá nhân,Tiền TIP cho HDV,Thuế VAT');
                            foreach ($excludes as $item): ?>
                                <li><i class="bi bi-x-circle-fill"></i> <?= htmlspecialchars(trim($item)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <h3 class="section-title"><i class="bi bi-map"></i> Lịch trình chi tiết</h3>

                <?php if (!empty($schedules) && count($schedules) > 0): ?>
                    <div class="accordion" id="itineraryAccordion">
                        <?php foreach ($schedules as $index => $sched): ?>
                            <div class="accordion-item shadow-sm border-0 mb-3 rounded-3 overflow-hidden">
                                <h2 class="accordion-header" id="heading<?= $sched['day_number'] ?>">
                                    <button class="accordion-button <?= $index !== 0 ? 'collapsed' : '' ?>" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse<?= $sched['day_number'] ?>"
                                        aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>"
                                        aria-controls="collapse<?= $sched['day_number'] ?>">
                                        <span class="day-badge">Ngày <?= $sched['day_number'] ?></span>
                                        <?= htmlspecialchars($sched['location'] ?? 'Hoạt động nổi bật') ?>
                                    </button>
                                </h2>
                                <div id="collapse<?= $sched['day_number'] ?>"
                                    class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>"
                                    aria-labelledby="heading<?= $sched['day_number'] ?>" data-bs-parent="#itineraryAccordion">
                                    <div class="accordion-body text-content bg-white border-top">
                                        <?= nl2br(htmlspecialchars($sched['activity'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary">
                        <i class="bi bi-info-circle me-2"></i> Lịch trình chi tiết đang được cập nhật. Vui lòng liên hệ CSKH để biết thêm chi tiết.
                    </div>
                <?php endif; ?>
            </div>

            <div class="content-section border-0 p-0">
                <div class="policy-box">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Thông tin cần lưu ý</h5>
                    <ul>
                        <li><strong>Điểm tập trung:</strong> Thông báo chi tiết qua điện thoại/email trước ngày đi 1-2 ngày. Vui lòng có mặt trước 30 phút.</li>
                        <li><strong>Chính sách hủy:</strong> Hủy trước 03 ngày khởi hành hoàn 100%. Hủy sát ngày hoặc không có mặt mất 100% phí.</li>
                        <li>Khách hàng mang thai, có bệnh lý nền cần thông báo cho nhân viên tư vấn để được hỗ trợ sắp xếp.</li>
                        <li>Lịch trình có thể thay đổi thứ tự tùy theo điều kiện thời tiết thực tế nhưng vẫn đảm bảo đủ điểm tham quan.</li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="col-lg-4">
            <div class="booking-card" id="bookingSection">
                <span class="d-block text-muted fw-bold mb-2">Giá trọn gói chỉ từ</span>
                <div class="price-amount">
                    <?= number_format($detail['price']); ?> <span>VNĐ/khách</span>
                </div>

                <form action="index.php" method="GET">
                    <input type="hidden" name="action" value="booking">
                    <input type="hidden" name="tour_id" value="<?= $detail['tour_id']; ?>">

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark"><i class="bi bi-calendar2-check me-2 text-primary"></i>Chọn lịch khởi hành</label>
                        <?php if (!empty($departures) && count($departures) > 0): ?>
                            <select name="departure_id" class="form-select form-select-lg" style="border-radius: var(--radius-sm); font-size: 0.95rem; border-color: var(--tvlk-border);" required>
                                <option value="" disabled selected>-- Vui lòng chọn ngày --</option>
                                <?php foreach ($departures as $dep): ?>
                                    <option value="<?= $dep['departure_id'] ?>" <?= $dep['available_seats'] <= 0 ? 'disabled' : '' ?>>
                                        <?= date("d/m/Y", strtotime($dep['start_date'])) ?> 
                                        - <?= $dep['available_seats'] > 0 ? 'Còn ' . $dep['available_seats'] . ' chỗ' : 'Hết chỗ' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <div class="alert alert-warning py-2 px-3 mb-0" style="font-size: 0.9rem;">
                                <i class="bi bi-info-circle me-1"></i> Hiện chưa có lịch khởi hành mới.
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($_SESSION['user'])): ?>
                        <button type="submit" class="btn btn-book-now w-100 mb-3 shadow-sm" <?= empty($departures) ? 'disabled' : '' ?>>
                            Đặt tour ngay
                        </button>
                    <?php else: ?>
                        <a href="index.php?action=login" class="btn btn-login-require w-100 mb-3 shadow-sm">
                            Đăng nhập để đặt tour
                        </a>
                        <p class="text-center small text-muted">Hệ thống yêu cầu đăng nhập để bảo mật thông tin đặt chỗ của bạn.</p>
                    <?php endif; ?>
                </form>

                <div class="text-center mt-3 border-top pt-3">
                    <div class="d-flex justify-content-center gap-3 text-muted" style="font-size: 0.85rem;">
                        <span><i class="bi bi-shield-check text-success me-1"></i>Bảo mật 100%</span>
                        <span><i class="bi bi-headset text-primary me-1"></i>Hỗ trợ 24/7</span>
                    </div>
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
                    section.style.boxShadow = "0 0 0 4px rgba(255, 94, 31, 0.3)";
                    setTimeout(() => { section.style.boxShadow = "0 10px 30px rgba(3, 18, 26, 0.08)"; }, 2000);
                }
            }
        };
    </script>
</div>

<?php include 'layouts/footer.php'; ?>
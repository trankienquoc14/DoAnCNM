<?php
require_once __DIR__ . "/../models/Tour.php";
require_once __DIR__ . "/../config/database.php";

$db = (new Database())->connect();
$tourModel = new Tour($db);
$stmt = $tourModel->getTours();
?>

<?php include __DIR__ . "/../views/layouts/header.php"; ?>

<style>
    /* Nhúng trực tiếp font chữ nghệ thuật từ Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Inter:wght@400;500;600;700;800&display=swap');

    :root {
        --primary-color: #0194f3;
        --accent-color: #ff5e1f;
        --text-main: #2c3e50;
        --text-muted: #64748b;
        --bg-light: #f8fafc;
        --bg-soft-blue: #f0f7ff;
    }

    body {
        background-color: #fff;
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    /* --- HERO SECTION --- */
    .hero-section {
        height: 550px;
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e') center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        border-bottom-left-radius: 40px;
        border-bottom-right-radius: 40px;
        margin-bottom: -50px;
        padding-bottom: 60px;
    }

    /* SLOGAN CHỮ NGHỆ THUẬT */
    .slogan-text {
        font-family: 'Dancing Script', cursive;
        font-size: 3.2rem;
        color: #ffda79; /* Màu vàng nắng cực kỳ nổi bật */
        font-weight: 700;
        letter-spacing: 2px;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
        margin-bottom: 5px;
        display: block;
    }

    .hero-title {
        font-size: 3.2rem;
        font-weight: 800;
        letter-spacing: -1px;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        margin-bottom: 15px;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        font-weight: 400;
        opacity: 0.95;
        margin-bottom: 2rem;
    }

    /* --- SEARCH BOX --- */
    .hero-search { position: relative; z-index: 10; margin-bottom: 60px; }
    .search-card {
        background: white; border-radius: 20px; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        padding: 10px; border: 1px solid rgba(255, 255, 255, 0.8);
    }
    .search-box-inner { background: var(--bg-light); border-radius: 16px; padding: 20px; }
    .form-control-custom {
        border-radius: 12px; padding: 14px 15px; border: 1px solid #e2e8f0; font-weight: 500;
    }
    .form-control-custom:focus { border-color: var(--primary-color); box-shadow: 0 0 0 4px rgba(1, 148, 243, 0.1); }
    .btn-search {
        background-color: var(--accent-color); color: white; border-radius: 12px; font-weight: 700;
        padding: 14px; border: none; transition: 0.3s; font-size: 1.1rem;
    }
    .btn-search:hover { background-color: #e04d14; transform: translateY(-2px); }

    /* --- CATEGORY ICONS --- */
    .category-section { padding-top: 20px; padding-bottom: 60px; text-align: center; }
    .section-title-sm { font-weight: 800; color: var(--text-main); margin-bottom: 30px; font-size: 1.8rem; }
    .cat-item { text-align: center; transition: 0.3s; cursor: pointer; text-decoration: none; color: var(--text-main); display: block; }
    .cat-item:hover { transform: translateY(-5px); color: var(--primary-color); }
    .cat-icon-box {
        width: 75px; height: 75px; margin: 0 auto 15px; border-radius: 50%;
        background-color: var(--bg-soft-blue); display: flex; align-items: center; justify-content: center;
        font-size: 32px; color: var(--primary-color); box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03); transition: 0.3s;
    }
    .cat-item:hover .cat-icon-box { background-color: var(--primary-color); color: white; box-shadow: 0 8px 20px rgba(1, 148, 243, 0.3); }
    .cat-title { font-weight: 600; font-size: 0.95rem; }

    /* --- TOP DESTINATIONS --- */
    .dest-section { background-color: var(--bg-soft-blue); padding: 80px 0; margin-bottom: 60px; }
    .section-header { margin-bottom: 40px; text-align: center; }
    .section-title { font-weight: 800; color: var(--text-main); margin-bottom: 10px; font-size: 2.2rem; }
    .dest-card {
        border-radius: 20px; overflow: hidden; position: relative; height: 250px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); transition: 0.4s; cursor: pointer;
    }
    .dest-card.large { height: 524px; }
    .dest-card:hover { transform: scale(1.02); box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15); z-index: 2; }
    .dest-card img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .dest-card:hover img { transform: scale(1.1); }
    .dest-overlay {
        position: absolute; bottom: 0; left: 0; right: 0; padding: 30px 20px 20px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent); color: white; pointer-events: none;
    }
    .dest-name { font-size: 1.6rem; font-weight: 800; margin-bottom: 5px; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5); }
    .dest-count { font-size: 0.95rem; font-weight: 500; opacity: 0.9; }

    /* --- TOUR SLIDER --- */
    .slider-wrapper { position: relative; }
    .tour-scroll {
        display: flex; gap: 24px; overflow-x: auto; scroll-behavior: smooth;
        padding: 10px 5px 30px 5px; scroll-snap-type: x mandatory; margin-bottom: 40px;
    }
    .tour-scroll::-webkit-scrollbar { display: none; }
    .tour-item { min-width: 320px; max-width: 320px; scroll-snap-align: start; }
    .tour-card {
        border-radius: 20px; border: 1px solid #f0f0f0; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.04);
        transition: 0.3s; height: 100%; display: flex; flex-direction: column; background: white;
    }
    .tour-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1); border-color: #e2e8f0; }
    .tour-image-wrapper { position: relative; overflow: hidden; border-radius: 20px 20px 0 0; }
    .tour-card img { width: 100%; height: 220px; object-fit: cover; transition: 0.5s; }
    .tour-card:hover img { transform: scale(1.08); }
    .badge-duration {
        position: absolute; bottom: 12px; left: 12px; background: rgba(0, 0, 0, 0.7);
        color: white; padding: 5px 12px; border-radius: 30px; font-size: 0.8rem; font-weight: 600; backdrop-filter: blur(4px);
    }
    .card-body-custom { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
    .tour-title {
        font-size: 1.15rem; font-weight: 700; color: var(--text-dark); display: -webkit-box;
        -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 12px; line-height: 1.4;
    }
    .tour-price { color: var(--accent-color); font-weight: 800; font-size: 1.3rem; margin-top: auto; margin-bottom: 15px; }
    .btn-outline-primary-custom {
        color: var(--primary-color); border: 2px solid #eef7ff; background: #eef7ff;
        border-radius: 12px; font-weight: 600; padding: 10px; transition: 0.3s;
    }
    .tour-card:hover .btn-outline-primary-custom { background-color: var(--primary-color); color: white; border-color: var(--primary-color); }
    
    .slider-btn {
        position: absolute; top: 40%; transform: translateY(-50%); border: 1px solid #e2e8f0;
        width: 45px; height: 45px; border-radius: 50%; background: white; color: var(--text-dark);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); cursor: pointer; font-size: 18px; z-index: 10;
        transition: 0.3s; display: flex; align-items: center; justify-content: center;
    }
    .slider-btn:hover { background: var(--primary-color); color: white; border-color: var(--primary-color); }
    .slider-btn.left { left: -15px; } .slider-btn.right { right: -15px; }

    /* --- STATS PARALLAX BANNER (ĐIỂM NHẤN CẮT NGANG MÀU TRẮNG) --- */
    .stats-section {
        background: linear-gradient(rgba(1, 148, 243, 0.85), rgba(1, 148, 243, 0.95)), url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1') center/cover fixed;
        padding: 70px 0; color: white; margin-bottom: 60px;
    }
    .stat-item h2 { font-size: 3.2rem; font-weight: 800; margin-bottom: 5px; }
    .stat-item p { font-size: 1.1rem; font-weight: 500; opacity: 0.9; margin-bottom: 0; }

    /* --- WHY CHOOSE US & PARTNERS --- */
    .features-section { padding: 80px 0; background-color: var(--bg-light); }
    .feature-box {
        text-align: center; padding: 35px 25px; border-radius: 20px; transition: 0.3s;
        border: 1px solid transparent; background: transparent; height: 100%;
    }
    .feature-box:hover {
        background: white; border-color: #f0f0f0; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); transform: translateY(-5px);
    }
    .feature-icon {
        width: 70px; height: 70px; background: white; color: var(--primary-color);
        border-radius: 20px; display: flex; align-items: center; justify-content: center;
        font-size: 32px; margin: 0 auto 20px auto; transform: rotate(-5deg); transition: 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .feature-box:hover .feature-icon { transform: rotate(0deg); background: var(--primary-color); color: white; }

    .partners-wrapper {
        background: white; border-radius: 24px; padding: 40px 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-top: 50px;
    }
    .partners-scroll {
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 30px; opacity: 0.7;
    }
    .partners-scroll img { height: 40px; filter: grayscale(100%); transition: 0.3s; cursor: pointer; }
    .partners-scroll img:hover { filter: grayscale(0%); opacity: 1; transform: scale(1.1); }

    /* --- NEWSLETTER --- */
    .newsletter-section { padding: 60px 0; margin-bottom: 0; background-color: var(--bg-light); padding-bottom: 80px;}
    .newsletter-box {
        background: linear-gradient(135deg, var(--primary-color), #00d2ff); border-radius: 30px;
        padding: 60px 40px; text-align: center; color: white; position: relative; overflow: hidden;
    }
    .newsletter-box::before {
        content: "\f124"; font-family: "bootstrap-icons"; position: absolute;
        right: -20px; top: -30px; font-size: 200px; opacity: 0.1; transform: rotate(-15deg);
    }
    .nl-input-group {
        max-width: 500px; margin: 30px auto 0; background: white; padding: 8px;
        border-radius: 50px; display: flex; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    .nl-input-group input {
        border: none; background: transparent; padding-left: 20px; flex-grow: 1;
        outline: none; font-weight: 500; color: var(--text-dark);
    }
    .nl-btn {
        background: var(--accent-color); border: none; color: white; padding: 12px 30px;
        border-radius: 50px; font-weight: 700; transition: 0.3s;
    }
    .nl-btn:hover { background: #e04d14; }
</style>

<div class="hero-section">
    <div class="container">
        <span class="slogan-text">Xách balo lên và đi...</span>
        
        <h1 class="hero-title">Khám phá thế giới cùng TravelVN</h1>
        <p class="hero-subtitle">Hơn 500+ điểm đến tuyệt vời với giá cực kỳ ưu đãi đang chờ bạn.</p>
    </div>
</div>

<div class="container hero-search">
    <div class="search-card">
        <div class="search-box-inner">
            <form method="GET" action="../views/tours.php">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label text-muted fw-bold small ms-1 mb-1"><i class="bi bi-geo-alt"></i> Điểm đến</label>
                        <input type="text" name="location" class="form-control form-control-custom border-0 shadow-sm" placeholder="Bạn muốn đi đâu?">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label text-muted fw-bold small ms-1 mb-1"><i class="bi bi-calendar-date"></i> Ngày đi</label>
                        <input type="date" name="departure_date" class="form-control form-control-custom border-0 shadow-sm">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label text-muted fw-bold small ms-1 mb-1"><i class="bi bi-cash"></i> Ngân sách tối đa</label>
                        <input type="number" name="max_price" class="form-control form-control-custom border-0 shadow-sm" placeholder="Ví dụ: 5000000">
                    </div>
                    <div class="col-lg-2 col-md-6 d-flex align-items-end">
                        <button class="btn btn-search w-100 mt-auto shadow-sm">Tìm tour</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container category-section">
    <h3 class="section-title-sm">Khám phá theo trải nghiệm</h3>
    <div class="row g-4 justify-content-center">
        <div class="col-4 col-md-2"><a href="tours.php?cat=sea" class="cat-item">
                <div class="cat-icon-box"><i class="bi bi-water"></i></div>
                <div class="cat-title">Du lịch biển</div>
            </a></div>
        <div class="col-4 col-md-2"><a href="tours.php?cat=mountain" class="cat-item">
                <div class="cat-icon-box"><i class="bi bi-tree"></i></div>
                <div class="cat-title">Khám phá núi</div>
            </a></div>
        <div class="col-4 col-md-2"><a href="tours.php?cat=culture" class="cat-item">
                <div class="cat-icon-box"><i class="bi bi-bank"></i></div>
                <div class="cat-title">Văn hóa & Lịch sử</div>
            </a></div>
        <div class="col-4 col-md-2"><a href="tours.php?cat=resort" class="cat-item">
                <div class="cat-icon-box"><i class="bi bi-house-heart"></i></div>
                <div class="cat-title">Nghỉ dưỡng</div>
            </a></div>
        <div class="col-4 col-md-2"><a href="tours.php?cat=international" class="cat-item">
                <div class="cat-icon-box"><i class="bi bi-airplane"></i></div>
                <div class="cat-title">Quốc tế</div>
            </a></div>
    </div>
</div>

<div class="dest-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Điểm đến thịnh hành</h2>
            <p class="text-muted">Những địa danh được tìm kiếm và đặt chỗ nhiều nhất trong tháng</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="dest-card large" onclick="window.location.href='tours.php?keyword=Đà Nẵng'">
                    <img src="uploads/banner1.png" alt="Da Nang">
                    <div class="dest-overlay">
                        <h3 class="dest-name">Đà Nẵng</h3>
                        <div class="dest-count"><i class="bi bi-map me-1"></i> 24+ Tours</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="dest-card" onclick="window.location.href='tours.php?keyword=Sapa'">
                            <img src="uploads/banner2.png" alt="Sapa">
                            <div class="dest-overlay">
                                <h3 class="dest-name">Sapa</h3>
                                <div class="dest-count"><i class="bi bi-map me-1"></i> 18+ Tours</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="dest-card" onclick="window.location.href='tours.php?keyword=Phú Quốc'">
                            <img src="uploads/banner3.png" alt="Phu Quoc">
                            <div class="dest-overlay">
                                <h3 class="dest-name">Phú Quốc</h3>
                                <div class="dest-count"><i class="bi bi-map me-1"></i> 32+ Tours</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5 pt-3">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="section-title mb-1" style="font-size: 2rem;">🔥 Tour giá tốt hôm nay</h2>
            <p class="text-muted mb-0">Đặt ngay kẻo lỡ - Số lượng có hạn</p>
        </div>
        <a href="../views/tours.php" class="text-decoration-none fw-bold" style="color: var(--primary-color);">Xem tất cả <i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="slider-wrapper">
        <button class="slider-btn left d-none d-md-flex" onclick="scrollLeftTour()"><i class="bi bi-chevron-left"></i></button>

        <div class="tour-scroll" id="tourScroll">
            <?php while ($tour = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="tour-item">
                    <div class="card tour-card">
                        <div class="tour-image-wrapper">
                            <img src="<?= !empty($tour['image']) ? '../public/uploads/' . $tour['image'] : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800' ?>"
                                alt="<?= htmlspecialchars($tour['tour_name']) ?>">
                            <span class="badge-duration"><i class="bi bi-clock-history me-1"></i><?= $tour['duration'] ?> ngày</span>
                        </div>
                        <div class="card-body-custom">
                            <div class="text-muted small mb-1"><i class="bi bi-geo-alt-fill text-danger me-1"></i><?= htmlspecialchars($tour['destination']) ?></div>
                            <h5 class="tour-title" title="<?= htmlspecialchars($tour['tour_name']) ?>"><?= htmlspecialchars($tour['tour_name']) ?></h5>
                            <p class="tour-price"><?= number_format($tour['price']) ?> <span style="font-size: 0.9rem; font-weight: 500; color: #6c757d;">đ</span></p>

                            <a href="../views/tour_detail.php?id=<?= $tour['tour_id'] ?>" class="btn btn-outline-primary-custom w-100 text-center d-block text-decoration-none mt-auto">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <button class="slider-btn right d-none d-md-flex" onclick="scrollRightTour()"><i class="bi bi-chevron-right"></i></button>
    </div>
</div>

<script>
    function scrollLeftTour() { document.getElementById('tourScroll').scrollBy({ left: -344, behavior: 'smooth' }); }
    function scrollRightTour() { document.getElementById('tourScroll').scrollBy({ left: 344, behavior: 'smooth' }); }
</script>

<div class="features-section border-top">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Vì sao chọn TravelVN?</h2>
            <p class="text-muted">Chúng tôi cam kết mang lại trải nghiệm tuyệt vời nhất cho mỗi chuyến đi của bạn</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <h5 class="fw-bold">An toàn & Uy tín</h5>
                    <p class="text-muted small mb-0">Đối tác của các hãng hàng không và khách sạn 5 sao hàng đầu.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-icon"><i class="bi bi-wallet2"></i></div>
                    <h5 class="fw-bold">Giá tốt nhất</h5>
                    <p class="text-muted small mb-0">Cam kết hoàn tiền nếu bạn tìm thấy giá rẻ hơn ở nơi khác.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-icon"><i class="bi bi-headset"></i></div>
                    <h5 class="fw-bold">Hỗ trợ 24/7</h5>
                    <p class="text-muted small mb-0">Đội ngũ CSKH luôn sẵn sàng giải quyết mọi vấn đề của bạn.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-icon"><i class="bi bi-credit-card"></i></div>
                    <h5 class="fw-bold">Thanh toán dễ dàng</h5>
                    <p class="text-muted small mb-0">Hỗ trợ quét mã VietQR, thẻ tín dụng, ATM nội địa cực nhanh.</p>
                </div>
            </div>
        </div>

        <div class="partners-wrapper">
            <h5 class="text-center text-muted fw-bold mb-4">Các đối tác đồng hành cùng chúng tôi</h5>
            <div class="partners-scroll">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/15/Vietnam_Airlines_logo.svg/512px-Vietnam_Airlines_logo.svg.png" alt="VN Airlines" style="height: 35px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/VietJet_Air_logo.svg/512px-VietJet_Air_logo.svg.png" alt="Vietjet" style="height: 40px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/69/Agoda_transparent_logo.png/512px-Agoda_transparent_logo.png" alt="Agoda" style="height: 35px;">
                <img src="https://upload.wikimedia.org/wikipedia/vi/thumb/8/87/Traveloka_Primary_Logo.png/512px-Traveloka_Primary_Logo.png" alt="Traveloka" style="height: 35px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/25/Logo_MB_new.png/512px-Logo_MB_new.png" alt="MBBank" style="height: 40px;">
            </div>
        </div>
    </div>
</div>

<div class="newsletter-section">
    <div class="container">
        <div class="newsletter-box shadow-lg">
            <h2 class="fw-bold mb-3">Săn mã giảm giá lên đến 50%</h2>
            <p class="fs-5 opacity-75 mb-0">Đăng ký email để nhận ngay các ưu đãi độc quyền hàng tuần từ TravelVN</p>
            <form action="#" method="POST">
                <div class="nl-input-group">
                    <input type="email" placeholder="Nhập địa chỉ email của bạn" required>
                    <button type="submit" class="nl-btn">Nhận mã</button>
                </div>
            </form>
            <p class="small opacity-50 mt-3 mb-0">*Chúng tôi cam kết không gửi thư rác.</p>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../views/layouts/footer.php"; ?>
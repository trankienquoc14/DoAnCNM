<?php include __DIR__ . "/../views/layouts/header.php"; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&display=swap');

    :root {
        --tvlk-blue: #0194f3;
        --tvlk-dark-blue: #0770cd;
        --tvlk-orange: #ff5e1f;
        --tvlk-bg: #f7f9fa;
        --tvlk-text: #03121a;
        --tvlk-gray: #687176;
        --tvlk-border: #e1e8ee;
        --radius-md: 8px;
        --radius-lg: 16px;
    }

    body {
        background-color: var(--tvlk-bg);
        font-family: 'Inter', sans-serif;
        color: var(--tvlk-text);
    }

    /* --- HERO & FLOATING SEARCH --- */
    .hero-banner {
        height: 360px;
        background: linear-gradient(rgba(3, 18, 26, 0.4), rgba(3, 18, 26, 0.7)), url('uploads/banner_head.jpg') center/cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slogan-text {
        font-family: 'Dancing Script', cursive;
        font-size: 3rem;
        color: #ffda79;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
        display: block;
        margin-bottom: 5px;
        transform: rotate(-2deg);
    }

    .hero-title-box {
        margin-top: -60px;
        text-align: center;
    }

    .hero-title {
        color: white;
        font-size: 2.2rem;
        font-weight: 800;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    }

    .search-widget-container {
        max-width: 1040px;
        margin: -80px auto 40px;
        position: relative;
        z-index: 10;
        padding: 0 15px;
    }

    .search-widget {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        padding: 24px;
        border: 1px solid var(--tvlk-border);
    }

    .widget-tabs {
        display: flex;
        gap: 20px;
        border-bottom: 2px solid var(--tvlk-bg);
        margin-bottom: 20px;
        padding-bottom: 10px;
    }

    .widget-tab {
        font-weight: 700;
        color: var(--tvlk-gray);
        cursor: pointer;
        padding-bottom: 10px;
        margin-bottom: -12px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
    }

    .widget-tab:hover {
        color: var(--tvlk-text);
    }

    .widget-tab.active {
        color: var(--tvlk-blue);
        border-bottom: 3px solid var(--tvlk-blue);
    }

    .search-input-group {
        background: white;
        border: 1px solid var(--tvlk-border);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        padding: 10px 16px;
        transition: 0.2s;
    }

    .search-input-group:focus-within {
        border-color: var(--tvlk-blue);
        box-shadow: 0 0 0 1px var(--tvlk-blue);
    }

    .search-input-group i {
        color: var(--tvlk-gray);
        font-size: 1.2rem;
        margin-right: 12px;
    }

    .search-input-group label {
        display: block;
        font-size: 0.75rem;
        color: var(--tvlk-gray);
        font-weight: 600;
        margin-bottom: 2px;
    }

    .search-input-group input {
        border: none;
        padding: 0;
        outline: none;
        width: 100%;
        font-weight: 600;
        color: var(--tvlk-text);
    }

    .btn-tvlk {
        background: var(--tvlk-orange);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 700;
        font-size: 1.1rem;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: 0.2s;
    }

    .btn-tvlk:hover {
        background: #e55015;
        color: white;
    }

    /* --- SERVICE ICONS MENU --- */
    .service-menu {
        margin-bottom: 40px;
    }

    .service-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        text-decoration: none;
        color: var(--tvlk-text);
        cursor: pointer;
    }

    .service-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: white;
        margin-bottom: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: 0.3s;
    }

    .service-item:hover .service-icon {
        transform: translateY(-4px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    .service-text {
        font-size: 0.85rem;
        font-weight: 600;
    }

    .bg-sea {
        background: linear-gradient(135deg, #0194f3, #00d2ff);
    }

    .bg-mountain {
        background: linear-gradient(135deg, #1bbc9b, #34d399);
    }

    .bg-culture {
        background: linear-gradient(135deg, #f9ba05, #fbbf24);
    }

    .bg-resort {
        background: linear-gradient(135deg, #ff5e1f, #fca5a5);
    }

    .bg-eco {
        background: linear-gradient(135deg, #84cc16, #bef264);
    }

    /* --- COMMON TITLE --- */
    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--tvlk-text);
        margin-bottom: 20px;
    }

    /* --- ĐỊA ĐIỂM ĐƯỢC YÊU THÍCH --- */
    .dest-card {
        display: block;
        position: relative;
        border-radius: var(--radius-lg);
        overflow: hidden;
        height: 200px;
        text-decoration: none;
    }

    .dest-card::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 60%);
        pointer-events: none;
    }

    .dest-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s ease;
    }

    .dest-card:hover img {
        transform: scale(1.1);
    }

    .dest-info {
        position: absolute;
        bottom: 15px;
        left: 15px;
        z-index: 2;
    }

    .dest-title {
        color: white;
        font-weight: 800;
        font-size: 1.25rem;
        margin-bottom: 2px;
    }

    .dest-count {
        color: #e1e8ee;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* --- TOUR SLIDER HIỂN THỊ ĐÚNG 4 THẺ --- */
    .slider-wrapper {
        position: relative;
    }

    .tour-scroll {
        display: flex;
        gap: 24px;
        overflow-x: auto;
        padding-bottom: 30px;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
    }

    .tour-scroll::-webkit-scrollbar {
        display: none;
    }

    .tour-item {
        flex: 0 0 calc((100% - 72px) / 4);
        scroll-snap-align: start;
    }

    @media (max-width: 991px) {
        .tour-item {
            flex: 0 0 calc((100% - 24px) / 2);
        }
    }

    @media (max-width: 575px) {
        .tour-item {
            flex: 0 0 100%;
        }
    }

    .slider-btn {
        position: absolute;
        top: 40%;
        transform: translateY(-50%);
        border: 1px solid var(--tvlk-border);
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: white;
        color: var(--tvlk-text);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        font-size: 18px;
        z-index: 10;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slider-btn:hover {
        background: var(--tvlk-blue);
        color: white;
        border-color: var(--tvlk-blue);
    }

    .slider-btn.left {
        left: -20px;
    }

    .slider-btn.right {
        right: -20px;
    }

    /* --- TOUR CARDS --- */
    .tvlk-card {
        background: white;
        border-radius: var(--radius-md);
        box-shadow: 0 2px 8px rgba(3, 18, 26, 0.08);
        border: 1px solid var(--tvlk-border);
        overflow: hidden;
        transition: 0.2s;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .tvlk-card:hover {
        box-shadow: 0 8px 24px rgba(3, 18, 26, 0.12);
        transform: translateY(-4px);
    }

    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #e11d48;
        color: white;
        padding: 4px 10px;
        border-radius: 4px;
        font-weight: 800;
        font-size: 0.8rem;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(225, 29, 72, 0.4);
    }

    .card-img-box {
        position: relative;
        height: 180px;
    }

    .card-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rating-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(4px);
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--tvlk-text);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .tvlk-card-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .tour-location {
        font-size: 0.8rem;
        color: var(--tvlk-gray);
        font-weight: 700;
        margin-bottom: 6px;
        text-transform: uppercase;
    }

    .tour-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--tvlk-text);
        line-height: 1.4;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .price-box {
        margin-top: auto;
        text-align: right;
    }

    .price-old {
        font-size: 0.85rem;
        color: var(--tvlk-gray);
        text-decoration: line-through;
        margin-bottom: 2px;
    }

    .price-current {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--tvlk-orange);
    }

    /* --- CẨM NANG DU LỊCH ĐÃ LÀM GỌN --- */
    .blog-section {
        padding: 60px 0;
        background-color: white;
        border-top: 1px solid var(--tvlk-border);
    }

    .blog-card {
        background: white;
        border-radius: var(--radius-md);
        border: 1px solid var(--tvlk-border);
        overflow: hidden;
        transition: 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        text-decoration: none;
        color: var(--tvlk-text);
    }

    .blog-card:hover {
        box-shadow: 0 8px 24px rgba(3, 18, 26, 0.08);
        transform: translateY(-4px);
        border-color: transparent;
    }

    .blog-img {
        height: 160px;
        position: relative;
    }

    .blog-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .blog-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: var(--tvlk-blue);
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .blog-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }

    .blog-date {
        font-size: 0.8rem;
        color: var(--tvlk-gray);
        margin-bottom: 6px;
        font-weight: 500;
    }

    .blog-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--tvlk-text);
        line-height: 1.4;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .blog-readmore {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--tvlk-orange);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* --- LÝ DO CHỌN VIETTRAVEL (NÂNG CẤP GIAO DIỆN) --- */
    .why-tvlk {
        background: var(--tvlk-bg);
        padding: 80px 0;
        border-top: 1px solid var(--tvlk-border);
    }

    .why-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        background: white;
        padding: 40px 25px;
        border-radius: var(--radius-lg);
        border: 1px solid var(--tvlk-border);
        height: 100%;
        transition: 0.3s;
    }

    .why-item:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        transform: translateY(-5px);
        border-color: white;
    }

    .why-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: #e6f5fe;
        color: var(--tvlk-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin-bottom: 20px;
    }

    .why-text h5 {
        font-size: 1.15rem;
        font-weight: 800;
        margin-bottom: 12px;
        color: var(--tvlk-text);
    }

    .why-text p {
        font-size: 0.95rem;
        color: var(--tvlk-gray);
        line-height: 1.6;
        margin: 0;
    }
</style>

<div class="hero-banner">
    <div class="hero-title-box">
        <span class="slogan-text">Đi để thêm yêu Tổ quốc</span>
        <h1 class="hero-title">Khám phá vẻ đẹp Việt Nam</h1>
    </div>
</div>

<div class="search-widget-container">
    <div class="search-widget">
        <!-- <div class="widget-tabs">
            <div class="widget-tab active"><i class="bi bi-star-fill text-warning"></i> Tour Nổi Bật</div>
            <div class="widget-tab" onclick="window.location.href='index.php?action=tours&cat=domestic'"><i class="bi bi-geo-alt-fill"></i> Ngắn ngày</div>
            <div class="widget-tab" onclick="window.location.href='index.php?action=tours&cat=crossvietnam'"><i class="bi bi-map"></i> Xuyên Việt</div>
        </div> -->

        <form method="GET" action="index.php">
            <input type="hidden" name="action" value="tours">
            <div class="row g-3 align-items-stretch">
                <div class="col-lg-4 col-md-6">
                    <div class="search-input-group">
                        <i class="bi bi-search"></i>
                        <div class="w-100">
                            <label>Địa điểm hoặc tên Tour</label>
                            <input type="text" name="location" placeholder="Đà Nẵng, Phú Quốc, Sapa...">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="search-input-group">
                        <i class="bi bi-calendar-event"></i>
                        <div class="w-100">
                            <label>Ngày khởi hành</label>
                            <input type="date" name="departure_date">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="search-input-group">
                        <i class="bi bi-cash"></i>
                        <div class="w-100">
                            <label>Ngân sách tối đa</label>
                            <input type="number" name="max_price" placeholder="Ví dụ: 5.000.000">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <button class="btn-tvlk shadow-sm"><i class="bi bi-search"></i> Tìm kiếm</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container service-menu">
    <div class="row g-3 justify-content-center">
        <div class="col-4 col-md-2">
            <a href="index.php?action=tours&cat=sea" class="service-item">
                <div class="service-icon bg-sea"><i class="bi bi-water"></i></div>
                <span class="service-text">Du lịch Biển</span>
            </a>
        </div>
        <div class="col-4 col-md-2">
            <a href="index.php?action=tours&cat=mountain" class="service-item">
                <div class="service-icon bg-mountain"><i class="bi bi-tree"></i></div>
                <span class="service-text">Khám phá Núi</span>
            </a>
        </div>
        <div class="col-4 col-md-2">
            <a href="index.php?action=tours&cat=culture" class="service-item">
                <div class="service-icon bg-culture"><i class="bi bi-bank"></i></div>
                <span class="service-text">Văn hóa & Lịch sử</span>
            </a>
        </div>
        <div class="col-4 col-md-2">
            <a href="index.php?action=tours&cat=resort" class="service-item">
                <div class="service-icon bg-resort"><i class="bi bi-house-heart"></i></div>
                <span class="service-text">Nghỉ dưỡng</span>
            </a>
        </div>
        <div class="col-4 col-md-2">
            <a href="index.php?action=tours&cat=eco" class="service-item">
                <div class="service-icon bg-eco"><i class="bi bi-flower1"></i></div>
                <span class="service-text">Sinh thái</span>
            </a>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title mb-0">Địa điểm được yêu thích nhất</h2>
        <a href="index.php?action=tours" class="text-decoration-none fw-bold" style="color: var(--tvlk-blue);">Xem tất
            cả <i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="row g-3">
        <div class="col-6 col-md-3">
            <a href="index.php?action=tours&keyword=Đà Nẵng" class="dest-card">
                <img src="uploads/banner1.png" alt="Đà Nẵng">
                <div class="dest-info">
                    <h4 class="dest-title">Đà Nẵng</h4>
                    <span class="dest-count"><?= $destCounts['danang'] ?? 0 ?> Tour</span>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="index.php?action=tours&keyword=Phú Quốc" class="dest-card">
                <img src="uploads/banner2.png" alt="Phú Quốc">
                <div class="dest-info">
                    <h4 class="dest-title">Phú Quốc</h4>
                    <span class="dest-count"><?= $destCounts['phuquoc'] ?? 0 ?> Tour</span>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="index.php?action=tours&keyword=Sapa" class="dest-card">
                <img src="uploads/banner3.png" alt="Sapa">
                <div class="dest-info">
                    <h4 class="dest-title">Sapa</h4>
                    <span class="dest-count"><?= $destCounts['sapa'] ?? 0 ?> Tour</span>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="index.php?action=tours&keyword=Đà Lạt" class="dest-card">
                <img src="uploads/banner4.jpg" alt="Đà Lạt">
                <div class="dest-info">
                    <h4 class="dest-title">Đà Lạt</h4>
                    <span class="dest-count"><?= $destCounts['dalat'] ?? 0 ?> Tour</span>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="container mb-5 pb-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="section-title mb-0">🔥 Tour có giá tốt nhất hôm nay</h2>
            <p class="text-muted mt-1 mb-0">Đừng bỏ lỡ các ưu đãi chớp nhoáng với số lượng có hạn</p>
        </div>
        <a href="index.php?action=tours" class="text-decoration-none fw-bold" style="color: var(--tvlk-blue);">Xem tất
            cả</a>
    </div>

    <div class="slider-wrapper">
        <button class="slider-btn left d-none d-md-flex" onclick="scrollLeftTour()"><i
                class="bi bi-chevron-left"></i></button>

        <div class="tour-scroll" id="tourScroll">
            <?php while ($tour = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="tour-item">
                    <a href="index.php?action=detail&slug=<?= $tour['slug'] ?>" class="text-decoration-none">
                        <div class="tvlk-card">
                            <div class="discount-badge">-20%</div>

                            <div class="card-img-box">
                                <img src="<?= !empty($tour['image']) ? '../public/uploads/' . $tour['image'] : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800' ?>"
                                    alt="<?= htmlspecialchars($tour['tour_name']) ?>">
                                <div class="rating-badge"><i class="bi bi-star-fill text-warning"></i> 4.8 <span
                                        class="text-muted fw-normal">(120)</span></div>
                            </div>

                            <div class="tvlk-card-body">
                                <div class="tour-location"><i class="bi bi-geo-alt-fill me-1"
                                        style="color: var(--tvlk-blue);"></i> <?= htmlspecialchars($tour['destination']) ?>
                                </div>
                                <h5 class="tour-title"><?= htmlspecialchars($tour['tour_name']) ?></h5>

                                <div class="price-box">
                                    <?php $oldPrice = $tour['price'] * 1.2; ?>
                                    <div class="price-old"><?= number_format($oldPrice) ?> VND</div>
                                    <div class="price-current"><?= number_format($tour['price']) ?> VND</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>

        <button class="slider-btn right d-none d-md-flex" onclick="scrollRightTour()"><i
                class="bi bi-chevron-right"></i></button>
    </div>
</div>

<script>
    function scrollLeftTour() {
        const slider = document.getElementById('tourScroll');
        slider.scrollBy({ left: -(slider.clientWidth), behavior: 'smooth' });
    }
    function scrollRightTour() {
        const slider = document.getElementById('tourScroll');
        slider.scrollBy({ left: slider.clientWidth, behavior: 'smooth' });
    }

    const slider = document.getElementById('tourScroll');
    let isDown = false; let startX; let scrollLeft;
    slider.addEventListener('mousedown', (e) => { isDown = true; startX = e.pageX - slider.offsetLeft; scrollLeft = slider.scrollLeft; });
    slider.addEventListener('mouseleave', () => { isDown = false; });
    slider.addEventListener('mouseup', () => { isDown = false; });
    slider.addEventListener('mousemove', (e) => { if (!isDown) return; e.preventDefault(); const x = e.pageX - slider.offsetLeft; const walk = (x - startX) * 2; slider.scrollLeft = scrollLeft - walk; });
</script>

<div class="blog-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title mb-0">Cẩm nang du lịch</h2>
                <p class="text-muted mt-1 mb-0">Kinh nghiệm và mẹo hay cho chuyến đi hoàn hảo</p>
            </div>
            <a href="index.php?action=blogs" class="text-decoration-none fw-bold" style="color: var(--tvlk-blue);">Xem
                tất cả bài viết</a>
        </div>

        <div class="row g-4">
            <?php if (!empty($blogs)): ?>
                <?php foreach ($blogs as $blog): ?>
                    <div class="col-lg-3 col-md-6">
                        <a href="index.php?action=blogDetail&slug=<?= $blog['slug'] ?>" class="blog-card">
                            <div class="blog-img">
                                <span class="blog-badge"><?= htmlspecialchars($blog['category'] ?? 'Cẩm nang') ?></span>
                                <img src="<?= !empty($blog['image']) ? (strpos($blog['image'], 'http') === 0 ? $blog['image'] : '../public/uploads/' . $blog['image']) : 'https://images.unsplash.com/photo-1542640244-7e672d6cb466?auto=format&fit=crop&w=600&q=80' ?>"
                                    alt="<?= htmlspecialchars($blog['title'] ?? 'Bài viết') ?>">
                            </div>
                            <div class="blog-body">
                                <div>
                                    <div class="blog-date"><i class="bi bi-calendar3 me-1"></i>
                                        <?= !empty($blog['created_at']) ? date('d/m/Y', strtotime($blog['created_at'])) : date('d/m/Y') ?>
                                    </div>
                                    <h5 class="blog-title"><?= htmlspecialchars($blog['title'] ?? 'Đang cập nhật tiêu đề') ?>
                                    </h5>
                                </div>
                                <span class="blog-readmore mt-2">Đọc tiếp <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted">
                    <p class="py-4 border rounded bg-light border-dashed">Hệ thống đang cập nhật các bài viết cẩm nang mới
                        nhất.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="why-tvlk">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-2" style="font-size: 2rem;">Lý do tại sao nên đặt tour với VIETTRAVEL</h2>
            <p class="text-muted fs-5">Tự hào là thương hiệu du lịch hàng đầu Việt Nam, mang đến trải nghiệm đẳng cấp.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="why-item">
                    <div class="why-icon"><i class="bi bi-award-fill"></i></div>
                    <div class="why-text">
                        <h5>Thương hiệu Uy tín</h5>
                        <p>Dù mới vào nghề, nhưng TravelVN tự hào là một trong những nhà tổ chức tour du lịch hàng đầu
                            và chuyên nghiệp
                            tại Việt Nam.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="why-item">
                    <div class="why-icon"><i class="bi bi-gem"></i></div>
                    <div class="why-text">
                        <h5>Chất lượng Tiên phong</h5>
                        <p>Dịch vụ trọn gói đạt chuẩn quốc tế, mạng lưới đối tác rộng khắp đảm bảo mang lại mức giá và
                            chất lượng tốt nhất.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="why-item">
                    <div class="why-icon"><i class="bi bi-headset"></i></div>
                    <div class="why-text">
                        <h5>Chăm sóc Tận tâm 24/7</h5>
                        <p>Đội ngũ nhân viên và hướng dẫn viên nhiệt huyết, hỗ trợ khách hàng chu đáo trên mọi nẻo đường
                            hành trình.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../views/layouts/footer.php"; ?>
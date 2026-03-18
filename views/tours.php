<?php
require_once '../config/database.php';

$db = (new Database())->connect();

// 1. NHẬN DỮ LIỆU TỪ FORM TÌM KIẾM
$location = $_GET['location'] ?? '';
$keyword = $_GET['keyword'] ?? ''; 
$departure_date = $_GET['departure_date'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$category = $_GET['cat'] ?? ''; 

// Gộp location và keyword làm 1 để linh hoạt
$search_term = !empty($location) ? $location : $keyword;

// 2. XÂY DỰNG CÂU LỆNH LỌC (DYNAMIC SQL)
$query = "SELECT DISTINCT t.* FROM tours t 
          LEFT JOIN departures d ON t.tour_id = d.tour_id 
          WHERE t.status = 'active'";
$params = [];

if (!empty($search_term)) {
    $query .= " AND (t.destination LIKE ? OR t.tour_name LIKE ?)";
    $params[] = "%$search_term%";
    $params[] = "%$search_term%";
}
if (!empty($max_price)) {
    $query .= " AND t.price <= ?";
    $params[] = $max_price;
}
if (!empty($departure_date)) {
    $query .= " AND d.start_date >= ?";
    $params[] = $departure_date;
}
if ($category == 'sea') {
    $query .= " AND (t.tour_name LIKE '%biển%' OR t.destination IN ('Đà Nẵng', 'Nha Trang', 'Phú Quốc', 'Côn Đảo'))";
} elseif ($category == 'mountain') {
    $query .= " AND (t.tour_name LIKE '%núi%' OR t.destination IN ('Sapa', 'Đà Lạt'))";
}

$query .= " ORDER BY t.tour_id DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
$tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'layouts/header.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Inter:wght@400;500;600;700;800&display=swap');

    :root {
        --primary-color: #0194f3;
        --accent-color: #ff5e1f;
        --text-main: #1a202c;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    body { background-color: #f8fafc; font-family: 'Inter', 'Segoe UI', sans-serif; }

    /* --- HERO SECTION --- */
    .hero-tours {
        height: 420px;
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1501785888041-af3ef285b470') center/cover no-repeat;
        display: flex; align-items: center; justify-content: center;
        text-align: center; color: white; margin-bottom: 50px;
        position: relative;
    }

    .hero-content-wrapper { position: relative; z-index: 2; width: 100%; max-width: 1000px; padding: 0 20px;}
    .hero-title { font-size: 3rem; font-weight: 800; text-shadow: 0 4px 12px rgba(0,0,0,0.3); margin-bottom: 10px;}
    .hero-subtitle { font-size: 1.15rem; font-weight: 400; opacity: 0.9; margin-bottom: 30px;}

    /* --- UNIFIED SEARCH BAR (THANH TÌM KIẾM NGUYÊN KHỐI) --- */
    .search-unified {
        background: #ffffff;
        border-radius: 50px;
        padding: 10px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        max-width: 900px;
        margin: 0 auto;
    }

    .search-group {
        display: flex;
        align-items: center;
        flex: 1;
        padding: 5px 20px;
        border-right: 1px solid var(--border-color);
        transition: 0.3s;
    }

    .search-group:hover { background-color: #f8fafc; border-radius: 30px; }

    .search-group i {
        font-size: 1.4rem;
        color: var(--primary-color);
        margin-right: 12px;
    }

    .search-input-wrapper { display: flex; flex-direction: column; text-align: left; width: 100%; }
    .search-input-wrapper label { font-size: 0.8rem; font-weight: 700; color: var(--text-main); margin-bottom: 2px; text-transform: uppercase;}
    .search-input-wrapper input {
        border: none; background: transparent; padding: 0;
        font-size: 0.95rem; font-weight: 500; color: var(--text-muted);
        outline: none; width: 100%;
    }
    
    /* Ẩn icon calendar mặc định của input date */
    input[type="date"]::-webkit-calendar-picker-indicator { opacity: 0.5; cursor: pointer; }

    .btn-search-unified {
        background-color: var(--accent-color);
        color: white; font-weight: 700; font-size: 1.1rem;
        border-radius: 50px; padding: 15px 35px; border: none;
        transition: 0.3s; display: flex; align-items: center; gap: 8px;
        margin-left: 10px;
    }
    .btn-search-unified:hover { background-color: #e04d14; transform: scale(1.02); }

    /* --- RESPONSIVE SEARCH BAR --- */
    @media (max-width: 768px) {
        .search-unified { flex-direction: column; border-radius: 24px; padding: 15px; }
        .search-group { border-right: none; border-bottom: 1px solid var(--border-color); padding: 15px 10px; width: 100%; }
        .search-group:hover { border-radius: 12px; }
        .btn-search-unified { width: 100%; justify-content: center; margin-left: 0; margin-top: 15px; border-radius: 16px; }
    }

    /* --- TOUR CARD --- */
    .tour-card {
        border: 1px solid #f0f0f0; border-radius: 20px; overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: all 0.3s ease;
        height: 100%; display: flex; flex-direction: column; background: white;
    }
    .tour-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); border-color: #cbd5e1; }
    .tour-image-wrapper { position: relative; overflow: hidden; height: 230px;}
    .tour-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .tour-card:hover img { transform: scale(1.08); }
    
    .location-badge {
        position: absolute; top: 15px; left: 15px; background: rgba(255, 255, 255, 0.95);
        color: var(--primary-color); padding: 6px 14px; border-radius: 50px;
        font-size: 0.85rem; font-weight: 700; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        z-index: 2;
    }

    .card-body-custom { padding: 24px; display: flex; flex-direction: column; flex-grow: 1; }
    .tour-title {
        font-size: 1.2rem; font-weight: 800; color: var(--text-main); margin-bottom: 15px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;
    }
    .tour-info-list { list-style: none; padding: 0; margin-bottom: 15px; }
    .tour-info-list li { color: #475569; font-size: 0.95rem; margin-bottom: 8px; display: flex; align-items: center; gap: 10px;}
    .tour-info-list li i { color: var(--primary-color); font-size: 1.1rem; }

    .tour-price {
        font-size: 1.5rem; font-weight: 800; color: var(--accent-color); margin-top: auto;
        padding-top: 15px; border-top: 1px dashed var(--border-color); display: flex; justify-content: space-between; align-items: center;
    }
    .tour-price span { font-size: 0.9rem; font-weight: 600; color: var(--text-muted); }

    .btn-actions { display: flex; gap: 10px; margin-top: 15px; }
    .btn-view { background-color: #f1f5f9; color: var(--text-main); border: none; font-weight: 600; border-radius: 12px; padding: 10px; flex: 1; transition: 0.3s; text-align: center; text-decoration: none;}
    .btn-view:hover { background-color: #e2e8f0; }
    .btn-book { background-color: var(--primary-color); color: white; border: none; font-weight: 600; border-radius: 12px; padding: 10px; flex: 1; transition: 0.3s; text-align: center; text-decoration: none;}
    .btn-book:hover { background-color: #007bc2; }
</style>

<div class="hero-tours">
    <div class="hero-content-wrapper">
        <h1 class="hero-title">Tìm kiếm hành trình của bạn</h1>
        <p class="hero-subtitle">Hàng trăm tour du lịch đang chờ bạn khám phá</p>

        <form method="GET" action="">
            <div class="search-unified">
                
                <div class="search-group">
                    <i class="bi bi-geo-alt-fill"></i>
                    <div class="search-input-wrapper">
                        <label>Điểm đến</label>
                        <input type="text" name="location" value="<?= htmlspecialchars($search_term) ?>" placeholder="Bạn muốn đi đâu?">
                    </div>
                </div>

                <div class="search-group">
                    <i class="bi bi-calendar-week-fill"></i>
                    <div class="search-input-wrapper">
                        <label>Ngày đi</label>
                        <input type="date" name="departure_date" value="<?= htmlspecialchars($departure_date) ?>">
                    </div>
                </div>

                <div class="search-group" style="border-right: none;">
                    <i class="bi bi-wallet-fill"></i>
                    <div class="search-input-wrapper">
                        <label>Ngân sách</label>
                        <input type="number" name="max_price" value="<?= htmlspecialchars($max_price) ?>" placeholder="Mức giá tối đa">
                    </div>
                </div>

                <button type="submit" class="btn-search-unified">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>

            </div>
        </form>
    </div>
</div>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark m-0" style="font-size: 1.8rem;">
            <?= empty($tours) ? 'Không tìm thấy kết quả' : 'Kết quả tìm kiếm (' . count($tours) . ' tour)' ?>
        </h3>
        <?php if (!empty($search_term) || !empty($max_price) || !empty($departure_date) || !empty($category)): ?>
            <a href="tours.php" class="btn btn-light border btn-sm text-danger fw-bold rounded-pill px-3 py-2 shadow-sm">
                <i class="bi bi-x-circle me-1"></i> Xóa bộ lọc
            </a>
        <?php endif; ?>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($tours as $row): ?>
            <div class="col">
                <div class="tour-card">
                    <div class="tour-image-wrapper">
                        <div class="location-badge"><i class="bi bi-geo-alt-fill me-1"></i><?= htmlspecialchars($row['destination']) ?></div>
                        <img src="<?= !empty($row['image']) ? '../public/uploads/' . $row['image'] : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=500&q=80' ?>" alt="<?= htmlspecialchars($row['tour_name']); ?>">
                    </div>

                    <div class="card-body-custom">
                        <h5 class="tour-title" title="<?= htmlspecialchars($row['tour_name']); ?>">
                            <?= htmlspecialchars($row['tour_name']); ?>
                        </h5>

                        <ul class="tour-info-list">
                            <li><i class="bi bi-clock-history"></i> <strong><?= htmlspecialchars($row['duration'] ?? '--'); ?> ngày</strong></li>
                            <li><i class="bi bi-building"></i> Khách sạn: <strong><?= htmlspecialchars($row['hotel'] ?? 'Đang cập nhật'); ?></strong></li>
                        </ul>

                        <div class="tour-price">
                            <?= number_format($row['price']); ?> <span
								style="font-size: 0.9rem; font-weight: 500; color: #6c757d;">VNĐ</span>
                        </div>

                        <div class="btn-actions">
                            <a href="tour_detail.php?id=<?= $row['tour_id']; ?>" class="btn-view">Chi tiết</a>
                            <button class="btn-book btn-book-now" 
                                data-id="<?= $row['tour_id']; ?>" 
                                data-name="<?= htmlspecialchars($row['tour_name']); ?>">
                                Đặt ngay
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if (empty($tours)): ?>
        <div class="text-center py-5 bg-white rounded-4 border mt-3 shadow-sm">
            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="No Result" width="120" class="mb-3 opacity-50">
            <h4 class="mt-2 fw-bold text-dark">Rất tiếc, không có kết quả!</h4>
            <p class="text-muted">Chúng tôi không tìm thấy tour nào khớp với bộ lọc của bạn.<br>Hãy thử thay đổi ngày đi, mức giá hoặc điểm đến khác nhé.</p>
            <a href="tours.php" class="btn btn-primary mt-3 rounded-pill px-4 py-2 fw-bold shadow-sm">Xem tất cả tour</a>
        </div>
    <?php endif; ?>

</div>

<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header bg-light border-0" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold text-primary"><i class="bi bi-calendar-check me-2"></i>Chọn lịch trình</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <h5 id="tourName" class="mb-4 fw-bold text-dark" style="line-height: 1.4;"></h5>

                <form action="booking.php" method="GET">
                    <input type="hidden" name="tour_id" id="tourId">

                    <label class="fw-bold mb-2 text-muted"><i class="bi bi-calendar-event me-1"></i> Ngày khởi hành:</label>
                    <select name="departure_id" id="departureSelect" class="form-select form-select-lg mb-4" style="border-radius: 12px;" required>
                        <option value="">Đang tải dữ liệu...</option>
                    </select>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm" style="border-radius: 12px; font-size: 1.1rem;">
                        Xác nhận đặt tour
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-book-now').forEach(btn => {
        btn.addEventListener('click', function () {
            const tourId = this.dataset.id;
            const tourName = this.dataset.name;

            document.getElementById('tourId').value = tourId;
            document.getElementById('tourName').innerText = tourName;
            
            document.getElementById('departureSelect').innerHTML = '<option value="">Đang tải dữ liệu...</option>';

            fetch('get_departures.php?tour_id=' + tourId)
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    if (data.length === 0) {
                        html = '<option value="" disabled selected>Xin lỗi, đã hết lịch khởi hành!</option>';
                    } else {
                        html = '<option value="" disabled selected>-- Chọn ngày đi --</option>';
                        data.forEach(d => {
                            html += `<option value="${d.departure_id}" 
                            ${d.available_seats <= 0 ? 'disabled' : ''}>
                            ${formatDate(d.start_date)} (Còn ${d.available_seats} chỗ)
                        </option>`;
                        });
                    }
                    document.getElementById('departureSelect').innerHTML = html;
                })
                .catch(error => {
                    console.error('Lỗi khi tải lịch khởi hành:', error);
                    document.getElementById('departureSelect').innerHTML = '<option value="" disabled>Lỗi kết nối. Vui lòng thử lại!</option>';
                });

            var myModal = new bootstrap.Modal(document.getElementById('bookingModal'));
            myModal.show();
        });
    });

    function formatDate(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleDateString('vi-VN', {day: '2-digit', month: '2-digit', year: 'numeric'});
    }
</script>

<?php include 'layouts/footer.php'; ?>
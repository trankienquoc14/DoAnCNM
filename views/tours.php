<?php include 'layouts/header.php'; ?>

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
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-lg: 24px;
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
    .hero-tours-mini {
        background: linear-gradient(135deg, var(--tvlk-blue), var(--tvlk-dark-blue));
        padding: 40px 0;
        margin-bottom: 30px;
        border-radius: var(--radius-md);
        color: white;
    }

    .search-unified {
        background: #ffffff; border-radius: 12px; padding: 6px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); display: flex; align-items: center; width: 100%;
    }
    .search-group {
        display: flex; align-items: center; flex: 1; padding: 5px 15px;
        border-right: 1px solid var(--tvlk-border);
    }
    .search-group:last-child { border-right: none; }
    .search-group i { font-size: 1.2rem; color: var(--tvlk-blue); margin-right: 10px; }
    .search-input-wrapper { display: flex; flex-direction: column; width: 100%; }
    .search-input-wrapper label { font-size: 0.75rem; font-weight: 700; color: var(--tvlk-gray); margin-bottom: 2px; text-transform: uppercase;}
    .search-input-wrapper input { border: none; background: transparent; padding: 0; font-size: 0.95rem; font-weight: 600; color: var(--tvlk-text); outline: none; width: 100%; }
    .btn-search-unified {
        background-color: var(--tvlk-orange); color: white; font-weight: 700; font-size: 1rem;
        border-radius: 8px; padding: 12px 25px; border: none; transition: 0.3s;
    }
    .btn-search-unified:hover { background-color: var(--tvlk-orange-hover); }

    /* --- SIDEBAR FILTER --- */
    .filter-sidebar {
        background: white; border-radius: var(--radius-md);
        border: 1px solid var(--tvlk-border); padding: 20px;
        position: sticky; top: 20px;
    }
    .filter-title { font-size: 1.1rem; font-weight: 800; color: var(--tvlk-text); margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid var(--tvlk-bg); display: flex; justify-content: space-between; align-items: center; }
    .filter-title span { color: var(--tvlk-blue); font-size: 0.85rem; cursor: pointer; font-weight: 600; }
    
    .filter-group { margin-bottom: 25px; }
    .filter-group-title { font-size: 0.95rem; font-weight: 700; color: var(--tvlk-text); margin-bottom: 12px; }
    .filter-checkbox { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; cursor: pointer; }
    .filter-checkbox input { width: 18px; height: 18px; cursor: pointer; accent-color: var(--tvlk-blue); }
    .filter-checkbox label { font-size: 0.9rem; color: var(--tvlk-gray); font-weight: 500; cursor: pointer; display: flex; justify-content: space-between; width: 100%; }

    /* --- SORTING BAR --- */
    .sorting-bar {
        display: flex; justify-content: space-between; align-items: center;
        background: white; padding: 15px 20px; border-radius: var(--radius-md);
        border: 1px solid var(--tvlk-border); margin-bottom: 20px;
    }
    .sorting-result { font-weight: 700; font-size: 1.1rem; }
    .sort-select { border: 1px solid var(--tvlk-border); border-radius: 8px; padding: 8px 15px; font-weight: 600; font-size: 0.9rem; color: var(--tvlk-text); outline: none; cursor: pointer; }

    /* --- TVLK TOUR CARD --- */
    .tvlk-card {
        background: white; border-radius: var(--radius-md); box-shadow: 0 2px 8px rgba(3, 18, 26, 0.05);
        border: 1px solid var(--tvlk-border); overflow: hidden; transition: 0.2s; height: 100%; display: flex; flex-direction: column; position: relative;
    }
    .tvlk-card:hover { box-shadow: 0 8px 24px rgba(3, 18, 26, 0.1); transform: translateY(-4px); border-color: transparent;}
    .card-img-box { position: relative; height: 180px; }
    .card-img-box img { width: 100%; height: 100%; object-fit: cover; }
    .rating-badge {
        position: absolute; bottom: 10px; left: 10px; background: rgba(255,255,255,0.95); backdrop-filter: blur(4px);
        padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; color: var(--tvlk-text); display: flex; align-items: center; gap: 4px;
    }
    .tvlk-card-body { padding: 16px; display: flex; flex-direction: column; flex-grow: 1; }
    .tour-location { font-size: 0.8rem; color: var(--tvlk-gray); font-weight: 700; margin-bottom: 8px; text-transform: uppercase; }
    .tour-title { font-size: 1.05rem; font-weight: 800; color: var(--tvlk-text); line-height: 1.4; margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .tour-info-list { list-style: none; padding: 0; margin-bottom: 15px; }
    .tour-info-list li { color: var(--tvlk-gray); font-size: 0.85rem; margin-bottom: 4px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
    .tour-info-list li i { color: var(--tvlk-blue); }
    .price-box { margin-top: auto; text-align: right; padding-top: 15px; border-top: 1px dashed var(--tvlk-border); }
    .price-current { font-size: 1.3rem; font-weight: 800; color: var(--tvlk-orange); }
    .btn-actions { display: flex; gap: 10px; margin-top: 15px; }
    .btn-view { background-color: var(--tvlk-bg); color: var(--tvlk-blue); border: 1px solid var(--tvlk-border); font-weight: 700; border-radius: var(--radius-sm); padding: 8px; flex: 1; transition: 0.2s; text-align: center; text-decoration: none; font-size: 0.9rem; }
    .btn-view:hover { background-color: var(--tvlk-blue); color: white; border-color: var(--tvlk-blue); }
    .btn-book { background-color: var(--tvlk-orange); color: white; border: none; font-weight: 700; border-radius: var(--radius-sm); padding: 8px; flex: 1; transition: 0.2s; text-align: center; font-size: 0.9rem; }
</style>

<div class="container">
    <div class="tour-breadcrumb">
        <a href="index.php">Trang chủ</a> <i class="bi bi-chevron-right"></i>
        <span class="text-dark fw-bold">Khám phá Tours</span>
    </div>

    <div class="hero-tours-mini">
        <div class="container px-4">
            <h2 class="fw-bold mb-4 text-center">Tìm kiếm hành trình tiếp theo của bạn</h2>
            <form method="GET" action="index.php">
                <input type="hidden" name="action" value="tours">
                <div class="search-unified">
                    <div class="search-group">
                        <i class="bi bi-geo-alt-fill"></i>
                        <div class="search-input-wrapper">
                            <label>Điểm đến</label>
                            <input type="text" name="location" value="<?= htmlspecialchars((string) ($search_term ?? '')) ?>" placeholder="Bạn muốn đi đâu?">
                        </div>
                    </div>
                    <div class="search-group">
                        <i class="bi bi-calendar-event"></i>
                        <div class="search-input-wrapper">
                            <label>Ngày đi</label>
                            <input type="date" name="departure_date" value="<?= htmlspecialchars((string) ($departure_date ?? '')) ?>">
                        </div>
                    </div>
                    <div class="search-group" style="border-right: none;">
                        <i class="bi bi-cash"></i>
                        <div class="search-input-wrapper">
                            <label>Ngân sách tối đa</label>
                            <input type="number" name="max_price" value="<?= htmlspecialchars((string) ($max_price ?? '')) ?>" placeholder="Ví dụ: 5000000">
                        </div>
                    </div>
                    <button type="submit" class="btn-search-unified">Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-3 d-none d-lg-block">
            <div class="filter-sidebar">
                <div class="filter-title">
                    Lọc kết quả 
                    <span onclick="window.location.reload();"><i class="bi bi-arrow-clockwise"></i> Đặt lại</span>
                </div>

                <div class="filter-group">
                    <div class="filter-group-title">Khoảng giá</div>
                    <div class="filter-checkbox"><input type="checkbox" class="filter-price" id="p1" value="0-2000000"><label for="p1">Dưới 2.000.000đ</label></div>
                    <div class="filter-checkbox"><input type="checkbox" class="filter-price" id="p2" value="2000000-5000000"><label for="p2">2.000.000đ - 5.000.000đ</label></div>
                    <div class="filter-checkbox"><input type="checkbox" class="filter-price" id="p3" value="5000000-999999999"><label for="p3">Trên 5.000.000đ</label></div>
                </div>

                <div class="filter-group mb-0">
                    <div class="filter-group-title">Thời lượng</div>
                    <div class="filter-checkbox"><input type="checkbox" class="filter-duration" id="d1" value="1-3"><label for="d1">1 - 3 ngày</label></div>
                    <div class="filter-checkbox"><input type="checkbox" class="filter-duration" id="d2" value="4-7"><label for="d2">4 - 7 ngày</label></div>
                    <div class="filter-checkbox"><input type="checkbox" class="filter-duration" id="d3" value="8-99"><label for="d3">Trên 7 ngày</label></div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            
            <div class="sorting-bar">
                <div class="sorting-result">
                    Tìm thấy <span class="text-primary" id="tour-count"><?= count($tours) ?></span> Tours phù hợp
                </div>
                <div class="sorting-options">
                    <span class="text-muted fw-bold" style="font-size: 0.9rem;">Sắp xếp theo:</span>
                    <select class="sort-select" id="sort-select">
                        <option value="default">Đề xuất của TravelVN</option>
                        <option value="price_asc">Giá: Thấp đến Cao</option>
                        <option value="price_desc">Giá: Cao đến Thấp</option>
                    </select>
                </div>
            </div>

            <div class="row g-4" id="tour-list-container">
                <?php if (!empty($tours)): ?>
                    <?php foreach ($tours as $row): ?>
                        
                        <div class="col-md-6 col-lg-4 tour-card-wrapper" 
                             data-price="<?= $row['price'] ?>" 
                             data-duration="<?= $row['duration'] ?? 0 ?>">
                             
                            <div class="tvlk-card">
                                <div class="card-img-box">
                                    <?php 
                                        $imgSrc = !empty($row['image']) ? (strpos($row['image'], 'http') === 0 ? $row['image'] : '../public/uploads/' . $row['image']) : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=500&q=80';
                                    ?>
                                    <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($row['tour_name']); ?>">
                                    <div class="rating-badge"><i class="bi bi-star-fill text-warning"></i> 4.8 <span class="text-muted fw-normal">(120)</span></div>
                                </div>

                                <div class="tvlk-card-body">
                                    <div class="tour-location"><i class="bi bi-geo-alt-fill me-1" style="color: var(--tvlk-blue);"></i><?= htmlspecialchars($row['destination']) ?></div>
                                    
                                    <h5 class="tour-title" title="<?= htmlspecialchars($row['tour_name']); ?>">
                                        <?= htmlspecialchars($row['tour_name']); ?>
                                    </h5>

                                    <ul class="tour-info-list">
                                        <li><i class="bi bi-clock-history"></i> <?= htmlspecialchars($row['duration'] ?? '--'); ?> ngày</li>
                                        <li><i class="bi bi-building"></i> <span class="text-truncate"><?= htmlspecialchars($row['hotel'] ?? 'Đang cập nhật'); ?></span></li>
                                    </ul>

                                    <div class="price-box">
                                        <div class="price-current">
                                            <?= number_format($row['price']); ?> <span style="font-size: 0.85rem; font-weight: 600; color: var(--tvlk-gray);">VNĐ</span>
                                        </div>
                                    </div>

                                    <div class="btn-actions">
                                        <a href="index.php?action=detail&id=<?= $row['tour_id']; ?>" class="btn-view">Chi tiết</a>
                                        <button class="btn-book btn-book-now" data-id="<?= $row['tour_id']; ?>" data-name="<?= htmlspecialchars($row['tour_name']); ?>">Đặt ngay</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12" id="no-result-msg">
                        <div class="text-center py-5 bg-white border shadow-sm" style="border-radius: var(--radius-lg);">
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="No Result" width="100" class="mb-3 opacity-50">
                            <h5 class="fw-bold text-dark">Rất tiếc, không có kết quả!</h5>
                            <p class="text-muted mb-4">Chúng tôi không tìm thấy tour nào khớp với bộ lọc của bạn.</p>
                            <a href="index.php?action=tours" class="btn text-white rounded-pill px-4 py-2 fw-bold" style="background: var(--tvlk-blue);">Xem tất cả tour</a>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="col-12 d-none" id="js-no-result">
                    <div class="text-center py-5 bg-white border shadow-sm" style="border-radius: var(--radius-lg);">
                        <h5 class="fw-bold text-dark">Không có tour phù hợp với tùy chọn lọc!</h5>
                        <p class="text-muted mb-0">Vui lòng bỏ bớt tiêu chí lọc bên trái để xem thêm kết quả.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    // BẮT SỰ KIỆN KHI NGƯỜI DÙNG BẤM VÀO CHECKBOX LỌC GIÁ HOẶC NGÀY
    document.querySelectorAll('.filter-price, .filter-duration').forEach(checkbox => {
        checkbox.addEventListener('change', runFilters);
    });

    // HÀM LỌC DANH SÁCH TOUR
    function runFilters() {
        // Lấy tất cả các checkbox đang được đánh dấu
        let selectedPrices = Array.from(document.querySelectorAll('.filter-price:checked')).map(cb => cb.value);
        let selectedDurations = Array.from(document.querySelectorAll('.filter-duration:checked')).map(cb => cb.value);
        
        let tours = document.querySelectorAll('.tour-card-wrapper');
        let visibleCount = 0;

        tours.forEach(tour => {
            // Đọc dữ liệu từ data-price và data-duration của từng thẻ html
            let tourPrice = parseInt(tour.getAttribute('data-price'));
            let tourDuration = parseInt(tour.getAttribute('data-duration'));
            
            let priceMatch = false;
            let durationMatch = false;

            // KIỂM TRA MỨC GIÁ
            if (selectedPrices.length === 0) {
                priceMatch = true; // Nếu không chọn ô giá nào thì cho qua
            } else {
                for (let p of selectedPrices) {
                    let [min, max] = p.split('-');
                    if (tourPrice >= parseInt(min) && tourPrice <= parseInt(max)) {
                        priceMatch = true; break;
                    }
                }
            }

            // KIỂM TRA SỐ NGÀY
            if (selectedDurations.length === 0) {
                durationMatch = true; // Nếu không chọn ô ngày nào thì cho qua
            } else {
                for (let d of selectedDurations) {
                    let [min, max] = d.split('-');
                    if (tourDuration >= parseInt(min) && tourDuration <= parseInt(max)) {
                        durationMatch = true; break;
                    }
                }
            }

            // XỬ LÝ HIỂN THỊ
            if (priceMatch && durationMatch) {
                tour.classList.remove('d-none');
                visibleCount++;
            } else {
                tour.classList.add('d-none');
            }
        });

        // Cập nhật con số hiển thị
        document.getElementById('tour-count').innerText = visibleCount;
        
        // Hiển thị thông báo nếu không có Tour nào
        const noResultMsg = document.getElementById('js-no-result');
        if(visibleCount === 0 && tours.length > 0) {
            noResultMsg.classList.remove('d-none');
        } else {
            noResultMsg.classList.add('d-none');
        }
    }

    // BẮT SỰ KIỆN KHI CHỌN SẮP XẾP GIÁ
    document.getElementById('sort-select').addEventListener('change', function() {
        let val = this.value;
        let container = document.getElementById('tour-list-container');
        // Lấy danh sách các thẻ hiện tại
        let cards = Array.from(document.querySelectorAll('.tour-card-wrapper'));
        
        if (val === 'price_asc') {
            cards.sort((a, b) => parseInt(a.dataset.price) - parseInt(b.dataset.price));
        } else if (val === 'price_desc') {
            cards.sort((a, b) => parseInt(b.dataset.price) - parseInt(a.dataset.price));
        }
        
        // Đảo lại thứ tự trong HTML
        cards.forEach(card => container.appendChild(card));
    });
</script>

<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header bg-light border-0" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold" style="color: var(--tvlk-blue);"><i class="bi bi-calendar-check me-2"></i>Chọn lịch trình
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <h5 id="tourName" class="mb-4 fw-bold text-dark" style="line-height: 1.4;"></h5>

                <form action="index.php" method="GET">
                    <input type="hidden" name="action" value="booking">
                    <input type="hidden" name="tour_id" id="tourId">

                    <label class="fw-bold mb-2" style="color: var(--tvlk-gray);"><i class="bi bi-calendar-event me-1"></i> Ngày khởi hành:</label>
                    <select name="departure_id" id="departureSelect" class="form-select form-select-lg mb-4"
                        style="border-radius: 12px; font-size: 1rem;" required>
                        <option value="">Đang tải dữ liệu...</option>
                    </select>

                    <?php if (isset($_SESSION['user'])): ?>
                        <button type="submit" class="btn w-100 py-3 fw-bold shadow-sm text-white"
                            style="border-radius: 12px; font-size: 1.1rem; background: var(--tvlk-orange);">
                            Xác nhận đặt tour
                        </button>
                    <?php else: ?>
                        <a href="index.php?action=login" class="btn w-100 py-3 fw-bold shadow-sm text-white"
                            style="border-radius: 12px; font-size: 1.1rem; background: var(--tvlk-blue);">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Đăng nhập để đặt tour
                        </a>
                        <p class="text-center small text-muted mt-2">Vui lòng đăng nhập để tiến hành đặt chỗ.</p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Logic của Modal giữ nguyên
    document.querySelectorAll('.btn-book-now').forEach(btn => {
        btn.addEventListener('click', function () {
            const tourId = this.dataset.id;
            const tourName = this.dataset.name;

            document.getElementById('tourId').value = tourId;
            document.getElementById('tourName').innerText = tourName;

            const select = document.getElementById('departureSelect');
            select.innerHTML = '<option value="">Đang tải dữ liệu...</option>';

            fetch(`index.php?action=getDepartures&tour_id=${tourId}`)
                .then(res => {
                    if (!res.ok) throw new Error('Phản hồi từ máy chủ không hợp lệ');
                    return res.json();
                })
                .then(data => {
                    let html = '';
                    if (!data || data.length === 0) {
                        html = '<option value="" disabled selected>Xin lỗi, hiện chưa có lịch mới!</option>';
                    } else {
                        html = '<option value="" disabled selected>-- Chọn ngày đi --</option>';
                        data.forEach(d => {
                            const dateFormatted = formatDate(d.start_date);
                            const isDisabled = d.available_seats <= 0 ? 'disabled' : '';
                            const seatText = d.available_seats > 0 ? `Còn ${d.available_seats} chỗ` : 'Hết chỗ';

                            html += `<option value="${d.departure_id}" ${isDisabled}>
                                        ${dateFormatted} (${seatText})
                                     </option>`;
                        });
                    }
                    select.innerHTML = html;
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    select.innerHTML = '<option value="" disabled>Lỗi kết nối. Vui lòng thử lại!</option>';
                });

            var myModal = new bootstrap.Modal(document.getElementById('bookingModal'));
            myModal.show();
        });
    });

    function formatDate(dateStr) {
        if (!dateStr) return '--/--/----';
        const d = new Date(dateStr);
        return d.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
    }
</script>

<?php include 'layouts/footer.php'; ?>
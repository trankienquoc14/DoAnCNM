<?php
// Kiểm tra an toàn: Nếu không có dữ liệu từ Controller truyền sang thì báo lỗi
if (empty($detail) || empty($departure)) {
    echo "<div class='container mt-5 text-center' style='min-height: 50vh;'>
            <h2 class='fw-bold text-muted'>Thông tin đặt tour không hợp lệ</h2>
            <p>Vui lòng chọn lại ngày khởi hành từ trang chi tiết tour.</p>
            <a href='index.php?action=tours' class='btn btn-primary mt-3'>Quay lại danh sách</a>
          </div>";
    exit;
}

// Tự động lấy thông tin user từ Session nếu đã đăng nhập
$userName = $_SESSION['user']['full_name'] ?? '';
$userEmail = $_SESSION['user']['email'] ?? '';
$userPhone = $_SESSION['user']['phone'] ?? '';
?>

<?php include 'layouts/header.php'; ?>

<style>
    :root {
        --primary-color: #0194f3;
        --accent-color: #ff5e1f;
        --text-main: #2c3e50;
        --bg-color: #f7f9fa;
        --border-color: #e1e8ee;
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    /* --- CHECKOUT CARD --- */
    .checkout-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        border: 1px solid var(--border-color);
        padding: 25px;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(1, 148, 243, 0.1);
    }

    /* --- CUSTOM PAYMENT METHOD UI --- */
    .payment-option {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 15px;
        background: white;
    }

    .payment-option:hover {
        border-color: #b3d4fc;
        background: #f8fbff;
    }

    .payment-option.active {
        border-color: var(--primary-color);
        background: #f0f7ff;
    }

    .payment-option input[type="radio"] {
        width: 20px;
        height: 20px;
        margin-right: 15px;
        accent-color: var(--primary-color);
        cursor: pointer;
    }

    .payment-icon {
        width: 40px;
        height: 40px;
        background: var(--bg-color);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--primary-color);
        margin-right: 15px;
    }

    .payment-text h6 {
        margin: 0;
        font-weight: 700;
        color: var(--text-main);
    }

    .payment-text p {
        margin: 0;
        font-size: 0.85rem;
        color: #687176;
    }

    /* --- SUMMARY CARD --- */
    .summary-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        overflow: hidden;
        position: sticky;
        top: 20px;
    }

    .summary-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .summary-body {
        padding: 20px;
    }

    .tour-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        color: #555;
        font-size: 0.95rem;
    }

    .summary-item strong {
        color: var(--text-main);
    }

    .total-price-box {
        background-color: #fff8f5;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
        border: 1px dashed #ffb499;
        text-align: right;
    }

    .total-amount {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--accent-color);
        line-height: 1;
        margin-top: 5px;
    }

    .btn-submit {
        background-color: var(--accent-color);
        color: white;
        font-weight: 700;
        border-radius: 8px;
        padding: 14px;
        font-size: 1.1rem;
        transition: 0.2s;
        border: none;
    }

    .btn-submit:hover {
        background-color: #e04d14;
        color: white;
        transform: translateY(-1px);
    }

    /* --- POLICY ALERT --- */
    .policy-alert {
        background-color: #e8f4fd;
        border-left: 4px solid var(--primary-color);
        padding: 15px;
        border-radius: 4px;
        font-size: 0.9rem;
        color: #034b7c;
        margin-bottom: 20px;
    }

    .policy-alert ul {
        margin: 0;
        padding-left: 20px;
        margin-top: 8px;
    }
</style>

<div class="container mt-4 mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Trang chủ</a></li>
            <li class="breadcrumb-item"><a
                    href="index.php?action=detail&slug=<?= $detail['slug'] ?? $detail['tour_id'] ?>"
                    class="text-decoration-none text-muted">Chi tiết tour</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">Đặt chỗ</li>
        </ol>
    </nav>

    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold text-dark mb-1">Xác nhận thông tin đặt chỗ</h2>
            <p class="text-muted">Chỉ mất 2 phút để hoàn tất hành trình của bạn.</p>
        </div>
    </div>

    <form action="index.php?action=confirmBooking" method="POST" id="bookingForm">
        <input type="hidden" name="tour_id" value="<?= $detail['tour_id']; ?>">
        <input type="hidden" name="departure_id" value="<?= $departure['departure_id']; ?>">

        <div class="row g-4">
            <div class="col-lg-7">

                <!-- THÔNG TIN LIÊN HỆ -->
                <div class="checkout-card">
                    <h4 class="section-title"><i class="bi bi-person-badge text-primary"></i> 1. Thông tin người liên hệ
                    </h4>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control"
                            value="<?= htmlspecialchars($userName) ?>" placeholder="Theo CMND/CCCD" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($userEmail) ?>" placeholder="Để nhận vé điện tử" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số điện thoại <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control"
                                value="<?= htmlspecialchars($userPhone) ?>" placeholder="Để HDV liên hệ" required>
                        </div>
                    </div>
                </div>

                <!-- HÀNH KHÁCH & GHI CHÚ -->
                <div class="checkout-card">
                    <h4 class="section-title"><i class="bi bi-people text-primary"></i> 2. Số lượng & Yêu cầu đặc biệt
                    </h4>
                    <div class="row align-items-center mb-4">
                        <div class="col-sm-5">
                            <label class="form-label fw-semibold mb-0">Số lượng hành khách <span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="col-sm-7">
                            <input type="number" id="people" name="people" class="form-control fw-bold" value="1"
                                min="1" max="<?= $departure['available_seats'] ?>" required>
                            <div class="form-text text-danger mt-1" style="font-size: 0.8rem;">
                                <i class="bi bi-exclamation-circle me-1"></i>Chuyến đi này còn tối đa
                                <strong><?= $departure['available_seats'] ?></strong> chỗ.
                            </div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">Yêu cầu khác (Tùy chọn)</label>
                        <textarea name="note" class="form-control" rows="2"
                            placeholder="Dị ứng thức ăn, người già, trẻ nhỏ..."></textarea>
                    </div>
                </div>

                <!-- KHỐI CHỌN ĐIỂM ĐÓN / ĐIỂM HẸN (ĐÃ NÂNG CẤP) -->
                <div class="checkout-card mb-4">
                    <h4 class="section-title"><i class="bi bi-geo-alt-fill text-primary"></i> 3. Hình thức di chuyển
                    </h4>

                    <!-- Lựa chọn 1: Tự đến điểm hẹn -->
                    <label class="payment-option active mb-3" id="lbl-meeting">
                        <input type="radio" name="pickup_type" value="meeting_point" checked onchange="togglePickup()">
                        <div class="payment-icon bg-light text-success"><i class="bi bi-building"></i></div>
                        <div class="payment-text">
                            <h6>Tự đến điểm hẹn tập trung</h6>
                            <p class="text-success mb-0" style="font-size: 0.85rem;">
                                <i class="bi bi-check-circle-fill me-1"></i>Đến điểm tập trung của Tour (Sân bay/Bến
                                xe/VP)
                                <br><span class="text-muted" style="font-size: 0.75rem; margin-left: 18px;">* HDV sẽ
                                    liên hệ báo giờ và địa điểm chính xác.</span>
                            </p>
                        </div>
                    </label>

                    <!-- Lựa chọn 2: Đón tại khách sạn -->
                    <label class="payment-option mb-3" id="lbl-hotel">
                        <input type="radio" name="pickup_type" value="hotel" onchange="togglePickup()">
                        <div class="payment-icon bg-light text-primary"><i class="bi bi-car-front-fill"></i></div>
                        <div class="payment-text w-100">
                            <h6>Xe đón tận nơi (Tại Khách sạn)</h6>
                            <p class="mb-2">Chỉ hỗ trợ đón miễn phí trong khu vực trung tâm.</p>
                        </div>
                    </label>

                    <!-- Lựa chọn 3: Khách tỉnh / Sân bay -->
                    <label class="payment-option mb-0" id="lbl-other">
                        <input type="radio" name="pickup_type" value="other" onchange="togglePickup()">
                        <div class="payment-icon bg-light text-warning"><i class="bi bi-airplane-fill"></i></div>
                        <div class="payment-text w-100">
                            <h6>Khách từ tỉnh khác (Sân bay/Bến xe)</h6>
                            <p class="mb-2">HDV sẽ gọi sắp xếp xe đón bạn (Có thể phát sinh phụ phí).</p>
                        </div>
                    </label>

                    <!-- Ô nhập liệu dùng chung (Sẽ đổi placeholder tùy theo lựa chọn) -->
                    <div id="dynamic-address-input"
                        style="display: none; margin-top: 15px; border-top: 1px dashed #ccc; padding-top: 15px;">
                        <label class="form-label fw-bold text-dark" id="address-label">Địa chỉ đón</label>
                        <input type="text" name="pickup_address" id="pickup_address" class="form-control border-primary"
                            placeholder="...">
                    </div>
                </div>

                <!-- CHÍNH SÁCH -->
                <div class="policy-alert shadow-sm">
                    <strong><i class="bi bi-shield-check me-1"></i> Chính sách An tâm đặt chỗ của TravelVN:</strong>
                    <ul>
                        <li>Hủy miễn phí trước <strong>03 ngày</strong> so với ngày khởi hành.</li>
                        <li>Được phép đổi lịch/chuyển nhượng cho người thân (Vui lòng báo trước 48h).</li>
                        <li>Giá trên web đã bao gồm thuế VAT và bảo hiểm du lịch cơ bản.</li>
                    </ul>
                </div>

                <!-- PHƯƠNG THỨC THANH TOÁN (UI MỚI) -->
                <div class="checkout-card">
                    <h4 class="section-title"><i class="bi bi-credit-card-2-front text-primary"></i> 4. Phương thức
                        thanh toán</h4>

                    <label class="payment-option active" id="lbl-cod">
                        <input type="radio" name="payment_method" value="cod" checked onchange="updatePaymentUI()">
                        <div class="payment-icon"><i class="bi bi-cash-stack"></i></div>
                        <div class="payment-text">
                            <h6>Thanh toán trực tiếp (COD)</h6>
                            <p>Trả tiền mặt tại văn phòng hoặc cho HDV trong ngày đi.</p>
                        </div>
                    </label>

                    <label class="payment-option" id="lbl-qr">
                        <input type="radio" name="payment_method" value="qr" onchange="updatePaymentUI()">
                        <div class="payment-icon"><i class="bi bi-qr-code-scan"></i></div>
                        <div class="payment-text">
                            <h6>Chuyển khoản QR (Khuyên dùng)</h6>
                            <p>Xác nhận vé ngay lập tức qua ứng dụng ngân hàng hoặc Momo/ZaloPay.</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- CỘT TỔNG KẾT BÊN PHẢI -->
            <div class="col-lg-5">
                <div class="summary-card">
                    <img src="<?= !empty($detail['image']) ? '../public/uploads/' . $detail['image'] : 'https://images.unsplash.com/photo-1501785888041-af3ef285b470' ?>"
                        class="summary-img" alt="Tour image">
                    <div class="summary-body">
                        <h4 class="tour-name"><?= htmlspecialchars($detail['tour_name']); ?></h4>

                        <div class="summary-item border-bottom pb-2">
                            <span>Mã chuyến đi:</span>
                            <strong
                                class="text-uppercase text-muted">DEP-<?= str_pad($departure['departure_id'], 4, '0', STR_PAD_LEFT) ?></strong>
                        </div>
                        <div class="summary-item border-bottom pb-2 mt-2">
                            <span>Ngày khởi hành:</span>
                            <strong
                                class="text-primary"><?= date("d/m/Y", strtotime($departure['start_date'])) ?></strong>
                        </div>
                        <div class="summary-item border-bottom pb-2 mt-2">
                            <span>Đơn giá:</span>
                            <strong><?= number_format($detail['price']); ?> đ</strong>
                        </div>
                        <div class="summary-item mt-2">
                            <span>Số lượng khách:</span>
                            <strong id="display-people">1 khách</strong>
                        </div>

                        <!-- Mã giảm giá giả lập UI cho đẹp -->
                        <div class="mt-3">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Nhập mã giảm giá..." disabled
                                    style="background: #f8f9fa;">
                                <button class="btn btn-outline-secondary" type="button" disabled>Áp dụng</button>
                            </div>
                        </div>

                        <div class="total-price-box shadow-sm">
                            <div class="text-muted fw-semibold mb-1">Tổng thanh toán</div>
                            <div class="total-amount" id="total"><?= number_format($detail['price']); ?> <span
                                    style="font-size: 1.2rem;">đ</span></div>
                        </div>

                        <button type="submit" class="btn btn-submit w-100 mt-4 shadow-sm" id="btnSubmitForm">
                            <i class="bi bi-bag-check me-1"></i> Xác nhận & Đặt ngay
                        </button>

                        <p class="text-center text-muted mt-3 mb-0" style="font-size: 0.8rem;">
                            Bằng việc bấm Đặt ngay, bạn đã đồng ý với các <a href="#" class="text-decoration-none">Điều
                                khoản dịch vụ</a> của chúng tôi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Logic tính tiền
    const pricePerPerson = <?= $detail['price']; ?>;
    const maxSeats = <?= $departure['available_seats']; ?>;

    const peopleInput = document.getElementById("people");
    const totalBox = document.getElementById("total");
    const displayPeople = document.getElementById("display-people");

    peopleInput.addEventListener("input", function () {
        let people = parseInt(this.value);

        if (isNaN(people) || people < 1) {
            people = 1;
        } else if (people > maxSeats) {
            alert("Rất tiếc, chuyến đi này chỉ còn tối đa " + maxSeats + " chỗ trống!");
            people = maxSeats;
            this.value = maxSeats;
        }

        displayPeople.innerHTML = people + " khách";
        let total = pricePerPerson * people;
        totalBox.innerHTML = total.toLocaleString('vi-VN') + ' <span style="font-size: 1.2rem;">đ</span>';
    });

    // Logic Đổi màu ô chọn Thanh toán
    function updatePaymentUI() {
        document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active'));

        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        document.getElementById('lbl-' + selectedMethod).classList.add('active');

        // Thay đổi text nút submit cho hợp lý
        const btnSubmit = document.getElementById('btnSubmitForm');
        if (selectedMethod === 'qr') {
            btnSubmit.innerHTML = '<i class="bi bi-qr-code me-1"></i> Đi tới quét mã QR';
        } else {
            btnSubmit.innerHTML = '<i class="bi bi-bag-check me-1"></i> Xác nhận & Đặt ngay';
        }
    }

    // Logic hiển thị/ẩn ô nhập tên Khách sạn hoặc Sân bay
    function togglePickup() {
        const type = document.querySelector('input[name="pickup_type"]:checked').value;
        const addressDiv = document.getElementById('dynamic-address-input');
        const addressInput = document.getElementById('pickup_address');
        const addressLabel = document.getElementById('address-label');

        // Bỏ màu viền của tất cả
        document.getElementById('lbl-meeting').classList.remove('active');
        document.getElementById('lbl-hotel').classList.remove('active');
        document.getElementById('lbl-other').classList.remove('active');

        if (type === 'hotel') {
            document.getElementById('lbl-hotel').classList.add('active');
            addressDiv.style.display = 'block';
            addressLabel.innerText = "Tên & Địa chỉ Khách sạn của bạn:";
            addressInput.placeholder = "VD: Khách sạn Marriott, Đường Hai Bà Trưng...";
            addressInput.setAttribute('required', 'required');

        } else if (type === 'other') {
            document.getElementById('lbl-other').classList.add('active');
            addressDiv.style.display = 'block';
            addressLabel.innerText = "Thông tin chuyến bay / Bến xe:";
            addressInput.placeholder = "VD: Bay Vietjet VN123 hạ cánh lúc 08h00, hoặc Bến xe trung tâm...";
            addressInput.setAttribute('required', 'required');

        } else {
            document.getElementById('lbl-meeting').classList.add('active');
            addressDiv.style.display = 'none';
            addressInput.removeAttribute('required');
        }
    }
</script>

<?php include 'layouts/footer.php'; ?>
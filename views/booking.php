<?php

require_once '../config/database.php';

$db = (new Database())->connect();

$tour_id = $_GET['tour_id'] ?? 0;
$departure_id = $_GET['departure_id'] ?? 0;

// 1. Lấy thông tin Tour
$stmtTour = $db->prepare("SELECT * FROM tours WHERE tour_id = ? AND status = 'active'");
$stmtTour->execute([$tour_id]);
$detail = $stmtTour->fetch(PDO::FETCH_ASSOC);

// 2. Lấy thông tin Lịch khởi hành
$stmtDep = $db->prepare("SELECT * FROM departures WHERE departure_id = ? AND tour_id = ?");
$stmtDep->execute([$departure_id, $tour_id]);
$departure = $stmtDep->fetch(PDO::FETCH_ASSOC);

// Nếu không hợp lệ, quay về trang chi tiết
if (!$detail || !$departure) {
    echo "<div class='container mt-5 text-center'>
            <h2 class='fw-bold mt-5 text-muted'>Thông tin đặt tour không hợp lệ</h2>
            <p>Vui lòng chọn lại ngày khởi hành từ trang chi tiết tour.</p>
            <a href='tour_detail.php?id={$tour_id}' class='btn btn-primary mt-3'>Quay lại</a>
          </div>";
    exit;
}

// Tự động lấy thông tin user nếu đã đăng nhập
$userName = $_SESSION['user']['name'] ?? '';
$userEmail = $_SESSION['user']['email'] ?? '';
$userPhone = $_SESSION['user']['phone'] ?? ''; // Giả sử có lưu phone trong session
?>

<?php include './layouts/header.php'; ?>

<style>
    :root {
        --primary-color: #0194f3;
        --accent-color: #ff5e1f;
        --text-main: #2c3e50;
    }

    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    /* --- FORM SECTION --- */
    .checkout-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        border: 1px solid #f0f0f0;
        padding: 30px;
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(1, 148, 243, 0.1);
    }

    /* --- SUMMARY SECTION --- */
    .summary-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
        overflow: hidden;
        position: sticky;
        top: 100px;
    }

    .summary-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .summary-body {
        padding: 25px;
    }

    .tour-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 15px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        color: #555;
    }

    .summary-item strong {
        color: var(--text-main);
    }

    .total-price-box {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        margin-top: 20px;
        text-align: right;
    }

    .total-label {
        color: #6c757d;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .total-amount {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--accent-color);
        line-height: 1;
    }

    .btn-submit {
        background-color: var(--accent-color);
        color: white;
        font-weight: 700;
        border-radius: 12px;
        padding: 14px;
        font-size: 1.2rem;
        transition: 0.3s;
        border: none;
    }

    .btn-submit:hover {
        background-color: #e04d14;
        transform: translateY(-2px);
        color: white;
    }
</style>

<div class="container mt-4 mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../public/index.php" class="text-decoration-none text-muted">Trang
                    chủ</a></li>
            <li class="breadcrumb-item"><a href="tour_detail.php?id=<?= $tour_id ?>"
                    class="text-decoration-none text-muted">Chi tiết tour</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">Xác nhận đặt chỗ</li>
        </ol>
    </nav>

    <h2 class="fw-bold mb-4 text-dark">Thanh toán & Đặt chỗ</h2>

    <form action="../controllers/process_booking.php" method="POST">
        <input type="hidden" name="tour_id" value="<?= $detail['tour_id']; ?>">
        <input type="hidden" name="departure_id" value="<?= $departure['departure_id']; ?>">
        

        <div class="row g-4">
            <div class="col-lg-7">

                <div class="checkout-card">
                    <h4 class="section-title"><i class="bi bi-person-lines-fill text-primary"></i> Thông tin liên hệ
                    </h4>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control"
                            value="<?= htmlspecialchars($userName) ?>" placeholder="Nhập họ tên đầy đủ" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($userEmail) ?>" placeholder="example@email.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số điện thoại <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control"
                                value="<?= htmlspecialchars($userPhone) ?>" placeholder="09xxxxxxx" required>
                        </div>
                    </div>
                </div>

                <div class="checkout-card">
                    <h4 class="section-title"><i class="bi bi-people-fill text-primary"></i> Hành khách</h4>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Số lượng người tham gia <span
                                class="text-danger">*</span></label>
                        <input type="number" id="people" name="people"
                            class="form-control form-control-lg text-center fw-bold" style="max-width: 150px;" value="1"
                            min="1" max="<?= $departure['available_seats'] ?>" required>
                        <div class="form-text text-danger mt-2">
                            <i class="bi bi-info-circle me-1"></i>Chuyến đi này hiện chỉ còn
                            <strong><?= $departure['available_seats'] ?></strong> chỗ trống.
                        </div>
                    </div>
                </div>

                <div class="checkout-card">
                    <h4 class="section-title"><i class="bi bi-pencil-square text-primary"></i> Yêu cầu đặc biệt</h4>
                    <textarea name="note" class="form-control" rows="3"
                        placeholder="Ví dụ: Dị ứng thức ăn, yêu cầu phòng đôi... (Tùy chọn)"></textarea>
                </div>
                <div class="checkout-card">
                    <h4 class="section-title">
                        <i class="bi bi-credit-card text-primary"></i> Phương thức thanh toán
                    </h4>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" value="cod" required>
                        <label class="form-check-label">
                            Thanh toán khi đi (COD)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="qr">
                        <label class="form-check-label">
                            Chuyển khoản QR
                        </label>
                    </div>
                </div>

            </div>

            <div class="col-lg-5">
                <div class="summary-card">
                    <img src="<?= !empty($detail['image']) ? '../public/uploads/' . $detail['image'] : 'https://images.unsplash.com/photo-1501785888041-af3ef285b470' ?>"
                        class="summary-img" alt="Tour image">

                    <div class="summary-body">
                        <h4 class="tour-name"><?= htmlspecialchars($detail['tour_name']); ?></h4>

                        <div class="summary-item border-bottom pb-2">
                            <span><i class="bi bi-geo-alt me-2"></i>Điểm đến:</span>
                            <strong><?= htmlspecialchars($detail['destination']); ?></strong>
                        </div>

                        <div class="summary-item border-bottom pb-2 mt-2">
                            <span><i class="bi bi-calendar-event me-2"></i>Khởi hành:</span>
                            <strong
                                class="text-primary"><?= date("d/m/Y", strtotime($departure['start_date'])) ?></strong>
                        </div>

                        <div class="summary-item border-bottom pb-2 mt-2">
                            <span><i class="bi bi-cash me-2"></i>Đơn giá:</span>
                            <strong><?= number_format($detail['price']); ?> đ/khách</strong>
                        </div>

                        <div class="summary-item mt-2">
                            <span><i class="bi bi-people me-2"></i>Số lượng:</span>
                            <strong id="display-people">1 khách</strong>
                        </div>

                        <div class="total-price-box">
                            <div class="total-label mb-1">Tổng thanh toán</div>
                            <div class="total-amount" id="total">
                                <?= number_format($detail['price']); ?> <span style="font-size: 1.2rem;">đ</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-submit w-100 mt-4 shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> Xác nhận & Thanh toán
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
    // Lấy giá trị cơ bản từ PHP
    const pricePerPerson = <?= $detail['price']; ?>;
    const maxSeats = <?= $departure['available_seats']; ?>;

    const peopleInput = document.getElementById("people");
    const totalBox = document.getElementById("total");
    const displayPeople = document.getElementById("display-people");

    peopleInput.addEventListener("input", function () {
        let people = parseInt(this.value);

        // Ràng buộc số lượng không được vượt quá số ghế hoặc nhỏ hơn 1
        if (isNaN(people) || people < 1) {
            people = 1;
        } else if (people > maxSeats) {
            alert("Rất tiếc, chuyến đi này chỉ còn " + maxSeats + " chỗ trống!");
            people = maxSeats;
            this.value = maxSeats;
        }

        // Cập nhật text số khách
        displayPeople.innerHTML = people + " khách";

        // Tính và format lại tổng tiền
        let total = pricePerPerson * people;
        totalBox.innerHTML = total.toLocaleString('vi-VN') + ' <span style="font-size: 1.2rem;">đ</span>';
    });
</script>

<?php include './layouts/footer.php'; ?>
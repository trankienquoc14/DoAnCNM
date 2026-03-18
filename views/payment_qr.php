<?php
require_once '../config/database.php';

$db = (new Database())->connect();

$payment_id = $_GET['payment_id'] ?? 0;

if (!$payment_id) {
    die("<div class='text-center mt-5'><h3>Thiếu thông tin thanh toán (payment_id)</h3></div>");
}

// Lấy trực tiếp customer_name từ bảng bookings như cấu trúc bạn vừa gửi
$stmt = $db->prepare("
    SELECT p.*, b.customer_name 
    FROM payments p
    JOIN bookings b ON p.booking_id = b.booking_id
    WHERE p.payment_id = ?
");

$stmt->execute([$payment_id]);
$payment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$payment) {
    die("<div class='text-center mt-5'><h3>Không tìm thấy giao dịch thanh toán</h3></div>");
}

// Thông tin tài khoản nhận tiền
$bank_id = "MB";
$account_no = "123456789";
$account_name = "CONG TY DU LICH TRAVELVN";
$amount = (int) $payment['amount'];
$info = "DAT TOUR " . $payment_id;

// Link tạo mã QR từ VietQR
$qr_url = "https://img.vietqr.io/image/{$bank_id}-{$account_no}-compact2.png?amount={$amount}&addInfo=" . urlencode($info) . "&accountName=" . urlencode($account_name);
?>

<?php include __DIR__ . "/layouts/header.php"; ?>

<style>
    :root {
        --primary-color: #0194f3;
        --accent-color: #ff5e1f;
        --success-color: #10b981;
        --text-main: #2c3e50;
    }

    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    .payment-container {
        max-width: 500px;
        margin: 40px auto;
    }

    .payment-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }

    .payment-header {
        background: linear-gradient(135deg, var(--primary-color), #00d2ff);
        color: white;
        padding: 25px 20px;
        text-align: center;
    }

    .payment-header h3 {
        margin: 0;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .payment-header p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .payment-body {
        padding: 30px;
    }

    .qr-wrapper {
        background: #f8f9fa;
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 15px;
        text-align: center;
        margin: 0 auto 25px;
        width: 250px;
        position: relative;
    }

    .qr-wrapper img {
        width: 100%;
        border-radius: 10px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #64748b;
        font-size: 0.95rem;
    }

    .info-value {
        font-weight: 700;
        color: var(--text-main);
        font-size: 1rem;
        text-align: right;
    }

    .info-value.amount {
        font-size: 1.3rem;
        color: var(--accent-color);
    }

    .btn-copy {
        background: none;
        border: none;
        color: var(--primary-color);
        cursor: pointer;
        padding: 0 0 0 8px;
        font-size: 1.1rem;
        transition: 0.2s;
    }

    .btn-copy:hover {
        color: var(--text-main);
    }

    .btn-confirm {
        background-color: var(--success-color);
        color: white;
        font-weight: 700;
        border-radius: 12px;
        padding: 14px;
        font-size: 1.1rem;
        width: 100%;
        border: none;
        transition: 0.3s;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .btn-confirm:hover {
        background-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .instruction {
        font-size: 0.9rem;
        color: #64748b;
        text-align: center;
        margin-top: 20px;
    }
</style>

<div class="container">
    <div class="payment-container">
        <div class="payment-card">

            <div class="payment-header">
                <h3>Thanh toán đơn hàng</h3>
                <p>Mã giao dịch: <strong>#<?= htmlspecialchars($payment['transaction_code'] ?? $payment_id) ?></strong>
                </p>
            </div>

            <div class="payment-body">

                <div class="text-center mb-3 fw-bold text-dark">
                    Quét mã QR bằng ứng dụng ngân hàng
                </div>
                <div class="qr-wrapper shadow-sm">
                    <img src="<?= $qr_url ?>" alt="QR Code Payment">
                </div>

                <div class="mb-4">
                    <div class="info-row">
                        <span class="info-label">Khách hàng</span>
                        <span class="info-value"><?= htmlspecialchars($payment['customer_name']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Ngân hàng</span>
                        <span class="info-value">MB Bank</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Số tài khoản</span>
                        <span class="info-value">
                            <span id="copy-account"><?= htmlspecialchars($account_no) ?></span>
                            <button class="btn-copy" onclick="copyText('copy-account')" title="Sao chép"><i
                                    class="bi bi-clipboard"></i></button>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Số tiền</span>
                        <span class="info-value amount">
                            <span id="copy-amount"><?= number_format($amount) ?></span> VNĐ
                            <button class="btn-copy" onclick="copyText('copy-amount', true)" title="Sao chép"><i
                                    class="bi bi-clipboard"></i></button>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nội dung</span>
                        <span class="info-value text-primary">
                            <span id="copy-info"><?= htmlspecialchars($info) ?></span>
                            <button class="btn-copy" onclick="copyText('copy-info')" title="Sao chép"><i
                                    class="bi bi-clipboard"></i></button>
                        </span>
                    </div>
                </div>

                <form method="POST" action="../controllers/confirm_payment.php">
                    <input type="hidden" name="payment_id" value="<?= $payment_id ?>">
                    <button type="submit" class="btn-confirm">
                        <i class="bi bi-check-circle-fill"></i> Tôi đã hoàn tất chuyển khoản
                    </button>
                </form>

                <p class="instruction">
                    <i class="bi bi-info-circle me-1"></i> Hệ thống sẽ tự động duyệt sau khi nhận được tiền (từ 1 - 5
                    phút).
                </p>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="my_booking.php" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> Quay
                lại danh sách đơn</a>
        </div>
    </div>
</div>

<script>
    function copyText(elementId, isAmount = false) {
        let textToCopy = document.getElementById(elementId).innerText;

        // Nếu là số tiền, loại bỏ dấu phẩy trước khi copy để dán vào app ngân hàng không bị lỗi
        if (isAmount) {
            textToCopy = textToCopy.replace(/,/g, '');
        }

        navigator.clipboard.writeText(textToCopy).then(() => {
            alert('Đã sao chép: ' + textToCopy);
        }).catch(err => {
            console.error('Lỗi sao chép: ', err);
        });
    }
</script>

<?php include __DIR__ . "/layouts/footer.php"; ?>
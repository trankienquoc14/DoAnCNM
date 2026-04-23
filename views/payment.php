<?php
// Kiểm tra nếu Controller chưa truyền dữ liệu sang thì báo lỗi
if (empty($payment)) {
    echo "<div class='text-center mt-5'><h3>Không tìm thấy giao dịch thanh toán</h3></div>";
    exit;
}
include 'layouts/header.php';
// Tính toán thời gian đếm ngược không bị reset khi reload
$payment_id = $payment['payment_id'] ?? $_GET['payment_id'] ?? 0;
?>

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
                        <span class="info-value">Sacombank</span>
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

                <div class="text-center mt-4 border-top pt-3">
                    <h5 class="text-danger fw-bold mb-3">
                        Vui lòng thanh toán trong: <span id="countdown-timer">15:00</span>
                    </h5>

                    <div id="payment-waiting" class="mb-3">
                        <div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-primary fw-bold">Hệ thống đang tự động chờ nhận tiền...</p>
                        <p class="text-muted small">Trang sẽ tự động chuyển hướng ngay khi nhận được thanh toán.</p>
                    </div>
                </div>

                <form method="POST" action="index.php?action=confirmPayment">
                    <!-- <input type="hidden" name="payment_id" value="<?= $payment_id ?>">
                    <button type="submit" class="btn-confirm bg-secondary"
                        onclick="return confirm('Bạn chắc chắn đã chuyển khoản thành công? Vui lòng chỉ bấm nút này nếu sau 5 phút hệ thống vẫn chưa tự động chuyển trang.');">
                        <i class="bi bi-check-circle-fill"></i> Tôi đã chuyển khoản (Báo cáo thủ công)
                    </button> -->
                </form>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="index.php?action=myBookings" class="text-decoration-none text-muted"><i
                    class="bi bi-arrow-left me-1"></i> Quay
                lại danh sách đơn</a>
        </div>
    </div>
</div>

<script>
    // 1. Hàm sao chép văn bản (Giữ nguyên logic của bạn)
    function copyText(elementId, isAmount = false) {
        let textToCopy = document.getElementById(elementId).innerText;
        if (isAmount) {
            textToCopy = textToCopy.replace(/,/g, '');
        }
        navigator.clipboard.writeText(textToCopy).then(() => {
            alert('Đã sao chép: ' + textToCopy);
        }).catch(err => {
            console.error('Lỗi sao chép: ', err);
        });
    }

    // --- ĐƯA CÁC LOGIC DƯỚI ĐÂY RA NGOÀI ĐỂ TỰ CHẠY KHI LOAD TRANG ---

    // 2. Lấy ID thanh toán từ PHP
    const currentPaymentId = <?= json_encode($payment_id) ?>;

    // 3. Hàm kiểm tra trạng thái tự động (Polling)
    function checkStatus() {
        fetch(`index.php?action=checkPaymentStatus&payment_id=${currentPaymentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'paid') {
                    // Xóa vòng lặp khi thành công
                    clearInterval(pollingInterval);
                    alert('Ting ting! Hệ thống đã nhận được thanh toán. Chúc bạn có chuyến đi vui vẻ!');
                    window.location.href = 'index.php?action=myBookings';
                }
            })
            .catch(error => console.log('Đang kết nối server...'));
    }

    // Thiết lập vòng lặp: Cứ mỗi 3 giây kiểm tra 1 lần
    const pollingInterval = setInterval(checkStatus, 3000);

    // --- 4. HÀM ĐẾM NGƯỢC THÔNG MINH (KHÔNG RESET KHI RELOAD) ---
    const STORAGE_KEY = `payment_expire_${currentPaymentId}`;
    let expireTime = localStorage.getItem(STORAGE_KEY);

    // Nếu chưa có thời gian hết hạn trong máy khách, thì mới tạo mới (15 phút từ bây giờ)
    if (!expireTime) {
        expireTime = Date.now() + (15 * 60 * 1000);
        localStorage.setItem(STORAGE_KEY, expireTime);
    }

    const timerDisplay = document.getElementById('countdown-timer');

    const countdown = setInterval(function () {
        let now = Date.now();
        let timeRemaining = Math.floor((expireTime - now) / 1000);

        if (timeRemaining <= 0) {
            clearInterval(countdown);
            clearInterval(pollingInterval);
            localStorage.removeItem(STORAGE_KEY); // Xóa bộ nhớ khi hết hạn
            alert('Đã hết thời gian thanh toán!');
            window.location.href = 'index.php?action=myBookings';
            return;
        }

        let minutes = Math.floor(timeRemaining / 60);
        let seconds = timeRemaining % 60;

        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        timerDisplay.textContent = minutes + ":" + seconds;
    }, 1000);

    // Xóa localStorage khi thanh toán thành công (Sửa trong hàm checkStatus)
    // Trong hàm checkStatus, chỗ data.status === 'paid', bạn thêm dòng:
    // localStorage.removeItem(STORAGE_KEY);
</script>

<?php include 'layouts/footer.php'; ?>
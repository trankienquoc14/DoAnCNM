<?php include __DIR__ . "/layouts/header.php"; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    html, body {
        height: 100%;
    }

    body {
        /* Thêm lớp phủ gradient đen mờ lên trên ảnh nền để form nổi bật hơn */
        background: linear-gradient(rgba(3, 18, 26, 0.3), rgba(3, 18, 26, 0.5)), 
                    url('uploads/login.jpg') center/cover no-repeat;
        font-family: 'Inter', sans-serif;
        display: flex;
        flex-direction: column;
    }

    .main-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-container {
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        padding: 40px 30px;
        border-radius: 20px; 
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2); 
        border: none;
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-icon {
        width: 65px;
        height: 65px;
        background: #eef7ff;
        color: #0194f3;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin: 0 auto 15px;
    }

    h2 {
       text-align: center;
        margin-bottom: 24px;
        font-weight: 600;
        color: #333;
    }

    .subtitle {
        color: #687176;
        font-size: 0.95rem;
        margin-top: 5px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    /* Bọc input để chứa icon bên trong */
    .input-group-custom {
        position: relative;
    }

    .input-group-custom i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aab2;
        font-size: 1.15rem;
        transition: 0.3s;
    }

    input {
        width: 100%;
        padding: 14px 16px 14px 45px; /* Chừa khoảng trống bên trái cho icon */
        border-radius: 12px; 
        border: 1px solid #e1e8ee;
        font-size: 1rem;
        color: #03121a;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    input::placeholder { color: #a0aab2; }

    /* Hiệu ứng khi focus vào ô nhập liệu */
    input:focus {
        outline: none;
        border-color: #0194f3;
        box-shadow: 0 0 0 4px rgba(1, 148, 243, 0.15);
    }

    /* Đổi màu icon khi input được focus */
    .input-group-custom:focus-within i {
        color: #0194f3;
    }

    button {
        padding: 14px;
        border-radius: 12px;
        background: #0194f3;
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 1.05rem;
        font-weight: 700;
        transition: 0.3s;
        margin-top: 10px;
    }

    button:hover {
        background: #0770cd;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(1, 148, 243, 0.3);
    }

    .register-link {
        text-align: center;
        margin-top: 25px;
        display: block;
        color: #687176;
        text-decoration: none;
        font-size: 0.95rem;
    }

    .register-link span {
        color: #0194f3;
        font-weight: 700;
    }

    .register-link:hover span {
        text-decoration: underline;
    }

    .error-msg {
        background: #fef2f2;
        color: #ef4444;
        border: 1px solid #fecaca;
        padding: 12px 15px;
        border-radius: 10px;
        font-size: 0.9rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
    }
</style>

<div class="main-content">
    <div class="login-container">
        
        <div class="login-header">
            <div class="login-icon"><i class="bi bi-person-fill"></i></div>
            <h2>Đăng nhập</h2>
            <div class="subtitle">Chào mừng bạn quay lại TravelVN</div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-msg">
                <i class="bi bi-exclamation-circle-fill"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?action=login">
            <div class="input-group-custom">
                <i class="bi bi-envelope"></i>
                <input type="email" name="email" placeholder="Email của bạn" required>
            </div>

            <div class="input-group-custom">
                <i class="bi bi-shield-lock"></i>
                <input type="password" name="password" placeholder="Mật khẩu" required>
            </div>

            <button type="submit">Đăng nhập ngay</button>
        </form>

        <a class="register-link" href="index.php?action=register">
            Chưa có tài khoản? <span>Đăng ký thành viên</span>
        </a>
    </div>
</div>

<?php include __DIR__ . "/layouts/footer.php"; ?>
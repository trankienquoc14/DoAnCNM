<?php include __DIR__ . "/layouts/header.php"; ?>

<style>
    /* --- BIẾN MÀU CHUNG --- */
    :root {
        --primary-color: #0194f3;
        --primary-hover: #007bb5;
        --bg-color: #f1f5f9;
        --text-main: #0f172a;
        --text-muted: #475569;
    }

    /* Đảm bảo chiều cao full màn hình để đẩy footer xuống đáy */
    html, body {
        height: 100%;
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Inter', 'Segoe UI', sans-serif;
        display: flex;
        flex-direction: column;
    }

    /* Phần bao bọc nội dung chính */
    .main-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    /* Khối Form Đăng nhập */
    .login-card {
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        padding: 40px 30px;
        border: 1px solid #e2e8f0;
    }

    /* Icon Avatar tròn ở trên cùng */
    .login-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary-color), #00d2ff);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 20px;
        box-shadow: 0 4px 10px rgba(1, 148, 243, 0.3);
    }

    /* Custom Input Group để Icon nằm trong ô input */
    .input-group-text {
        background-color: transparent;
        border-right: none;
        color: var(--text-muted);
        border-radius: 10px 0 0 10px;
    }
    
    .form-control {
        border-left: none;
        border-radius: 0 10px 10px 0;
        padding: 12px 15px 12px 0;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #dee2e6; 
    }

    /* Hiệu ứng viền xanh khi click vào ô input */
    .input-group:focus-within {
        box-shadow: 0 0 0 3px rgba(1, 148, 243, 0.15);
        border-radius: 10px;
    }
    
    .input-group:focus-within .input-group-text,
    .input-group:focus-within .form-control {
        border-color: var(--primary-color);
    }

    /* Nút đăng nhập */
    .btn-login {
        background-color: var(--primary-color);
        color: white;
        border-radius: 12px;
        padding: 12px;
        font-size: 1.1rem;
        transition: 0.3s;
    }

    .btn-login:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(1, 148, 243, 0.3);
        color: white;
    }
</style>

<div class="main-content">
    <div class="login-card">
        
        <div class="login-icon">
            <i class="bi bi-person-lock"></i>
        </div>
        <h3 class="text-center fw-bold mb-1" style="color: var(--text-main);">Đăng Nhập</h3>
        <p class="text-center mb-4" style="color: var(--text-muted);">Chào mừng bạn quay trở lại hệ thống!</p>

        <form method="POST" action="../controllers/AuthController.php">
            <input type="hidden" name="action" value="login">

            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Email của bạn" required>
            </div>

            <div class="input-group mb-4">
                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 px-1" style="font-size: 0.9rem;">
                <div class="form-check">
                    <input class="form-check-input shadow-sm" type="checkbox" id="rememberMe" style="cursor: pointer;">
                    <label class="form-check-label text-muted" for="rememberMe" style="cursor: pointer;">
                        Nhớ thiết bị
                    </label>
                </div>
                <a href="#" class="text-decoration-none fw-medium" style="color: var(--primary-color);">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="btn btn-login w-100 fw-bold mb-3">
                Đăng nhập ngay <i class="bi bi-box-arrow-in-right ms-1"></i>
            </button>
        </form>

        <div class="text-center mt-2">
            <span style="color: var(--text-muted);">Bạn chưa có tài khoản?</span> 
            <a href="register.php" class="fw-bold text-decoration-none ms-1" style="color: var(--primary-color);">Đăng ký</a>
        </div>
        
    </div>
</div>

<?php include __DIR__ . "/layouts/footer.php"; ?>
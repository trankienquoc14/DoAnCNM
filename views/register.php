<?php include __DIR__ . "/layouts/header.php"; ?>

<style>
    html,
    body {
        height: 100%;
    }

    body {
        /* Dùng chung ảnh nền với trang Login cho đồng bộ */
        background: url('uploads/login.jpg') center/cover no-repeat;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        flex-direction: column;
    }

    /* Giữ footer luôn ở dưới */
    .main-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px; 
    }

    .register-container {
        width: 100%;
        max-width: 420px; /* Nhỉnh hơn login một chút vì nhiều ô nhập liệu hơn */
        background: #fff;
        padding: 40px; 
        border-radius: 16px; 
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); 
        border: 1px solid #eee;
    }

    h2 {
        text-align: center;
        margin-bottom: 24px;
        font-weight: 600;
        color: #333;
    }

    h2 i {
        color: #007bff;
        margin-right: 10px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    input {
        padding: 12px; 
        border-radius: 8px; 
        border: 1px solid #ddd;
        transition: 0.3s; 
    }

    /* Hiệu ứng khi focus vào ô nhập liệu */
    input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    button {
        padding: 12px;
        border-radius: 8px;
        background: #007bff; /* Đổi màu xanh lá cũ sang xanh dương cho đồng bộ */
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: 0.3s;
        margin-top: 5px;
    }

    button:hover {
        background: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }

    .login-link {
        text-align: center;
        margin-top: 20px;
        display: block;
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .login-link:hover {
        text-decoration: underline;
    }
    
    .error-msg {
        color: #dc3545;
        text-align: center;
        font-size: 14px;
        margin-bottom: 15px;
        background: #f8d7da;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #f5c6cb;
    }
</style>

<div class="main-content">
    <div class="register-container">
        <h2><i class="bi bi-person-plus-fill"></i>Đăng ký tài khoản</h2>

        <?php if (!empty($error)): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?action=register">
            <input type="text" name="name" placeholder="Tên đầy đủ của bạn" required>
            <input type="email" name="email" placeholder="Email đăng nhập" required>
            <input type="text" name="phone" placeholder="Số điện thoại liên lạc" required>
            <input type="password" name="password" placeholder="Mật khẩu (ít nhất 6 ký tự)" required minlength="6">

            <button type="submit">Đăng ký ngay</button>
        </form>

        <a class="login-link" href="index.php?action=login">Đã có tài khoản? Đăng nhập tại đây</a>

    </div>
</div>

<?php include __DIR__ . "/layouts/footer.php"; ?>
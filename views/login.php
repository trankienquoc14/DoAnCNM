<?php include __DIR__ . "/layouts/header.php"; ?>

<style>
    html,
    body {
        height: 100%;
    }

    body {
        background: #f5f5f5;
        font-family: Arial;
        display: flex;
        flex-direction: column;
    }

    /* 🔥 giữ footer luôn ở dưới */
    .main-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-container {
        width: 100%;
        max-width: 400px;
        background: #fff;
        padding: 32px;
        border-radius: 8px;
        box-shadow: 0 2px 8px #ccc;
    }

    h2 {
        text-align: center;
        margin-bottom: 24px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    input {
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    button {
        padding: 10px;
        border-radius: 4px;
        background: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background: #0056b3;
    }

    .register-link {
        text-align: center;
        margin-top: 18px;
        display: block;
        color: #007bff;
        text-decoration: none;
    }

    .register-link:hover {
        text-decoration: underline;
    }

    .error-msg {
        color: #dc3545;
        text-align: center;
        font-size: 14px;
        margin-bottom: 10px;
        background: #f8d7da;
        padding: 8px;
        border-radius: 4px;
    }
</style>

<div class="main-content">
    <div class="login-container">
        <h2>Đăng nhập</h2>

        <?php if (!empty($error)): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?action=login">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>

            <button type="submit">Đăng nhập</button>
        </form>

        <a class="register-link" href="index.php?action=register">Chưa có tài khoản? Đăng ký</a>
    </div>
</div>

<?php include __DIR__ . "/layouts/footer.php"; ?>
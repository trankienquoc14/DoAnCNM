<?php include __DIR__ . "/layouts/header.php"; ?>
    <style>
        body {
            background: #f5f5f5;
            font-family: Arial;
        }

        .register-container {
            max-width: 400px;
            margin: 60px auto;
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
            background: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #218838;
        }

        .login-link {
            text-align: center;
            margin-top: 18px;
            display: block;
            color: #007bff;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h2>Đăng ký</h2>

        <form method="POST" action="../controllers/AuthController.php">

            <!-- QUAN TRỌNG -->
            <input type="hidden" name="action" value="register">

            <input type="text" name="name" placeholder="Tên đầy đủ" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>

            <button type="submit">Đăng ký</button>

        </form>

        <a class="login-link" href="login.php">Đã có tài khoản? Đăng nhập</a>

    </div>
</body>

<?php include __DIR__ . "/layouts/footer.php"; ?>
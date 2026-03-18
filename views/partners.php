<!DOCTYPE html>
<html>

<head>
    <title>Quản lý Đối tác</title>
    <style>
        body {
            background: #f5f5f5;
            font-family: Arial;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 2px 8px #ccc;
        }

        h2 {
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .form {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .form input {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .form button {
            padding: 8px 16px;
            border-radius: 4px;
            background: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .form button:hover {
            background: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Quản lý Đối tác</h2>
        <form class="form" method="POST" action="../controllers/PartnerController.php">
            <input type="hidden" name="action" value="create">
            <input type="text" name="partner_name" placeholder="Tên đối tác" required>
            <input type="text" name="contact_person" placeholder="Người liên hệ">
            <input type="text" name="phone" placeholder="Số điện thoại">
            <input type="email" name="email" placeholder="Email">
            <input type="text" name="address" placeholder="Địa chỉ">
            <button type="submit">Thêm đối tác</button>
        </form>
        <!-- Bảng danh sách đối tác sẽ được load bằng JS hoặc PHP -->
        <table>
            <tr>
                <th>Tên đối tác</th>
                <th>Người liên hệ</th>
                <th>Điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
            </tr>
            <!-- Dữ liệu đối tác -->
        </table>
    </div>
</body>

</html>
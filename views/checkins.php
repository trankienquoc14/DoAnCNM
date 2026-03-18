<!DOCTYPE html>
<html>

<head>
    <title>Check-in</title>
    <style>
        body {
            background: #f5f5f5;
            font-family: Arial;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 2px 8px #ccc;
        }

        h2 {
            margin-bottom: 24px;
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
    </style>
</head>

<body>
    <div class="container">
        <h2>Check-in</h2>
        <form class="form" method="POST" action="../controllers/CheckinController.php">
            <input type="hidden" name="action" value="create">
            <input type="number" name="booking_id" placeholder="ID Đơn đặt tour" required>
            <input type="number" name="staff_id" placeholder="ID Nhân viên" required>
            <button type="submit">Check-in</button>
        </form>
        <table>
            <tr>
                <th>ID Đơn đặt tour</th>
                <th>ID Nhân viên</th>
                <th>Thời gian check-in</th>
            </tr>
            <!-- Dữ liệu check-in -->
        </table>
    </div>
</body>

</html>
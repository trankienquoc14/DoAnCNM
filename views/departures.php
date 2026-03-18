<!DOCTYPE html>
<html>

<head>
    <title>Lịch khởi hành</title>
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
        <h2>Lịch khởi hành</h2>
        <form class="form" method="POST" action="../controllers/DepartureController.php">
            <input type="hidden" name="action" value="create">
            <input type="number" name="tour_id" placeholder="ID Tour" required>
            <input type="date" name="start_date" placeholder="Ngày bắt đầu" required>
            <input type="date" name="end_date" placeholder="Ngày kết thúc">
            <input type="number" name="max_seats" placeholder="Số chỗ tối đa">
            <input type="number" name="available_seats" placeholder="Số chỗ còn lại">
            <button type="submit">Thêm lịch khởi hành</button>
        </form>
        <table>
            <tr>
                <th>ID Tour</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Số chỗ tối đa</th>
                <th>Số chỗ còn lại</th>
            </tr>
            <!-- Dữ liệu lịch khởi hành -->
        </table>
    </div>
</body>

</html>
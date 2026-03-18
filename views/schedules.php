<!DOCTYPE html>
<html>

<head>
    <title>Lịch trình Tour</title>
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

        .form input,
        .form textarea {
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
        <h2>Lịch trình Tour</h2>
        <form class="form" method="POST" action="../controllers/TourScheduleController.php">
            <input type="hidden" name="action" value="create">
            <input type="number" name="tour_id" placeholder="ID Tour" required>
            <input type="number" name="day_number" placeholder="Ngày thứ" required>
            <input type="text" name="location" placeholder="Địa điểm">
            <textarea name="activity" placeholder="Hoạt động" rows="2"></textarea>
            <button type="submit">Thêm lịch trình</button>
        </form>
        <table>
            <tr>
                <th>ID Tour</th>
                <th>Ngày thứ</th>
                <th>Địa điểm</th>
                <th>Hoạt động</th>
            </tr>
            <!-- Dữ liệu lịch trình -->
        </table>
    </div>
</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <title>Đánh giá Tour</title>
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

        .review-list {
            margin-top: 24px;
        }

        .review-item {
            background: #fafafa;
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 1px 4px #ccc;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Đánh giá Tour</h2>
        <form class="form" method="POST" action="../controllers/ReviewController.php">
            <input type="hidden" name="action" value="create">
            <input type="number" name="tour_id" placeholder="ID Tour" required>
            <input type="number" name="user_id" placeholder="ID Người dùng" required>
            <input type="number" name="rating" min="1" max="5" placeholder="Điểm (1-5)" required>
            <textarea name="comment" placeholder="Nhận xét" rows="3"></textarea>
            <button type="submit">Gửi đánh giá</button>
        </form>
        <div class="review-list">
            <!-- Danh sách đánh giá -->
        </div>
    </div>
</body>

</html>
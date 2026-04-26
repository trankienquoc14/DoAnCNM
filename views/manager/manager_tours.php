<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    /* --- BIẾN MÀU & CẤU TRÚC CHUNG --- */
    :root {
        --admin-primary: #0194f3;
        --admin-primary-light: #eef7ff;
        --admin-success: #10b981;
        --admin-warning: #f59e0b;
        --admin-danger: #ef4444;
        --admin-bg: #f1f5f9; 
        --admin-surface: #ffffff;
        --admin-border: #e2e8f0;
        --admin-text-main: #0f172a; 
        --admin-text-muted: #475569; 
    }

    body {
        background-color: var(--admin-bg);
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    .admin-container {
        max-width: 1300px;
        margin: 40px auto;
        padding: 0 15px;
    }

    /* --- HEADER PHẢI --- */
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 30px;
    }

    .admin-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--admin-text-main);
        margin-bottom: 5px;
    }

    /* --- TÙY CHỈNH BẢNG (TABLE) --- */
    .admin-card {
        background: var(--admin-surface);
        border-radius: 20px;
        padding: 24px;
        border: 1px solid var(--admin-border);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    .table th {
        background-color: var(--admin-bg);
        color: var(--admin-text-muted);
        font-weight: 600;
        border-bottom-width: 1px;
        padding: 15px;
        white-space: nowrap;
    }
    
    .table td {
        padding: 15px;
        vertical-align: middle;
        color: var(--admin-text-main);
        border-bottom: 1px solid var(--admin-border);
    }

    .table-hover tbody tr:hover {
        background-color: var(--admin-primary-light);
    }
</style>

<div class="admin-container">
    <div class="row g-4">
        
        <?php 
            $activeMenu = 'tours'; 
            include __DIR__ . '/../layouts/sidebar_manager.php'; 
        ?>

        <div class="col-lg-9">
            
            <div class="admin-header">
                <div>
                    <h1 class="admin-title">Danh sách Tour</h1>
                    <p class="text-muted mb-0 fw-medium">Quản lý tất cả các tour du lịch hiện có trên hệ thống.</p>
                </div>
                <div>
                    <a href="../public/manager.php?action=createTour" class="btn btn-primary fw-bold shadow-sm rounded-pill px-4">
                        <i class="bi bi-plus-lg me-1"></i> Thêm Tour Mới
                    </a>
                </div>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center border-top-0">ID</th>
                                <th width="12%" class="text-center border-top-0">Hình ảnh</th>
                                <th width="25%" class="border-top-0">Tên Tour</th>
                                <th width="15%" class="border-top-0">Điểm đến</th>
                                <th width="15%" class="border-top-0">Giá (VNĐ)</th>
                                <th width="13%" class="border-top-0">Thời gian</th>
                                <th width="15%" class="text-center border-top-0">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($tours) && $tours->rowCount() > 0): ?>
                                <?php while ($row = $tours->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td class="text-center fw-bold text-muted">#<?= $row['tour_id'] ?></td>
                                        
                                        <td class="text-center">
                                            <?php 
                                                $imgSrc = !empty($row['image']) ? (strpos($row['image'], 'http') === 0 ? $row['image'] : '../public/uploads/' . $row['image']) : 'https://via.placeholder.com/150'; 
                                            ?>
                                            <img src="<?= $imgSrc ?>" alt="img" class="rounded border shadow-sm" style="width: 70px; height: 50px; object-fit: cover;">
                                        </td>

                                        <td>
                                            <div class="fw-bold" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="<?= htmlspecialchars($row['tour_name']) ?>">
                                                <?= htmlspecialchars($row['tour_name']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-primary border border-primary border-opacity-25 rounded-pill px-2 py-1">
                                                <i class="bi bi-geo-alt-fill me-1"></i><?= htmlspecialchars($row['destination']) ?>
                                            </span>
                                        </td>
                                        <td class="text-danger fw-bold"><?= number_format($row['price']) ?> đ</td>
                                        <td><?= htmlspecialchars($row['duration']) ?> ngày</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="../public/manager.php?action=editTour&id=<?= $row['tour_id'] ?>" class="btn btn-light border btn-sm text-warning" title="Sửa tour">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="../public/manager.php?action=deleteTour&id=<?= $row['tour_id'] ?>" class="btn btn-light border btn-sm text-danger" title="Xóa tour" onclick="return confirm('Bạn có chắc chắn muốn xóa tour này? Dữ liệu sẽ không thể khôi phục.')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Chưa có dữ liệu tour nào trên hệ thống.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
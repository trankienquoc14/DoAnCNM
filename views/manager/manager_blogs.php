<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4 mb-5">
    <div class="row g-4">
        <?php include __DIR__ . '/../layouts/sidebar_manager.php';  // Lưu ý: Chỉnh lại tên file sidebar của bạn cho đúng nhé ?>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark m-0"><i class="bi bi-journal-text text-primary me-2"></i>Quản lý Bài viết
                </h3>
                <a href="manager.php?action=blogForm" class="btn btn-primary fw-bold rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Thêm bài viết
                </a>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3" style="width: 80px;">ID</th>
                                <th class="py-3" style="width: 120px;">Hình ảnh</th>
                                <th class="py-3">Tiêu đề & Chuyên mục</th>
                                <th class="py-3">Ngày đăng</th>
                                <th class="px-4 py-3 text-end" style="width: 150px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($blogsList)): ?>
                                <?php foreach ($blogsList as $b): ?>
                                    <tr>
                                        <td class="px-4 fw-bold text-muted">#<?= $b['blog_id'] ?></td>
                                        <td>
                                            <?php
                                            // Nhận diện link ảnh hoặc file local
                                            $imgSrc = !empty($b['image']) ? (strpos($b['image'], 'http') === 0 ? $b['image'] : '../public/uploads/' . $b['image']) : 'https://via.placeholder.com/150';
                                            ?>
                                            <img src="<?= $imgSrc ?>" alt="img" class="rounded border shadow-sm"
                                                style="width: 90px; height: 65px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark mb-1"
                                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                <?= htmlspecialchars($b['title']) ?>
                                            </div>
                                            <span
                                                class="badge bg-light text-primary border border-primary border-opacity-25 rounded-pill px-3">
                                                <?= htmlspecialchars($b['category']) ?>
                                            </span>
                                        </td>
                                        <td class="text-muted fw-medium">
                                            <?= date('d/m/Y', strtotime($b['created_at'])) ?>
                                        </td>
                                        <td class="px-4 text-end">
                                            <a href="manager.php?action=blogForm&id=<?= $b['blog_id'] ?>"
                                                class="btn btn-sm btn-light border text-primary rounded-circle me-1"
                                                title="Sửa">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="manager.php?action=deleteBlog&id=<?= $b['blog_id'] ?>"
                                                class="btn btn-sm btn-light border text-danger rounded-circle" title="Xóa"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80"
                                            class="opacity-50 mb-3" alt="Empty">
                                        <h5 class="text-muted">Chưa có bài viết nào!</h5>
                                        <a href="manager.php?action=blogForm" class="btn btn-outline-primary mt-2">Tạo bài
                                            viết đầu tiên</a>
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
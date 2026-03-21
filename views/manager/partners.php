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

    /* --- HEADER PHẢI & BẢNG --- */
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
        $activeMenu = 'partners';
        include __DIR__ . '/../layouts/sidebar_manager.php';
        ?>

        <div class="col-lg-9">

            <div class="admin-header">
                <div>
                    <h1 class="admin-title">Đối Tác Dịch Vụ</h1>
                    <p class="text-muted mb-0 fw-medium">Quản lý danh sách các nhà cung cấp và đối tác vận hành tour.
                    </p>
                </div>
                <div>
                    <a href="manager.php?action=createPartner"
                        class="btn btn-primary fw-bold shadow-sm rounded-pill px-4">
                        <i class="bi bi-plus-lg me-1"></i> Thêm Đối Tác
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center border-top-0">ID</th>
                                <th width="25%" class="border-top-0">Tên Đối Tác</th>
                                <th width="20%" class="border-top-0">Người Liên Hệ</th>
                                <th width="20%" class="border-top-0">Thông Tin Liên Lạc</th>
                                <th width="20%" class="border-top-0">Địa Chỉ</th>
                                <th width="10%" class="text-center border-top-0">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($partners)): ?>
                                <?php foreach ($partners as $p): ?>
                                    <tr>
                                        <td class="text-center fw-bold text-muted">#<?= $p['partner_id'] ?></td>

                                        <td>
                                            <div class="fw-bold text-primary fs-6">
                                                <i class="bi bi-building-fill me-1 text-secondary"></i>
                                                <?= htmlspecialchars($p['partner_name']) ?>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="fw-medium text-dark">
                                                <i class="bi bi-person-badge text-warning me-1"></i>
                                                <?= htmlspecialchars($p['contact_person']) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center small fw-medium mb-1 text-dark text-nowrap">
                                                <i class="bi bi-telephone-fill text-success me-2"></i>
                                                <?= htmlspecialchars($p['phone']) ?>
                                            </div>

                                            <div class="d-flex align-items-center small text-muted text-nowrap">
                                                <i class="bi bi-envelope-fill text-danger me-2"></i>
                                                <span class="text-truncate" style="max-width: 150px;"
                                                    title="<?= htmlspecialchars($p['email']) ?>">
                                                    <?= htmlspecialchars($p['email']) ?>
                                                </span>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="small text-muted text-wrap" style="max-width: 200px;">
                                                <i class="bi bi-geo-alt-fill text-info me-1"></i>
                                                <?= htmlspecialchars($p['address']) ?>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="manager.php?action=editPartner&id=<?= $p['partner_id'] ?>"
                                                    class="btn btn-light border btn-sm text-warning" title="Sửa thông tin">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="manager.php?action=deletePartner&id=<?= $p['partner_id'] ?>"
                                                    class="btn btn-light border btn-sm text-danger" title="Xóa đối tác"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa đối tác này khỏi hệ thống?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-buildings fs-1 d-block mb-2 text-secondary"></i>
                                        <p class="fw-medium mb-0">Chưa có đối tác nào được thêm vào hệ thống.</p>
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
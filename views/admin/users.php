<?php include '../views/layouts/header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #858796;
    }
    body { background-color: #f8f9fc; color: #333; }
    .card { border: none; border-radius: 12px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
    .table thead th { 
        background-color: #f8f9fc; 
        text-transform: uppercase; 
        font-size: 0.8rem; 
        letter-spacing: 0.05rem;
        font-weight: 700;
        border-bottom: 2px solid #e3e6f0;
    }
    .table td { vertical-align: middle; border-color: #f1f1f1; }
    .badge { padding: 0.5em 0.8em; border-radius: 6px; font-weight: 500; }
    .btn-action { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; margin-right: 2px; }
    .user-avatar { width: 35px; height: 35px; background: #e3e6f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #4e73df; }
</style>

<div class="container py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Quản lý người dùng</h1>
        <a href="admin.php?action=create" class="btn btn-primary shadow-sm px-4 py-2">
            <i class="fas fa-plus fa-sm text-white-50 me-2"></i> Thêm người dùng mới
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Người dùng</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th class="text-end pe-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $roleColor = [
                            'admin' => 'danger',
                            'tour_manager' => 'primary',
                            'guide' => 'warning',
                            'customer' => 'secondary'
                        ];
                        foreach ($users as $u): 
                        ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        <?= strtoupper(substr($u['full_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($u['full_name']) ?></div>
                                        <small class="text-muted">ID: #<?= $u['user_id'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="text-muted"><?= $u['email'] ?></span></td>
                            <td>
                                <span class="badge bg-light text-<?= $roleColor[$u['role']] ?> border border-<?= $roleColor[$u['role']] ?>">
                                    <i class="fas fa-circle fa-xs me-1"></i>
                                    <?= strtoupper($u['role']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if($u['status'] == 'active'): ?>
                                    <span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i>Hoạt động</span>
                                <?php else: ?>
                                    <span class="text-danger small fw-bold"><i class="fas fa-ban me-1"></i>Đã khóa</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <a class="btn btn-light btn-action text-warning" href="admin.php?action=edit&id=<?= $u['user_id'] ?>" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-light btn-action text-info" href="admin.php?action=toggle&id=<?= $u['user_id'] ?>" title="Khóa/Mở">
                                    <i class="fas fa-lock"></i>
                                </a>
                                <a class="btn btn-light btn-action text-secondary" href="admin.php?action=reset&id=<?= $u['user_id'] ?>" title="Reset">
                                    <i class="fas fa-undo"></i>
                                </a>
                                <a class="btn btn-light btn-action text-danger" href="admin.php?action=delete&id=<?= $u['user_id'] ?>" 
                                   onclick="return confirm('Xác nhận xóa?')" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../views/layouts/footer.php'; ?>
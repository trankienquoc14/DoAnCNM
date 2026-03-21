<?php include '../views/layouts/header.php'; ?>

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

    /* Container trải rộng 1300px cho đồng bộ với hệ thống */
    .admin-container {
        max-width: 1300px; 
        margin: 50px auto;
        padding: 0 15px;
    }

    /* --- HEADER & CARD --- */
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 25px;
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
        padding: 40px; 
        border: 1px solid var(--admin-border);
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05); 
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px 15px; 
        border: 1px solid var(--admin-border);
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 3px rgba(1, 148, 243, 0.15);
        border-color: var(--admin-primary);
    }
</style>

<div class="admin-container">
            
    <div class="admin-header">
        <div>
            <h1 class="admin-title">Thêm Tài khoản Mới</h1>
            <p class="text-muted mb-0 fw-medium">Tạo người dùng mới và thiết lập quyền truy cập hệ thống.</p>
        </div>
        <div>
            <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-pill fw-bold shadow-sm px-4">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="admin-card">
        <form method="POST">
            
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold"><i class="bi bi-person-badge-fill text-primary me-1"></i> Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control fw-medium" name="full_name" placeholder="Ví dụ: Nguyễn Văn A" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold"><i class="bi bi-envelope-fill text-danger me-1"></i> Email liên hệ <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" placeholder="Ví dụ: email@domain.com" required>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold"><i class="bi bi-telephone-fill text-success me-1"></i> Số điện thoại</label>
                    <input type="text" class="form-control" name="phone" placeholder="Ví dụ: 0901234567">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold"><i class="bi bi-key-fill text-secondary me-1"></i> Mật khẩu đăng nhập <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu an toàn..." required>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label class="form-label fw-bold"><i class="bi bi-shield-lock-fill text-warning me-1"></i> Phân quyền (Role) <span class="text-danger">*</span></label>
                    <select class="form-select fw-bold text-dark" name="role" required>
                        <option value="customer">Khách hàng (Customer)</option>
                        <option value="guide">Hướng dẫn viên (Guide)</option>
                        <option value="manager">Quản lý (Manager)</option>
                        <option value="admin">Quản trị viên (Admin)</option>
                    </select>
                    <div class="form-text text-muted mt-2"><i class="bi bi-info-circle me-1"></i> Tài khoản sẽ được cấp quyền tương ứng ngay sau khi tạo.</div>
                </div>
            </div>

            <div class="d-flex justify-content-end border-top pt-4 mt-2 gap-2">
                <button type="reset" class="btn btn-light px-4 shadow-sm" style="border-radius: 10px;">
                    Làm mới
                </button>
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm" style="border-radius: 10px;">
                    <i class="bi bi-plus-lg me-1"></i> Tạo tài khoản
                </button>
            </div>

        </form>
    </div>

</div>

<?php include '../views/layouts/footer.php'; ?>
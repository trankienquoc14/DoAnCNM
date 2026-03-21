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

    /* --- HEADER PHẢI & CARD --- */
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
        padding: 30px;
        border: 1px solid var(--admin-border);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 15px;
        border: 1px solid var(--admin-border);
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(1, 148, 243, 0.15);
        border-color: var(--admin-primary);
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
                    <h1 class="admin-title">Cập nhật Đối Tác</h1>
                    <p class="text-muted mb-0 fw-medium">Chỉnh sửa thông tin liên hệ của nhà cung cấp #<?= htmlspecialchars($partner['partner_id']) ?>.</p>
                </div>
                <div>
                    <a href="manager.php?action=partners" class="btn btn-outline-secondary rounded-pill fw-bold shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <form method="POST" action="manager.php?action=updatePartner">
                    
                    <input type="hidden" name="partner_id" value="<?= htmlspecialchars($partner['partner_id']) ?>">

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-building-fill text-primary me-1"></i> Tên đối tác / Công ty <span class="text-danger">*</span></label>
                            <input class="form-control fw-medium" name="partner_name" value="<?= htmlspecialchars($partner['partner_name']) ?>" placeholder="Ví dụ: Công ty Du lịch Viettravel" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-person-badge text-warning me-1"></i> Người liên hệ</label>
                            <input class="form-control" name="contact_person" value="<?= htmlspecialchars($partner['contact_person']) ?>" placeholder="Ví dụ: Nguyễn Văn A">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-telephone-fill text-success me-1"></i> Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($partner['phone']) ?>" placeholder="Ví dụ: 0901234567" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-envelope-fill text-danger me-1"></i> Email</label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($partner['email']) ?>" placeholder="Ví dụ: contact@congty.com">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold"><i class="bi bi-geo-alt-fill text-info me-1"></i> Địa chỉ văn phòng</label>
                        <input class="form-control" name="address" value="<?= htmlspecialchars($partner['address']) ?>" placeholder="Nhập địa chỉ đầy đủ...">
                    </div>

                    <div class="d-flex justify-content-end border-top pt-4">
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                            <i class="bi bi-save me-1"></i> Lưu thay đổi
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
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

    .form-control, .form-select {
        border-radius: 10px;
        padding: 10px 15px;
        border: 1px solid var(--admin-border);
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 3px rgba(1, 148, 243, 0.15);
        border-color: var(--admin-primary);
    }

    .current-image-box {
        background: var(--admin-bg);
        padding: 15px;
        border-radius: 12px;
        border: 1px dashed #cbd5e1;
        display: inline-block;
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
                    <h1 class="admin-title">Cập nhật Tour</h1>
                    <p class="text-muted mb-0 fw-medium">Chỉnh sửa thông tin chi tiết tour #<?= htmlspecialchars($tour['tour_id']) ?>.</p>
                </div>
                <div>
                    <a href="../public/manager.php?action=tours" class="btn btn-outline-secondary rounded-pill fw-bold">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <form method="POST" action="../public/manager.php?action=updateTour" enctype="multipart/form-data">
                    
                    <input type="hidden" name="tour_id" value="<?= htmlspecialchars($tour['tour_id']) ?>">

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-map-fill text-primary me-1"></i> Tên tour <span class="text-danger">*</span></label>
                            <input class="form-control fw-medium" name="tour_name" value="<?= htmlspecialchars($tour['tour_name']) ?>" placeholder="Tên tour" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Điểm đến <span class="text-danger">*</span></label>
                            <input class="form-control" name="destination" value="<?= htmlspecialchars($tour['destination']) ?>" placeholder="Điểm đến" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-buildings-fill text-info me-1"></i> Chọn đối tác vận hành</label>
                            <select name="partner_id" class="form-select">
                                <option value="">-- Chọn đối tác --</option>
                                <?php foreach ($partners as $p): ?>
                                    <option value="<?= $p['partner_id'] ?>" <?= ($tour['partner_id'] == $p['partner_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($p['partner_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-house-door-fill text-warning me-1"></i> Tiêu chuẩn Khách sạn</label>
                            <input class="form-control" name="hotel" value="<?= htmlspecialchars($tour['hotel']) ?>" placeholder="VD: Khách sạn 3 sao, 4 sao...">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-cash-coin text-success me-1"></i> Giá tour (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control fw-bold text-danger" name="price" value="<?= $tour['price'] ?>" placeholder="VD: 2500000" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-clock-fill text-secondary me-1"></i> Thời gian (Số ngày) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="duration" value="<?= $tour['duration'] ?>" placeholder="VD: 3" min="1" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="bi bi-card-text text-primary me-1"></i> Mô tả ngắn</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Viết vài dòng giới thiệu hấp dẫn về tour..."><?= htmlspecialchars($tour['description']) ?></textarea>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-check-circle-fill text-success me-1"></i> Dịch vụ bao gồm</label>
                            <textarea class="form-control" name="include_service" rows="4" placeholder="VD: Xe đưa đón, vé tham quan..."><?= htmlspecialchars($tour['include_service']) ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-x-circle-fill text-danger me-1"></i> Dịch vụ không bao gồm</label>
                            <textarea class="form-control" name="exclude_service" rows="4" placeholder="VD: Thuế VAT, chi phí cá nhân..."><?= htmlspecialchars($tour['exclude_service']) ?></textarea>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="bi bi-list-task text-info me-1"></i> Lịch trình chi tiết</label>
                        <textarea class="form-control" name="itinerary" rows="6" placeholder="Chi tiết ngày 1, ngày 2..."><?= htmlspecialchars($tour['itinerary']) ?></textarea>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold d-block"><i class="bi bi-image text-primary me-1"></i> Ảnh đại diện Tour</label>
                        
                        <div class="current-image-box mb-3 shadow-sm">
                            <p class="text-muted small fw-bold mb-2">Ảnh đang sử dụng:</p>
                            <?php if (!empty($tour['image'])): ?>
                                <img src="../public/uploads/<?= htmlspecialchars($tour['image']) ?>" alt="Ảnh tour" class="img-thumbnail rounded-3 border-0 shadow-sm" style="max-height: 150px; object-fit: cover;">
                            <?php else: ?>
                                <span class="badge bg-secondary p-2"><i class="bi bi-image-alt me-1"></i> Chưa có ảnh</span>
                            <?php endif; ?>
                        </div>

                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text text-muted mt-2"><i class="bi bi-info-circle me-1"></i> Nếu bạn tải lên ảnh mới, ảnh cũ sẽ được thay thế. Kích thước khuyến nghị: Tối đa 2MB (JPG, PNG).</div>
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
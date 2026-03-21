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

    /* Tùy chỉnh ô select multiple để nhìn đẹp hơn */
    select[multiple] {
        height: auto;
        min-height: 120px;
        padding: 8px;
    }
    select[multiple] option {
        padding: 8px 12px;
        border-radius: 6px;
        margin-bottom: 2px;
    }
    select[multiple] option:checked {
        background-color: var(--admin-primary-light) !important;
        color: var(--admin-primary) !important;
        font-weight: bold;
    }
</style>

<div class="admin-container">
    <div class="row g-4">
        
        <?php 
            $activeMenu = 'departures'; 
            include __DIR__ . '/../layouts/sidebar_manager.php'; 
        ?>

        <div class="col-lg-9">
            
            <div class="admin-header">
                <div>
                    <h1 class="admin-title">Cập nhật Lịch Vận Hành</h1>
                    <p class="text-muted mb-0 fw-medium">Chỉnh sửa thông tin lịch trình #<?= htmlspecialchars($departure['departure_id']) ?>.</p>
                </div>
                <div>
                    <a href="../public/manager.php?action=departures" class="btn btn-outline-secondary rounded-pill fw-bold">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <form method="POST" action="manager.php?action=updateDeparture">
                    
                    <input type="hidden" name="departure_id" value="<?= htmlspecialchars($departure['departure_id']) ?>">

                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold"><i class="bi bi-map text-primary me-1"></i> Tour vận hành <span class="text-danger">*</span></label>
                            <select name="tour_id" class="form-select fw-medium" required>
                                <?php foreach ($tours as $t): ?>
                                    <option value="<?= $t['tour_id'] ?>" <?= ($t['tour_id'] == $departure['tour_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($t['tour_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold"><i class="bi bi-toggle-on text-secondary me-1"></i> Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="upcoming" <?= $departure['status'] == 'upcoming' ? 'selected' : '' ?>>Sắp tới (Upcoming)</option>
                                <option value="closed" <?= $departure['status'] == 'closed' ? 'selected' : '' ?>>Đã đóng (Closed)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-calendar-event text-success me-1"></i> Ngày bắt đầu <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" value="<?= htmlspecialchars($departure['start_date']) ?>" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-calendar-check text-danger me-1"></i> Ngày kết thúc <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" value="<?= htmlspecialchars($departure['end_date']) ?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-people-fill text-info me-1"></i> Số chỗ tối đa <span class="text-danger">*</span></label>
                            <input type="number" name="max_seats" value="<?= htmlspecialchars($departure['max_seats']) ?>" class="form-control" min="1" required>
                            <div class="form-text">Tổng số khách tối đa có thể tham gia chuyến đi này.</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-person-badge text-warning me-1"></i> Hướng dẫn viên phụ trách</label>
                            <select name="guides[]" class="form-select" multiple>
                                <?php if (!empty($guides)): ?>
                                    <?php foreach ($guides as $g): ?>
                                        <option value="<?= $g['user_id'] ?>" <?= (isset($selectedGuides) && in_array($g['user_id'], $selectedGuides)) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($g['full_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>Chưa có hướng dẫn viên nào</option>
                                <?php endif; ?>
                            </select>
                            <div class="form-text text-muted">
                                <i class="bi bi-info-circle"></i> Giữ phím <b>Ctrl</b> (Windows) hoặc <b>Cmd</b> (Mac) để chọn thêm hoặc bỏ chọn.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-4">
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-save me-1"></i> Lưu thay đổi
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
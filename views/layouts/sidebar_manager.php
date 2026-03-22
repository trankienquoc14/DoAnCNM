<style>
    /* --- CSS CHỈ DÀNH RIÊNG CHO SIDEBAR --- */
    .admin-sidebar {
        /* Dùng fallback color phòng trường hợp trang thiếu biến :root */
        background: var(--admin-surface, #ffffff);
        border-radius: 20px;
        border: 1px solid var(--admin-border, #e2e8f0);
        padding: 24px 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        height: 100%;
        z-index: 10;
    }

    .admin-profile {
        text-align: center;
        padding-bottom: 20px;
        border-bottom: 1px dashed var(--admin-border, #e2e8f0);
        margin-bottom: 20px;
    }

    .admin-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--admin-primary, #0194f3), #00d2ff);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 800;
        margin: 0 auto 15px;
        box-shadow: 0 4px 10px rgba(1, 148, 243, 0.3);
    }

    .admin-menu {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .admin-menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 12px;
        color: var(--admin-text-muted, #475569);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .admin-menu-item i {
        font-size: 1.25rem;
        transition: 0.2s;
    }

    .admin-menu-item:hover {
        background-color: var(--admin-bg, #f1f5f9);
        color: var(--admin-text-main, #0f172a);
    }

    .admin-menu-item.active {
        background-color: var(--admin-primary-light, #eef7ff);
        color: var(--admin-primary, #0194f3);
    }

    .admin-menu-item.active i {
        color: var(--admin-primary, #0194f3);
    }
</style>

<div class="col-lg-3">
    <div class="admin-sidebar sticky-top" style="top: 100px;">
        <div class="admin-profile">
            <div class="admin-avatar">
                <?= mb_strtoupper(mb_substr($userName ?? 'A', 0, 1, 'UTF-8')) ?>
            </div>
            <h5 class="fw-bold mb-1 text-dark">
                <?php
                // Ưu tiên 1: Biến truyền từ Controller
                // Ưu tiên 2: Tên từ Session (Tên thật của bạn)
                // Ưu tiên 3: Chữ mặc định
                echo htmlspecialchars($userName ?? $_SESSION['user']['full_name'] ?? 'Quản trị viên');
                ?>
            </h5>
            <span class="badge bg-light text-primary border border-primary">Admin System</span>
        </div>

        <div class="admin-menu">
            <?php $activeMenu = $activeMenu ?? 'dashboard'; // Mặc định là dashboard nếu không khai báo ?>

            <a href="../public/manager.php?action=dashboard"
                class="admin-menu-item <?= ($activeMenu === 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Tổng quan
            </a>
            <a href="../public/manager.php?action=tours"
                class="admin-menu-item <?= ($activeMenu === 'tours') ? 'active' : '' ?>">
                <i class="bi bi-map"></i> Quản lý Tour
            </a>
            <a href="../public/manager.php?action=departures"
                class="admin-menu-item <?= ($activeMenu === 'departures') ? 'active' : '' ?>">
                <i class="bi bi-calendar2-week"></i> Vận hành & Lịch trình
            </a>
            <a href="../public/manager.php?action=bookings"
                class="admin-menu-item <?= ($activeMenu === 'bookings') ? 'active' : '' ?>">
                <i class="bi bi-receipt-cutoff"></i> Đơn đặt (Bookings)
            </a>
            <a href="../public/manager.php?action=partners"
                class="admin-menu-item <?= ($activeMenu === 'partners') ? 'active' : '' ?>">
                <i class="bi bi-buildings"></i> Đối tác dịch vụ
            </a>
            <a href="../public/manager.php?action=report"
                class="admin-menu-item <?= ($activeMenu === 'report') ? 'active' : '' ?>">
                <i class="bi bi-graph-up-arrow"></i> Báo cáo doanh thu
            </a>
        </div>
    </div>
</div>
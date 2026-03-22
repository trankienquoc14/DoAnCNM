<?php include 'layouts/header.php'; ?>

<style>
    :root {
        --primary-color: #0194f3;
        --primary-hover: #007bc2;
        --text-dark: #1a202c;
        --text-muted: #64748b;
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
    }

    body {
        background-color: #f1f5f9;
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .user-sidebar-info { background: white; border-radius: 20px; padding: 30px 20px; text-align: center; border: 1px solid var(--border-color); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin-bottom: 20px; }
    .avatar-circle { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), #00d2ff); color: white; font-size: 2.2rem; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 4px 10px rgba(1, 148, 243, 0.3); }
    .user-sidebar-menu { background: white; border-radius: 20px; padding: 15px; border: 1px solid var(--border-color); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .menu-link { display: flex; align-items: center; gap: 12px; padding: 12px 20px; border-radius: 12px; color: var(--text-dark); font-weight: 600; text-decoration: none; transition: 0.2s; margin-bottom: 5px; }
    .menu-link i { font-size: 1.2rem; color: var(--text-muted); transition: 0.2s; }
    .menu-link:hover, .menu-link.active { background-color: #eef7ff; color: var(--primary-color); }
    .menu-link:hover i, .menu-link.active i { color: var(--primary-color); }
    .menu-link.text-danger:hover { background-color: #fef2f2; color: #dc2626; }
    .menu-link.text-danger:hover i { color: #dc2626; }

    .profile-card { background: white; border-radius: 20px; padding: 35px; border: 1px solid var(--border-color); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin-bottom: 25px; }
    .profile-card-title { font-size: 1.3rem; font-weight: 800; color: var(--text-dark); margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: 10px; }
    .form-control-custom { border-radius: 12px; padding: 14px 18px; border: 1px solid #cbd5e1; background-color: #f8fafc; transition: all 0.3s ease; font-weight: 500; color: var(--text-dark); }
    .form-control-custom:focus { background-color: white; border-color: var(--primary-color); box-shadow: 0 0 0 4px rgba(1, 148, 243, 0.15); outline: none; }
    .form-label { font-weight: 600; color: #475569; font-size: 0.95rem; margin-bottom: 8px; }
    .btn-save { background-color: var(--primary-color); color: white; padding: 14px 30px; border-radius: 12px; font-weight: 700; border: none; transition: 0.3s; box-shadow: 0 4px 10px rgba(1, 148, 243, 0.3); }
    .btn-save:hover { background-color: var(--primary-hover); transform: translateY(-2px); color: white; }
</style>

<div class="dashboard-container mt-5 mb-5 px-3">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="sticky-top" style="top: 100px; z-index: 1;">
                <div class="user-sidebar-info">
                    <div class="avatar-circle">
                        <?= mb_strtoupper(mb_substr($user_name, 0, 1, 'UTF-8')) ?>
                    </div>
                    <h5 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($user_name) ?></h5>
                    <p class="text-muted small mb-3"><?= htmlspecialchars($user_email) ?></p>
                    <span class="badge bg-light text-dark border"><i class="bi bi-shield-check text-success me-1"></i>Tài khoản xác thực</span>
                </div>

                <div class="user-sidebar-menu">
                    <a href="index.php?action=profile" class="menu-link active">
                        <i class="bi bi-person-circle"></i> Tài khoản của tôi
                    </a>
                    <a href="index.php?action=myBookings" class="menu-link">
                        <i class="bi bi-briefcase"></i> Chuyến đi của tôi
                        <?php if (isset($totalBookings) && $totalBookings > 0): ?>
                            <span class="badge bg-primary rounded-pill ms-auto"><?= $totalBookings ?></span>
                        <?php endif; ?>
                    </a>
                    <hr class="my-2" style="border-color: var(--border-color);">
                    <a href="index.php?action=logout" class="menu-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <h3 class="fw-bold text-dark mb-4">Cài đặt tài khoản</h3>

            <div class="profile-card">
                <h4 class="profile-card-title"><i class="bi bi-person-vcard text-primary"></i> Thông tin cá nhân</h4>
                
                <form action="index.php?action=updateProfile" method="POST">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" class="form-control form-control-custom" name="full_name" value="<?= htmlspecialchars($user_name) ?>" placeholder="Nhập họ và tên của bạn" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control form-control-custom" name="phone" value="<?= htmlspecialchars($user_phone) ?>" placeholder="Ví dụ: 0912345678">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Địa chỉ Email</label>
                            <input type="email" class="form-control form-control-custom" style="background-color: #e2e8f0; color: #64748b;" value="<?= htmlspecialchars($user_email) ?>" readonly>
                            <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle me-1"></i>Email dùng để đăng nhập nên không thể thay đổi.</small>
                        </div>
                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-save"><i class="bi bi-check-circle me-1"></i> Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="profile-card mt-4">
                <h4 class="profile-card-title"><i class="bi bi-shield-lock text-primary"></i> Đổi mật khẩu</h4>
                
                <form action="index.php?action=updatePassword" method="POST">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" name="old_password" class="form-control form-control-custom" placeholder="Nhập mật khẩu cũ" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="new_password" class="form-control form-control-custom" placeholder="Mật khẩu từ 6-20 ký tự" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" name="confirm_password" class="form-control form-control-custom" placeholder="Nhập lại mật khẩu mới" required>
                        </div>
                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-save" style="background-color: #10b981;"><i class="bi bi-key me-1"></i> Cập nhật mật khẩu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
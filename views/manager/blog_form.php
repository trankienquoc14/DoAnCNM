<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4 mb-5">
    <div class="row g-4">
        <?php include __DIR__ . '/../layouts/sidebar_manager.php'; // Đổi lại tên file cho đúng ?>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark m-0">
                    <i class="bi bi-<?= isset($blog) ? 'pencil-square' : 'plus-circle' ?> text-primary me-2"></i>
                    <?= isset($blog) ? 'Chỉnh sửa Cẩm nang' : 'Viết bài mới' ?>
                </h3>
                <a href="manager.php?action=blogs" class="btn btn-light border fw-bold rounded-pill px-4 shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5">
                <form action="manager.php?action=saveBlog" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="blog_id" value="<?= $blog['blog_id'] ?? 0 ?>">
                    <input type="hidden" name="old_image" value="<?= $blog['image'] ?? '' ?>">

                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-dark">Tiêu đề bài viết <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg" value="<?= htmlspecialchars($blog['title'] ?? '') ?>" required placeholder="VD: 10 địa điểm không thể bỏ lỡ tại Đà Lạt..." style="font-size: 1.1rem;">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Chuyên mục</label>
                            <select name="category" class="form-select form-select-lg">
                                <option value="Kinh nghiệm" <?= isset($blog) && $blog['category'] == 'Kinh nghiệm' ? 'selected' : '' ?>>Kinh nghiệm</option>
                                <option value="Ẩm thực" <?= isset($blog) && $blog['category'] == 'Ẩm thực' ? 'selected' : '' ?>>Ẩm thực</option>
                                <option value="Điểm đến" <?= isset($blog) && $blog['category'] == 'Điểm đến' ? 'selected' : '' ?>>Điểm đến</option>
                                <option value="Mẹo hay" <?= isset($blog) && $blog['category'] == 'Mẹo hay' ? 'selected' : '' ?>>Mẹo hay</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-dark">Ảnh bìa (Cover Image)</label>
                            <div class="input-group">
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            
                            <?php if(!empty($blog['image'])): ?>
                                <div class="mt-3 p-3 bg-light rounded-3 border d-inline-block">
                                    <span class="d-block mb-2 small fw-bold text-muted">Ảnh hiện tại:</span>
                                    <?php $imgSrc = (strpos($blog['image'], 'http') === 0) ? $blog['image'] : '../public/uploads/' . $blog['image']; ?>
                                    <img src="<?= $imgSrc ?>" height="120" class="rounded shadow-sm object-fit-cover">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-dark">Mô tả ngắn (Hiển thị ngoài trang chủ) <span class="text-danger">*</span></label>
                            <textarea name="short_desc" class="form-control" rows="3" required placeholder="Viết 1-2 câu tóm tắt nội dung để thu hút người đọc..."><?= htmlspecialchars($blog['short_desc'] ?? '') ?></textarea>
                            <div class="form-text mt-2">Nên viết khoảng 100 - 150 ký tự.</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-dark">Nội dung chi tiết (Hỗ trợ thẻ HTML)</label>
                            <textarea name="content" class="form-control" rows="15" placeholder="<p>Mở bài...</p> <h3>1. Heading</h3> <p>Nội dung đoạn văn...</p>"><?= htmlspecialchars($blog['content'] ?? '') ?></textarea>
                            <div class="form-text mt-2 text-primary"><i class="bi bi-info-circle me-1"></i>Bạn có thể sử dụng các thẻ HTML cơ bản như &lt;p&gt;, &lt;h3&gt;, &lt;b&gt;, &lt;ul&gt; &lt;li&gt; để định dạng bài viết đẹp hơn.</div>
                        </div>

                        <div class="col-12 border-top pt-4 mt-2 text-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold fs-5 shadow-sm">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i><?= isset($blog) ? 'Lưu thay đổi' : 'Đăng bài viết' ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
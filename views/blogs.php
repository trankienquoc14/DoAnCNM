<?php include __DIR__ . "/layouts/header.php"; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    :root {
        --tvlk-blue: #0194f3;
        --tvlk-orange: #ff5e1f;
        --tvlk-bg: #f7f9fa;
        --tvlk-text: #03121a;
        --tvlk-gray: #687176;
        --tvlk-border: #e1e8ee;
    }

    body {
        background-color: var(--tvlk-bg);
        font-family: 'Inter', sans-serif;
        color: var(--tvlk-text);
    }

    .page-header {
        background: white;
        padding: 40px 0;
        border-bottom: 1px solid var(--tvlk-border);
        margin-bottom: 40px;
        text-align: center;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--tvlk-text);
        margin-bottom: 10px;
    }

    .page-subtitle {
        color: var(--tvlk-gray);
        font-size: 1.1rem;
    }

    /* --- CẨM NANG DU LỊCH --- */
    .blog-card {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--tvlk-border);
        overflow: hidden;
        transition: 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        text-decoration: none;
        color: var(--tvlk-text);
    }

    .blog-card:hover {
        box-shadow: 0 8px 24px rgba(3, 18, 26, 0.08);
        transform: translateY(-4px);
    }

    .blog-img {
        height: 200px;
        position: relative;
    }

    .blog-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .blog-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(1, 148, 243, 0.9);
        color: white;
        backdrop-filter: blur(4px);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .blog-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .blog-date {
        font-size: 0.85rem;
        color: var(--tvlk-gray);
        margin-bottom: 10px;
        font-weight: 600;
    }

    .blog-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--tvlk-text);
        line-height: 1.4;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .blog-desc {
        font-size: 0.95rem;
        color: var(--tvlk-gray);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .blog-readmore {
        margin-top: auto;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--tvlk-orange);
        display: flex;
        align-items: center;
        gap: 5px;
    }
</style>

<div class="page-header">
    <div class="container">
        <h1 class="page-title">Cẩm Nang Du Lịch</h1>
        <p class="page-subtitle">Khám phá các bí kíp, mẹo vặt và kinh nghiệm xê dịch tuyệt vời nhất từ TravelVN.</p>
    </div>
</div>

<div class="container mb-5 pb-5">
    <div class="row g-4">
        <?php if (!empty($blogsList)): ?>
            <?php foreach ($blogsList as $blog): ?>
                <div class="col-lg-4 col-md-6">
                    <a href="index.php?action=blogDetail&slug=<?= $blog['slug'] ?>" class="blog-card">
                        <div class="blog-img">
                            <span class="blog-badge"><?= htmlspecialchars($blog['category'] ?? 'Khám phá') ?></span>
                            <?php
                            // Xử lý link ảnh (nếu là link web thì giữ nguyên, nếu là file thì thêm folder uploads)
                            $imgSrc = !empty($blog['image']) ? (strpos($blog['image'], 'http') === 0 ? $blog['image'] : '../public/uploads/' . $blog['image']) : 'https://images.unsplash.com/photo-1542640244-7e672d6cb466?auto=format&fit=crop&w=600&q=80';
                            ?>
                            <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($blog['title']) ?>">
                        </div>
                        <div class="blog-body">
                            <span class="blog-date"><i class="bi bi-calendar3 me-1 text-primary"></i>
                                <?= date('d/m/Y', strtotime($blog['created_at'])) ?></span>
                            <h5 class="blog-title"><?= htmlspecialchars($blog['title']) ?></h5>
                            <p class="blog-desc"><?= htmlspecialchars($blog['short_desc'] ?? 'Đang cập nhật nội dung...') ?></p>
                            <span class="blog-readmore">Đọc tiếp <i class="bi bi-arrow-right"></i></span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-journal-x text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 text-muted">Chưa có bài viết nào</h4>
                <p>Hệ thống đang cập nhật các bài cẩm nang mới nhất.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . "/layouts/footer.php"; ?>
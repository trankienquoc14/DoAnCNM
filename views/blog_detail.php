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

    /* --- BREADCRUMB --- */
    .blog-breadcrumb {
        padding: 20px 0;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--tvlk-gray);
    }
    .blog-breadcrumb a {
        color: var(--tvlk-blue);
        text-decoration: none;
    }
    .blog-breadcrumb a:hover { text-decoration: underline; }
    .blog-breadcrumb i { margin: 0 8px; font-size: 0.8rem; }

    /* --- KHU VỰC NỘI DUNG CHÍNH --- */
    .blog-main-content {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid var(--tvlk-border);
        margin-bottom: 40px;
    }

    .blog-category-badge {
        display: inline-block;
        background: rgba(1, 148, 243, 0.1);
        color: var(--tvlk-blue);
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .blog-title {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.3;
        color: var(--tvlk-text);
        margin-bottom: 20px;
    }

    .blog-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        color: var(--tvlk-gray);
        font-size: 0.95rem;
        font-weight: 500;
        padding-bottom: 25px;
        border-bottom: 1px solid var(--tvlk-border);
        margin-bottom: 30px;
    }

    .blog-cover-img {
        width: 100%;
        max-height: 450px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 35px;
    }

    /* Định dạng cho nội dung bài viết HTML từ Database */
    .blog-body-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }
    .blog-body-text p { margin-bottom: 20px; }
    .blog-body-text h2, .blog-body-text h3, .blog-body-text h4 {
        font-weight: 700;
        color: var(--tvlk-text);
        margin-top: 35px;
        margin-bottom: 15px;
    }
    .blog-body-text img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 20px 0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .blog-body-text ul, .blog-body-text ol {
        margin-bottom: 20px;
        padding-left: 20px;
    }
    .blog-body-text li { margin-bottom: 10px; }

    /* --- SIDEBAR --- */
    .sidebar-widget {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid var(--tvlk-border);
        margin-bottom: 25px;
        position: sticky;
        top: 20px;
    }

    .widget-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--tvlk-text);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--tvlk-bg);
    }

    .related-post-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        text-decoration: none;
        color: var(--tvlk-text);
        transition: 0.2s;
    }
    .related-post-item:hover .related-post-title { color: var(--tvlk-blue); }
    .related-post-item:last-child { margin-bottom: 0; }
    
    .related-post-img {
        width: 90px;
        height: 70px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }
    
    .related-post-info { display: flex; flex-direction: column; justify-content: space-between; }
    .related-post-title {
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.4;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        transition: 0.2s;
    }
    .related-post-date { font-size: 0.75rem; color: var(--tvlk-gray); font-weight: 500;}

    /* Chia sẻ mạng xã hội */
    .share-buttons { display: flex; gap: 10px; margin-top: 40px; padding-top: 30px; border-top: 1px solid var(--tvlk-border); }
    .btn-share {
        padding: 8px 20px; border-radius: 50px; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;
        text-decoration: none; transition: 0.2s;
    }
    .share-fb { background: #e8f0fe; color: #1877f2; }
    .share-fb:hover { background: #1877f2; color: white; }
    .share-link { background: var(--tvlk-bg); color: var(--tvlk-text); }
    .share-link:hover { background: var(--tvlk-border); }
</style>

<div class="container">
    <div class="blog-breadcrumb">
        <a href="index.php">Trang chủ</a> <i class="bi bi-chevron-right"></i>
        <a href="index.php?action=blogs">Cẩm nang du lịch</a> <i class="bi bi-chevron-right"></i>
        <span class="text-dark fw-bold"><?= htmlspecialchars($blog['category']) ?></span>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <article class="blog-main-content">
                <span class="blog-category-badge"><?= htmlspecialchars($blog['category']) ?></span>
                
                <h1 class="blog-title"><?= htmlspecialchars($blog['title']) ?></h1>
                
                <div class="blog-meta">
                    <span><i class="bi bi-calendar3 me-2 text-primary"></i> Đăng ngày: <?= date('d/m/Y', strtotime($blog['created_at'])) ?></span>
                    <span><i class="bi bi-person-circle me-2 text-primary"></i> Viết bởi: Ban Biên Tập TravelVN</span>
                </div>

                <?php 
                    $coverImg = !empty($blog['image']) ? (strpos($blog['image'], 'http') === 0 ? $blog['image'] : '../public/uploads/' . $blog['image']) : 'https://images.unsplash.com/photo-1542640244-7e672d6cb466?auto=format&fit=crop&w=1200&q=80';
                ?>
                <img src="<?= $coverImg ?>" alt="Cover" class="blog-cover-img">

                <div class="blog-body-text">
                    <?php 
                        if (!empty($blog['content'])) {
                            echo $blog['content']; 
                        } else {
                            echo "<p>" . nl2br(htmlspecialchars($blog['short_desc'])) . "</p>";
                            echo "<p class='text-muted mt-5'><em>Nội dung chi tiết đang được ban biên tập cập nhật...</em></p>";
                        }
                    ?>
                </div>

                <div class="share-buttons">
                    <span class="fw-bold d-flex align-items-center me-2">Chia sẻ bài viết:</span>
                    <a href="#" class="btn-share share-fb"><i class="bi bi-facebook"></i> Facebook</a>
                    <a href="#" class="btn-share share-link" onclick="navigator.clipboard.writeText(window.location.href); alert('Đã copy link!');"><i class="bi bi-link-45deg"></i> Copy Link</a>
                </div>
            </article>
        </div>

        <div class="col-lg-4">
            
            <div class="sidebar-widget text-center" style="background: linear-gradient(135deg, var(--tvlk-blue), #00d2ff); color: white; border: none;">
                <h4 class="fw-bold mb-3">Bạn đã sẵn sàng cho chuyến đi?</h4>
                <p class="mb-4 opacity-75" style="font-size: 0.9rem;">Khám phá các tour du lịch trọn gói với giá tốt nhất hôm nay cùng TravelVN.</p>
                <a href="index.php?action=tours" class="btn w-100 fw-bold" style="background: var(--tvlk-orange); color: white; padding: 12px; border-radius: 8px;">Tìm Tour Ngay <i class="bi bi-arrow-right ms-1"></i></a>
            </div>

            <div class="sidebar-widget">
                <h3 class="widget-title">Có thể bạn quan tâm</h3>
                
                <?php if (!empty($relatedBlogs)): ?>
                    <?php foreach ($relatedBlogs as $rb): ?>
                        <a href="index.php?action=blogDetail&id=<?= $rb['blog_id'] ?>" class="related-post-item">
                            <?php 
                                $thumbImg = !empty($rb['image']) ? (strpos($rb['image'], 'http') === 0 ? $rb['image'] : '../public/uploads/' . $rb['image']) : 'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?auto=format&fit=crop&w=300&q=80';
                            ?>
                            <img src="<?= $thumbImg ?>" class="related-post-img" alt="Thumb">
                            <div class="related-post-info">
                                <h4 class="related-post-title"><?= htmlspecialchars($rb['title']) ?></h4>
                                <span class="related-post-date"><?= date('d/m/Y', strtotime($rb['created_at'])) ?></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted small">Chưa có bài viết liên quan.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . "/layouts/footer.php"; ?>
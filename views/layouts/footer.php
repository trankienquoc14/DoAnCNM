</div> <style>
    /* --- PREMIUM FOOTER --- */
    .footer-custom {
        background-color: #ceefff; /* Nền xám rất nhạt, sang trọng */
        border-top: 1px solid #e2e8f0;
        color: #475569;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        margin-top: 60px; /* Cách nội dung bên trên ra một khoảng */
    }

    .footer-top {
        padding: 60px 0 40px;
    }

    .footer-brand {
        font-size: 1.8rem;
        font-weight: 800;
        color: #0194f3;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .footer-title {
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 20px;
        font-size: 1.15rem;
    }

    .footer-links, .footer-contact {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li, .footer-contact li {
        margin-bottom: 15px;
    }

    .footer-links a {
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .footer-links a:hover {
        color: #0194f3;
        transform: translateX(5px); /* Hiệu ứng mũi tên đẩy nhẹ chữ sang phải */
    }

    .footer-contact li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        line-height: 1.6;
    }

    .footer-contact i {
        color: #0194f3;
        font-size: 1.2rem;
        margin-top: 2px;
    }

    /* Social Icons */
    .social-links {
        display: flex;
        gap: 12px;
        margin-top: 25px;
    }

    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e2e8f0;
        color: #475569;
        text-decoration: none;
        transition: 0.3s;
        font-size: 1.1rem;
    }

    .social-icon:hover {
        background-color: #0194f3;
        color: white;
        transform: translateY(-4px); /* Nhảy lên khi hover */
        box-shadow: 0 4px 10px rgba(1, 148, 243, 0.3);
    }

    /* Footer Bottom */
    .footer-bottom {
        background-color: #e2f8ff;
        padding: 20px 0;
        font-size: 0.95rem;
        border-top: 1px solid #e2e8f0;
    }

    .payment-methods {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .payment-methods i {
        font-size: 1.8rem;
        color: #94a3b8;
        transition: 0.3s;
    }

    .payment-methods i:hover { color: #0194f3; }
</style>

<footer class="footer-custom">
    <div class="footer-top">
        <div class="container">
            <div class="row g-5">
                
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <i class="bi bi-globe-americas"></i> TravelVN
                    </div>
                    <p class="text-muted pe-lg-4" style="line-height: 1.7;">
                        TravelVN tự hào là nền tảng đặt tour du lịch hàng đầu, mang đến cho bạn những trải nghiệm khám phá thế giới tuyệt vời với chi phí tối ưu và dịch vụ tận tâm nhất.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-icon" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon" title="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="social-icon" title="TikTok"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Về TravelVN</h5>
                    <ul class="footer-links">
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Tuyển dụng</a></li>
                        <li><a href="#">Tin tức du lịch</a></li>
                        <li><a href="#">Chương trình đại lý</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Hỗ trợ khách hàng</h5>
                    <ul class="footer-links">
                        <li><a href="#">Hướng dẫn đặt tour</a></li>
                        <li><a href="#">Câu hỏi thường gặp (FAQ)</a></li>
                        <li><a href="#">Chính sách hoàn/hủy</a></li>
                        <li><a href="#">Quy chế hoạt động</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Thông tin liên hệ</h5>
                    <ul class="footer-contact">
                        <li>
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>Tòa nhà TravelVN, 123 Đường Du Lịch, Quận 1, TP.HCM</span>
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill"></i>
                            <span>Hotline: <strong>1900 1234</strong><br><small>(Hỗ trợ 24/7)</small></span>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i>
                            <span>support@travelvn.com</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <p class="mb-3 mb-md-0 fw-medium">© 2026 TravelVN. Đã đăng ký bản quyền.</p>
            <div class="payment-methods">
                <i class="bi bi-credit-card-fill" title="Thẻ tín dụng"></i>
                <i class="bi bi-cash-coin" title="Tiền mặt"></i>
                <i class="bi bi-qr-code-scan" title="Quét mã QR"></i>
                <i class="bi bi-wallet-fill" title="Ví điện tử"></i>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
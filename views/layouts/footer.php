</div>
<style>
    /* --- PREMIUM FOOTER --- */
    .footer-custom {
        background-color: #ceefff;
        border-top: 1px solid #e2e8f0;
        color: #475569;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        margin-top: 60px;
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

    .footer-links,
    .footer-contact {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li,
    .footer-contact li {
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
        transform: translateX(5px);
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
        transform: translateY(-4px);
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

    .payment-methods i:hover {
        color: #0194f3;
    }

    /* ================= CSS KHUNG CHAT ================= */
    .chat-widget {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 1050;
    }

    .chat-button {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0194f3, #00d2ff);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(1, 148, 243, 0.4);
        font-size: 26px;
        cursor: pointer;
        transition: transform 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-button:hover {
        transform: scale(1.1);
    }

    .chat-panel {
        display: none;
        width: 340px;
        height: 450px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        flex-direction: column;
        position: absolute;
        bottom: 75px;
        right: 0;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .chat-header {
        background: #0194f3;
        color: white;
        padding: 16px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-body {
        flex: 1;
        padding: 16px;
        overflow-y: auto;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .chat-footer {
        padding: 12px;
        border-top: 1px solid #e2e8f0;
        background: white;
    }

    .chat-footer form {
        display: flex;
        gap: 8px;
        margin: 0;
    }

    .chat-input {
        flex: 1;
        border: 1px solid #cbd5e1;
        border-radius: 20px;
        padding: 10px 16px;
        outline: none;
        transition: border-color 0.2s;
    }

    .chat-input:focus {
        border-color: #0194f3;
    }

    .chat-submit {
        background: #0194f3;
        color: white;
        border: none;
        border-radius: 50%;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .msg-bubble {
        max-width: 80%;
        padding: 10px 14px;
        border-radius: 16px;
        font-size: 0.95rem;
        line-height: 1.4;
        word-wrap: break-word;
    }

    .msg-customer {
        background: #0194f3;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }

    .msg-admin {
        background: #e2e8f0;
        color: #0f172a;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
    }
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
                        TravelVN tự hào là nền tảng đặt tour du lịch hàng đầu, mang đến cho bạn những trải nghiệm khám
                        phá thế giới tuyệt vời với chi phí tối ưu và dịch vụ tận tâm nhất.
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

<div class="chat-widget">
    <div class="chat-panel" id="chatPanel">
        <div class="chat-header">
            <span><i class="bi bi-headset me-2"></i>Hỗ trợ TravelVN</span>
            <i class="bi bi-x-lg" style="cursor:pointer" onclick="toggleChat()"></i>
        </div>
        <div class="chat-body" id="chatBody">
            <div class="text-center text-muted small mt-2 mb-3">Chào mừng bạn đến với TravelVN. Chúng tôi có thể giúp gì
                cho bạn?</div>
        </div>
        <div class="chat-footer">
            <form id="chatForm" onsubmit="sendChatMessage(event)">
                <input type="text" id="chatInput" class="chat-input" placeholder="Nhập tin nhắn..." required
                    autocomplete="off">
                <button type="submit" class="chat-submit"><i class="bi bi-send-fill"></i></button>
            </form>
        </div>
    </div>

    <?php
    // 1. Lấy tên file hiện tại (index.php, admin.php, v.v.)
    $currentPage = basename($_SERVER['PHP_SELF']);

    // 2. Lấy action hiện tại (login, register, v.v.)
    $currentAction = $_GET['action'] ?? '';

    // 3. Danh sách các "vùng cấm" không cho hiện bong bóng chat
    $excludedPages = ['admin.php', 'manager.php', 'guide.php'];
    $excludedActions = ['login', 'register'];

    // 4. Chỉ hiển thị nếu KHÔNG thuộc danh sách cấm
    if (!in_array($currentPage, $excludedPages) && !in_array($currentAction, $excludedActions)):
        ?>

        <div class="chat-widget" id="chatWidget">
            <button class="chat-button" onclick="toggleChat()">
                <i class="bi bi-chat-dots-fill"></i>
            </button>
        </div>

    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    const chatPanel = document.getElementById('chatPanel');
    const chatBody = document.getElementById('chatBody');
    const chatInput = document.getElementById('chatInput');
    let isChatOpen = false;

    function toggleChat() {
        isChatOpen = !isChatOpen;
        chatPanel.style.display = isChatOpen ? 'flex' : 'none';
        if (isChatOpen) {
            loadChatHistory();
        }
    }

    function appendMessage(type, text) {
        const div = document.createElement('div');
        div.className = `msg-bubble msg-${type}`;
        div.innerText = text;
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function loadChatHistory() {
        fetch('index.php?action=getHistory')
            .then(response => response.json())
            .then(data => {
                chatBody.innerHTML = '<div class="text-center text-muted small mt-2 mb-3">Bắt đầu trò chuyện với TravelVN</div>';
                data.forEach(msg => {
                    appendMessage(msg.sender_type, msg.message);
                });
            });
    }

    function sendChatMessage(e) {
        e.preventDefault();
        const msg = chatInput.value.trim();
        if (!msg) return;

        appendMessage('customer', msg);
        chatInput.value = '';

        const formData = new FormData();
        formData.append('message', msg);
        formData.append('sender_type', 'customer');

        fetch('index.php?action=sendMessage', {
            method: 'POST',
            body: formData
        });
    }

    // 🔥 NHỚ THAY KEY PUSHER CỦA BẠN VÀO ĐÂY 🔥
    var chatPusher = new Pusher('NHẬP_KEY_CỦA_BẠN', {
        cluster: 'ap1'
    });

    var chatChannel = chatPusher.subscribe('live-chat');

    chatChannel.bind('new-message', function (data) {
        if (data.sender_type === 'admin') {
            appendMessage('admin', data.message);
            if (!isChatOpen) toggleChat();
        }
    });
</script>

</body>

</html>
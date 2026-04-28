<?php include __DIR__ . "/../layouts/header.php"; ?>

<style>
    /* CUSTOM CSS CHO TRUNG TÂM HỖ TRỢ */
    :root {
        --chat-bg: #f8fafc;
        --chat-border: #e2e8f0;
        --chat-primary: #0ea5e9;
        --chat-primary-light: #e0f2fe;
        --chat-me: #0ea5e9;
        --chat-customer: #ffffff;
    }

    .support-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--chat-border);
        height: 85vh;
        overflow: hidden;
    }

    /* Thanh cuộn (Scrollbar) tinh tế */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    /* Cột danh sách khách hàng */
    .session-list-col { background: #ffffff; }
    .session-item {
        transition: all 0.2s ease;
        border-bottom: 1px solid var(--chat-border) !important;
        cursor: pointer;
        padding: 16px;
    }
    .session-item:hover { background: #f1f5f9; }
    .session-item.active {
        background: var(--chat-primary-light);
        border-right: 4px solid var(--chat-primary) !important;
    }
    
    /* Bong bóng tin nhắn */
    .msg-bubble {
        max-width: 75%;
        padding: 14px 18px;
        font-size: 0.95rem;
        line-height: 1.5;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .msg-me {
        background: var(--chat-me);
        color: #ffffff;
        border-radius: 20px 20px 4px 20px;
        align-self: flex-end;
    }
    .msg-customer {
        background: var(--chat-customer);
        color: #1e293b;
        border: 1px solid var(--chat-border);
        border-radius: 20px 20px 20px 4px;
        align-self: flex-start;
    }

    /* Input form */
    .chat-input-area { background: #ffffff; padding: 15px 20px; border-top: 1px solid var(--chat-border); }
    .chat-input-wrapper {
        background: #f1f5f9;
        border-radius: 25px;
        padding: 6px;
        display: flex;
        align-items: center;
    }
    .chat-input-wrapper input { border: none; background: transparent; box-shadow: none !important; }
    .btn-send { border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }

    /* Info Sidebar (Cột thông tin bên phải) */
    .info-sidebar { background: #ffffff; border-left: 1px solid var(--chat-border); padding: 20px; }
    .info-avatar { width: 80px; height: 80px; border-radius: 50%; background: var(--chat-primary-light); color: var(--chat-primary); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 15px; }
</style>

<div class="container-fluid py-4" style="background: var(--chat-bg);">
    <div class="row">
        <?php include __DIR__ . "/../layouts/sidebar_manager.php"; ?>

        <div class="col-lg-9">
            <div class="support-card">
                <div class="row g-0 h-100">

                    <div class="col-md-3 border-end h-100 d-flex flex-column session-list-col">
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white">
                            <h5 class="mb-0 fw-bold" style="color: #0f172a;">Hộp thư</h5>
                            <button class="btn btn-sm btn-light rounded-circle" onclick="loadSessions()" title="Làm mới">
                                <i class="bi bi-arrow-clockwise text-primary"></i>
                            </button>
                        </div>
                        <div class="p-2 border-bottom">
                             <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-0" placeholder="Tìm kiếm...">
                            </div>
                        </div>
                        <div class="list-group list-group-flush overflow-auto flex-grow-1" id="sessionList">
                            <div class="text-center p-5 text-muted small">Đang tải hộp thư...</div>
                        </div>
                    </div>

                    <div class="col-md-6 h-100 d-flex flex-column" style="background: #f8fafc;">
                        <div id="chatHeader" class="p-3 border-bottom bg-white d-flex align-items-center fw-bold" style="height: 70px; color: #0f172a;">
                            <span class="text-muted fw-normal"><i class="bi bi-chat-left-text me-2"></i>Chọn đoạn chat để bắt đầu</span>
                        </div>

                        <div id="adminChatBody" class="p-4 flex-grow-1 overflow-auto d-flex flex-column gap-3">
                            <div class="text-center my-auto" style="opacity: 0.4;">
                                <img src="https://cdn-icons-png.flaticon.com/512/4080/4080911.png" style="width: 120px; margin-bottom: 20px;">
                                <h5 class="fw-bold">Trung tâm hỗ trợ TravelVN</h5>
                                <p class="text-muted small">Mọi tin nhắn từ khách hàng sẽ hiển thị tại đây.</p>
                            </div>
                        </div>

                        <div class="chat-input-area">
                            <form id="adminChatForm" onsubmit="adminSendMessage(event)" class="d-none">
                                <div class="chat-input-wrapper">
                                    <input type="text" id="adminChatInput" class="form-control px-3" placeholder="Nhập tin nhắn..." autocomplete="off">
                                    <button class="btn btn-primary btn-send" type="submit">
                                        <i class="bi bi-send-fill"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-3 h-100 d-flex flex-column info-sidebar d-none d-md-flex">
                        <div id="customerInfoPanel" class="text-center mt-4" style="opacity: 0.3;">
                            <div class="info-avatar"><i class="bi bi-person"></i></div>
                            <h6 class="fw-bold text-dark">Thông tin người dùng</h6>
                            <p class="small text-muted mb-4">Chưa có thông tin</p>
                            <hr class="text-muted">
                            <div class="text-start mt-4">
                                <p class="small text-muted mb-1"><i class="bi bi-clock me-2"></i>Trạng thái: <span class="badge bg-secondary">Offline</span></p>
                                <p class="small text-muted mb-1"><i class="bi bi-shield-check me-2"></i>Phiên bảo mật: Đã mã hóa</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    let currentSessionId = null;
    let apiUrl = '<?= ($_SESSION['user']['role'] === 'admin') ? 'admin.php' : 'manager.php' ?>';

    // 1. Tải danh sách
    function loadSessions() {
        fetch(apiUrl + '?action=getSessions')
            .then(res => res.json())
            .then(data => {
                const list = document.getElementById('sessionList');
                if (data.length === 0) {
                    list.innerHTML = '<div class="text-center p-4 text-muted small">Hộp thư trống</div>';
                    return;
                }
                list.innerHTML = '';
                data.forEach(s => {
                    const isActive = s.session_id === currentSessionId ? 'active' : '';
                    const senderName = s.sender_name || 'Khách ẩn danh';
                    const avatarLetter = senderName.charAt(0).toUpperCase();
                    
                    list.innerHTML += `
                        <div class="session-item d-flex gap-3 align-items-center ${isActive}" onclick="openChat('${s.session_id}', '${senderName}')">
                            <div class="rounded-circle bg-light text-primary d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 40px; height: 40px;">
                                ${avatarLetter}
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-dark small text-truncate" style="max-width: 70%;">${senderName}</span>
                                    <span style="font-size: 10px;" class="text-muted">${new Date(s.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small text-truncate" style="max-width: 80%;">${s.message}</span>
                                    <button class="btn btn-sm text-danger p-0 border-0" onclick="deleteChatSession('${s.session_id}', event)" title="Kết thúc hỗ trợ">
                                        <i class="bi bi-x-circle-fill" style="font-size: 14px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });
            });
    }


    // 2. Mở khung chat
    function openChat(sessionId, senderName) {
        currentSessionId = sessionId;
        document.getElementById('adminChatForm').classList.remove('d-none');
        
        // Update Header
        document.getElementById('chatHeader').innerHTML = `
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <div class="fw-bold mb-0 lh-1">${senderName}</div>
                    <small class="text-success" style="font-size: 11px;">● Đang hỗ trợ</small>
                </div>
            </div>
        `;

        // SỬA TẠI ĐÂY: Xác định phân loại khách hàng dựa vào sessionId
        let userBadge = sessionId.startsWith('user_') 
            ? '<span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Thành viên TravelVN</span>' 
            : '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">Khách chưa đăng nhập</span>';

        // Update Info Panel (Cột 3)
        const panel = document.getElementById('customerInfoPanel');
        panel.style.opacity = '1';
        panel.innerHTML = `
            <div class="info-avatar">${senderName.charAt(0).toUpperCase()}</div>
            <h6 class="fw-bold text-dark mb-2">${senderName}</h6>
            ${userBadge}
            
            <hr class="text-muted mt-4">
            <div class="text-start mt-4">
                <p class="small text-muted mb-2"><i class="bi bi-circle-fill text-success me-2" style="font-size: 8px;"></i>Trạng thái: Trực tuyến</p>
                <p class="small text-muted mb-2"><i class="bi bi-hdd-network me-2"></i>Kênh: Website TravelVN</p>
                <button class="btn btn-outline-danger btn-sm w-100 mt-3" onclick="deleteChatSession('${sessionId}', event)">Xóa cuộc trò chuyện</button>
            </div>
        `;

        // ... (Phần fetch gọi API getHistory giữ nguyên như cũ) ...
        fetch(apiUrl + '?action=getHistory&session_id=' + sessionId)
            .then(res => res.json())
            .then(data => {
                const body = document.getElementById('adminChatBody');
                body.innerHTML = '';
                data.forEach(msg => { appendMessageUI(msg.sender_type, msg.message); });
                body.scrollTop = body.scrollHeight;
            });
        
        // Highlight active session
        document.querySelectorAll('.session-item').forEach(el => el.classList.remove('active'));
        event.currentTarget.classList.add('active');
    }

    // 3. Vẽ tin nhắn
    function appendMessageUI(type, text) {
        const body = document.getElementById('adminChatBody');
        const isMe = (type !== 'customer');
        const bubbleClass = isMe ? 'msg-me' : 'msg-customer';
        const alignClass = isMe ? 'justify-content-end' : 'justify-content-start';

        const msgHtml = `
            <div class="d-flex ${alignClass}">
                <div class="msg-bubble ${bubbleClass}">
                    ${text}
                </div>
            </div>
        `;
        body.insertAdjacentHTML('beforeend', msgHtml);
        body.scrollTop = body.scrollHeight;
    }

    // 4. Gửi tin nhắn
    function adminSendMessage(e) {
        e.preventDefault();
        const input = document.getElementById('adminChatInput');
        const msg = input.value.trim();
        if (!msg || !currentSessionId) return;

        const formData = new FormData();
        formData.append('message', msg);
        formData.append('sender_type', 'admin');
        formData.append('session_id', currentSessionId);

        fetch(apiUrl + '?action=sendMessage', { method: 'POST', body: formData });
        input.value = '';
    }

    // 5. Xóa Session
    function deleteChatSession(sessionId, event) {
        if(event) event.stopPropagation();
        if (!confirm('Xóa toàn bộ cuộc trò chuyện này?')) return;

        const formData = new FormData();
        formData.append('session_id', sessionId);

        fetch(apiUrl + '?action=deleteSession', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (currentSessionId === sessionId) {
                        currentSessionId = null;
                        document.getElementById('adminChatForm').classList.add('d-none');
                        document.getElementById('chatHeader').innerHTML = `<span class="text-muted fw-normal"><i class="bi bi-chat-left-text me-2"></i>Chọn đoạn chat để bắt đầu</span>`;
                        document.getElementById('adminChatBody').innerHTML = `<div class="text-center my-auto text-muted"><p>Nội dung trống</p></div>`;
                        document.getElementById('customerInfoPanel').style.opacity = '0.3';
                    }
                    loadSessions();
                }
            });
    }

    // 6. Pusher Realtime
    var chatPusher = new Pusher('dfb02b6665ceae1b4add', { cluster: 'ap1' });
    var chatChannel = chatPusher.subscribe('live-chat');
    chatChannel.bind('new-message', function (data) {
        if (data.session_id === currentSessionId) { appendMessageUI(data.sender_type, data.message); }
        loadSessions();
    });

    loadSessions();
    if (typeof updateChatBell === 'function') {
            updateChatBell();
        }
</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
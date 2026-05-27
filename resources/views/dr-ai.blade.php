<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DR AI - Medical Assistant</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Inter',sans-serif; }

body{
    background:#eef4fb;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.ai-container{
    width:95%;
    max-width:1200px;
    height:95vh;
    background:white;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(15,23,42,0.08);
    display:flex;
    flex-direction:column;
}

/* HEADER */
.ai-header{
    background:linear-gradient(to right,#1e3a8a,#2563eb);
    color:white;
    padding:20px 25px;
    display:flex;
    align-items:center;
    gap:15px;
}

.ai-avatar{
    width:60px;
    height:60px;
    border-radius:50%;
    background:rgba(255,255,255,0.2);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
}

.ai-details h2{ font-size:22px; }
.ai-details p{ font-size:14px; opacity:0.9; margin-top:4px; }

/* CHAT AREA */
.chat-box{
    flex:1;
    overflow-y:auto;
    padding:25px;
    background:#f8fafc;
}

.message-wrapper{ display:flex; margin-bottom:18px; }
.user-wrapper{ justify-content:flex-end; }
.ai-wrapper{ justify-content:flex-start; }

.message{
    max-width:75%;
    padding:15px 18px;
    border-radius:18px;
    line-height:1.6;
    font-size:15px;
}

.user-message{
    background:#2563eb;
    color:white;
    border-bottom-right-radius:6px;
}

.ai-message{
    background:white;
    border:1px solid #dbe4ee;
    color:#0f172a;
    border-bottom-left-radius:6px;
}

/* FILE PREVIEW */
.file-preview{
    display:none;
    align-items:center;
    gap:10px;
    background:#eff6ff;
    border:1px solid #bfdbfe;
    border-radius:10px;
    padding:10px 14px;
    margin-bottom:10px;
    font-size:13px;
    color:#1e40af;
}

.file-preview.active{ display:flex; }

.file-preview-name{
    flex:1;
    font-weight:600;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.file-preview-remove{
    background:none;
    border:none;
    color:#ef4444;
    cursor:pointer;
    font-size:16px;
    font-weight:700;
}

/* IMAGE PREVIEW in chat */
.chat-image{
    max-width:220px;
    border-radius:12px;
    margin-bottom:8px;
    display:block;
    border:2px solid #bfdbfe;
}

/* FOOTER */
.chat-footer{
    padding:16px 20px;
    border-top:1px solid #e2e8f0;
    background:white;
}

.chat-form{ display:flex; gap:12px; align-items:center; }

.message-input{
    flex:1;
    padding:16px;
    border-radius:14px;
    border:1px solid #cbd5e1;
    outline:none;
    font-size:15px;
}

.message-input:focus{ border-color:#2563eb; }

/* FILE BUTTON */
.file-label{
    width:54px;
    height:54px;
    border-radius:14px;
    background:#eff6ff;
    border:1px solid #bfdbfe;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    font-size:22px;
    flex-shrink:0;
    transition:0.2s;
}

.file-label:hover{ background:#dbeafe; }
.file-label.has-file{ background:#2563eb; border-color:#2563eb; }

/* SEND BUTTON */
.send-btn{
    border:none;
    background:#2563eb;
    color:white;
    padding:16px 24px;
    border-radius:14px;
    cursor:pointer;
    font-weight:600;
    font-size:15px;
    transition:0.2s;
    flex-shrink:0;
}

.send-btn:hover{ background:#1d4ed8; }
.send-btn:disabled{ opacity:0.6; cursor:not-allowed; }

/* TYPING */
.typing{
    display:none;
    padding:14px 18px;
    background:white;
    border-radius:14px;
    width:fit-content;
    border:1px solid #dbe4ee;
    margin-bottom:18px;
}

.typing span{
    width:8px;
    height:8px;
    margin:0 2px;
    background:#64748b;
    border-radius:50%;
    display:inline-block;
    animation:blink 1.4s infinite;
}

.typing span:nth-child(2){ animation-delay:0.2s; }
.typing span:nth-child(3){ animation-delay:0.4s; }

@keyframes blink{
    0%,80%,100%{ opacity:0.3; }
    40%{ opacity:1; }
}

@media(max-width:768px){
    .ai-container{ width:100%; height:100vh; border-radius:0; }
    .message{ max-width:90%; }
    .chat-form{ flex-wrap:wrap; }
    .send-btn{ width:100%; }
}
</style>
</head>
<body>

<div class="ai-container">

    <!-- HEADER -->
    <div class="ai-header">
        <div class="ai-avatar">🩺</div>
        <div class="ai-details">
            <h2>DR AI Assistant</h2>
            <p>Secure Medical Artificial Intelligence Assistant</p>
        </div>
    </div>

    <!-- CHAT -->
    <div class="chat-box" id="chatBox">

        <div class="message-wrapper ai-wrapper">
            <div class="message ai-message">
                Hello 👋<br><br>
                I am DR AI.<br>
                Describe your symptoms or upload a medical file (X-ray, lab result, scan) for assistance.<br><br>
                <small style="color:#64748b;">📎 Use the paperclip button to attach an image or PDF.</small>
            </div>
        </div>

        <div class="typing" id="typing">
            <span></span><span></span><span></span>
        </div>

    </div>

    <!-- FOOTER -->
    <div class="chat-footer">

        <!-- FILE PREVIEW BAR -->
        <div class="file-preview" id="filePreview">
            <span>📎</span>
            <span class="file-preview-name" id="filePreviewName"></span>
            <button class="file-preview-remove" onclick="removeFile()" title="Remove file">✕</button>
        </div>

        <form id="aiForm" class="chat-form">

            <!-- FILE INPUT (hidden) -->
            <input type="file"
                   id="medicalFile"
                   name="file"
                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                   style="display:none"
                   onchange="handleFileSelect(this)">

            <!-- FILE BUTTON -->
            <label class="file-label" id="fileLabel" onclick="document.getElementById('medicalFile').click()" title="Attach medical file">
                📎
            </label>

            <!-- MESSAGE INPUT -->
            <input type="text"
                   name="message"
                   id="messageInput"
                   class="message-input"
                   placeholder="Describe your symptoms or ask a medical question...">

            <!-- SEND -->
            <button type="submit" class="send-btn" id="sendBtn">
                Send ➤
            </button>

        </form>
    </div>

</div>

<script>
const form        = document.getElementById('aiForm');
const chatBox     = document.getElementById('chatBox');
const typing      = document.getElementById('typing');
const sendBtn     = document.getElementById('sendBtn');
const fileInput   = document.getElementById('medicalFile');
const filePreview = document.getElementById('filePreview');
const fileLabel   = document.getElementById('fileLabel');

// ── FILE SELECTED ──
function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        document.getElementById('filePreviewName').textContent = file.name;
        filePreview.classList.add('active');
        fileLabel.classList.add('has-file');
        fileLabel.textContent = '✅';
    }
}

// ── REMOVE FILE ──
function removeFile() {
    fileInput.value = '';
    filePreview.classList.remove('active');
    fileLabel.classList.remove('has-file');
    fileLabel.textContent = '📎';
}

// ── SUBMIT ──
form.addEventListener('submit', async function(e) {
    e.preventDefault();

    const message = document.getElementById('messageInput').value.trim();
    const file    = fileInput.files[0];

    // Must have message or file
    if (!message && !file) {
        return;
    }

    // Show user message in chat
    let userBubbleContent = '';

    if (file && file.type.startsWith('image/')) {
        // Show image preview in chat
        const imageUrl = URL.createObjectURL(file);
        userBubbleContent = `
            <img src="${imageUrl}" class="chat-image" alt="Uploaded medical image"/>
            ${message ? `<div>${message}</div>` : '<div><em>Please analyse this medical image.</em></div>'}
        `;
    } else if (file) {
        userBubbleContent = `
            <div>📎 <strong>${file.name}</strong></div>
            ${message ? `<div style="margin-top:6px;">${message}</div>` : ''}
        `;
    } else {
        userBubbleContent = message;
    }

    appendMessage('user', userBubbleContent);

    // Show typing
    typing.style.display = 'block';
    sendBtn.disabled = true;
    chatBox.scrollTop = chatBox.scrollHeight;

    // ── BUILD FORM DATA (supports file + message together) ──
    const formData = new FormData();
    formData.append('message', message);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

    if (file) {
        formData.append('file', file);
    }

    try {
        const response = await fetch('/dr-ai', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                // Do NOT set Content-Type here — browser sets it with boundary for FormData
            },
            body: formData
        });

        const data = await response.json();

        typing.style.display = 'none';
        sendBtn.disabled = false;

        appendMessage('ai', data.reply);

    } catch (error) {
        typing.style.display = 'none';
        sendBtn.disabled = false;
        appendMessage('ai', '⚠️ Sorry, something went wrong. Please try again.');
    }

    // Reset
    document.getElementById('messageInput').value = '';
    removeFile();
    chatBox.scrollTop = chatBox.scrollHeight;
});

// ── APPEND MESSAGE ──
function appendMessage(sender, content) {
    const wrapper = document.createElement('div');
    wrapper.className = `message-wrapper ${sender === 'user' ? 'user-wrapper' : 'ai-wrapper'}`;

    const bubble = document.createElement('div');
    bubble.className = `message ${sender === 'user' ? 'user-message' : 'ai-message'}`;
    bubble.innerHTML = content;

    wrapper.appendChild(bubble);

    // Insert before typing indicator
    chatBox.insertBefore(wrapper, typing);
    chatBox.scrollTop = chatBox.scrollHeight;
}
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>TeleMed Chat — {{ $otherUser->role === 'doctor' ? 'Dr. ' : '' }}{{ $otherUser->name }}</title>
@vite(['resources/js/app.js'])
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

:root {
  --bg:           #0d1117;
  --surface:      #161b22;
  --surface2:     #1c2330;
  --border:       #30363d;
  --accent:       #2563eb;
  --accent-glow:  rgba(37,99,235,0.25);
  --accent-light: #3b82f6;
  --green:        #22c55e;
  --red:          #ef4444;
  --amber:        #f59e0b;
  --text:         #e6edf3;
  --text-muted:   #7d8590;
  --text-dim:     #4d5562;
  --bubble-out:   #1d4ed8;
  --bubble-in:    #1c2330;
  --radius-msg:   18px;
  --font:         'Manrope', sans-serif;
  --sidebar-w:    300px;
  --header-h:     64px;
  --footer-h:     72px;
}

html { height:100%; overflow:hidden; }
body { height:100%; overflow:hidden; background:var(--bg); font-family:var(--font); color:var(--text); -webkit-text-size-adjust:100%; }

/* ─── Shell ── */
.shell {
  display:flex;
  height:100dvh;
  height:100vh;
  width:100%;
  max-width:1100px;
  margin:0 auto;
  position:relative;
  overflow:hidden;
}

/* ─── Sidebar ── */
.sidebar {
  width:var(--sidebar-w);
  flex-shrink:0;
  background:var(--surface);
  border-right:1px solid var(--border);
  display:flex;
  flex-direction:column;
  transition:transform 0.28s cubic-bezier(.4,0,.2,1);
  z-index:200;
}

.sidebar-header {
  padding:16px 16px 14px;
  border-bottom:1px solid var(--border);
  display:flex;
  align-items:center;
  gap:10px;
  flex-shrink:0;
}

.sidebar-title { font-size:18px; font-weight:800; letter-spacing:-0.5px; }
.sidebar-title span { color:var(--accent-light); }

.search-bar {
  padding:10px 12px;
  border-bottom:1px solid var(--border);
  flex-shrink:0;
}

.search-bar input {
  width:100%;
  background:var(--surface2);
  border:1px solid var(--border);
  border-radius:10px;
  padding:9px 13px;
  font-family:var(--font);
  font-size:13px;
  color:var(--text);
  outline:none;
}

.search-bar input::placeholder { color:var(--text-muted); }

.contact-list { flex:1; overflow-y:auto; }

.contact-item {
  display:flex;
  align-items:center;
  gap:11px;
  padding:12px 14px;
  cursor:pointer;
  transition:background 0.15s;
  border-bottom:1px solid rgba(48,54,61,0.4);
}

.contact-item:hover, .contact-item.active { background:var(--surface2); }
.contact-item.active { border-left:3px solid var(--accent); }

.c-avatar {
  width:44px; height:44px;
  border-radius:50%;
  background:linear-gradient(135deg, var(--accent), #7c3aed);
  display:flex; align-items:center; justify-content:center;
  font-weight:800; font-size:16px;
  flex-shrink:0;
  position:relative;
}

.c-avatar .online-dot {
  position:absolute; bottom:1px; right:1px;
  width:11px; height:11px;
  border-radius:50%;
  background:var(--green);
  border:2px solid var(--surface);
}

.c-info { flex:1; min-width:0; }
.c-name { font-size:14px; font-weight:700; }
.c-preview { font-size:12px; color:var(--text-muted); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-top:2px; }
.c-time { font-size:11px; color:var(--text-muted); flex-shrink:0; }

/* ─── Main Chat ── */
.chat-main {
  flex:1;
  display:flex;
  flex-direction:column;
  background:var(--bg);
  position:relative;
  min-width:0;
  overflow:hidden;
}

.chat-main::before {
  content:'';
  position:absolute; inset:0;
  background-image:
    radial-gradient(circle at 20% 50%, rgba(37,99,235,0.04) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(124,58,237,0.04) 0%, transparent 50%);
  pointer-events:none;
}

/* ─── Header ── */
.chat-header {
  background:var(--surface);
  border-bottom:1px solid var(--border);
  padding:10px 14px;
  display:flex;
  align-items:center;
  gap:10px;
  position:relative;
  z-index:10;
  flex-shrink:0;
  min-height:var(--header-h);
}

.back-btn {
  display:none;
  width:38px; height:38px;
  border-radius:10px;
  border:1px solid var(--border);
  background:var(--surface2);
  color:var(--text);
  cursor:pointer;
  align-items:center; justify-content:center;
  font-size:18px;
  flex-shrink:0;
  transition:background 0.15s;
}

.back-btn:hover { background:var(--accent); border-color:var(--accent); }

.h-avatar {
  width:40px; height:40px;
  border-radius:50%;
  background:linear-gradient(135deg, var(--accent), #7c3aed);
  display:flex; align-items:center; justify-content:center;
  font-weight:800; font-size:15px;
  flex-shrink:0;
  position:relative;
}

.h-avatar .online-dot {
  position:absolute; bottom:1px; right:1px;
  width:10px; height:10px;
  border-radius:50%;
  background:var(--green);
  border:2px solid var(--surface);
}

.h-info { flex:1; min-width:0; }
.h-name { font-size:14px; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.h-status { font-size:11px; font-weight:600; }

.h-actions { display:flex; align-items:center; gap:5px; flex-shrink:0; }

.h-btn {
  width:38px; height:38px;
  border-radius:10px;
  border:1px solid var(--border);
  background:var(--surface2);
  color:var(--text);
  cursor:pointer;
  display:flex; align-items:center; justify-content:center;
  font-size:16px;
  transition:all 0.15s;
  flex-shrink:0;
}

.h-btn:hover { background:var(--accent); border-color:var(--accent); }

/* ─── Messages ── */
.chat-body {
  flex:1;
  overflow-y:auto;
  overflow-x:hidden;
  padding:16px 16px;
  display:flex;
  flex-direction:column;
  gap:4px;
  position:relative;
  z-index:1;
  -webkit-overflow-scrolling:touch;
}

.chat-body::-webkit-scrollbar { width:3px; }
.chat-body::-webkit-scrollbar-track { background:transparent; }
.chat-body::-webkit-scrollbar-thumb { background:var(--border); border-radius:4px; }

.date-divider {
  display:flex; align-items:center; gap:10px;
  margin:10px 0;
}

.date-divider span {
  font-size:11px; font-weight:700;
  color:var(--text-muted);
  background:var(--surface);
  padding:3px 10px;
  border-radius:20px;
  border:1px solid var(--border);
  letter-spacing:0.5px;
  text-transform:uppercase;
  white-space:nowrap;
}

.date-divider::before, .date-divider::after {
  content:''; flex:1; height:1px; background:var(--border);
}

.msg-wrap {
  display:flex;
  flex-direction:column;
  max-width:82%;
  animation:msgIn 0.2s ease;
}

@keyframes msgIn {
  from { opacity:0; transform:translateY(6px); }
  to   { opacity:1; transform:translateY(0); }
}

.msg-wrap.out { align-self:flex-end; align-items:flex-end; }
.msg-wrap.in  { align-self:flex-start; align-items:flex-start; }

.msg-wrap + .msg-wrap.out  { margin-top:2px; }
.msg-wrap + .msg-wrap.in   { margin-top:2px; }
.msg-wrap.out + .msg-wrap.in,
.msg-wrap.in + .msg-wrap.out { margin-top:10px; }

.bubble {
  padding:9px 13px;
  border-radius:var(--radius-msg);
  font-size:14px;
  line-height:1.55;
  word-break:break-word;
  position:relative;
}

.msg-wrap.out .bubble {
  background:var(--bubble-out);
  border-bottom-right-radius:4px;
  color:#fff;
}

.msg-wrap.in .bubble {
  background:var(--bubble-in);
  border:1px solid var(--border);
  border-bottom-left-radius:4px;
  color:var(--text);
}

.msg-wrap.out .bubble::after {
  content:'';
  position:absolute; bottom:0; right:-7px;
  width:0; height:0;
  border-left:8px solid var(--bubble-out);
  border-top:8px solid transparent;
}

.msg-wrap.in .bubble::after {
  content:'';
  position:absolute; bottom:0; left:-7px;
  width:0; height:0;
  border-right:8px solid var(--bubble-in);
  border-top:8px solid transparent;
}

.msg-meta {
  display:flex;
  align-items:center;
  gap:4px;
  font-size:11px;
  color:var(--text-muted);
  margin-top:3px;
  padding:0 2px;
}

.msg-wrap.out .msg-meta { flex-direction:row-reverse; }
.ticks { font-size:13px; color:var(--accent-light); }

/* File bubble */
.file-bubble {
  display:flex; align-items:center; gap:10px;
  background:rgba(255,255,255,0.06);
  border-radius:12px;
  padding:9px 12px;
  margin-top:5px;
}

.file-icon { font-size:24px; flex-shrink:0; }
.file-info { flex:1; min-width:0; }
.file-name { font-size:13px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.file-size { font-size:11px; color:rgba(255,255,255,0.5); margin-top:2px; }

.file-dl {
  width:32px; height:32px;
  border-radius:50%;
  background:rgba(255,255,255,0.1);
  border:none;
  color:white;
  cursor:pointer;
  display:flex; align-items:center; justify-content:center;
  font-size:13px;
  text-decoration:none;
  transition:background 0.15s;
  flex-shrink:0;
}

.file-dl:hover { background:var(--accent); }

/* Voice bubble */
.voice-bubble {
  display:flex; align-items:center; gap:8px;
  padding:6px 2px;
  min-width:180px;
}

.v-play {
  width:36px; height:36px;
  border-radius:50%;
  background:rgba(255,255,255,0.15);
  border:none; color:white; cursor:pointer;
  display:flex; align-items:center; justify-content:center;
  font-size:13px; flex-shrink:0;
  transition:background 0.15s;
}

.v-play:hover { background:rgba(255,255,255,0.3); }
.v-play.playing { background:var(--green); }

.v-waveform {
  flex:1; display:flex; align-items:center; gap:2px;
  height:28px; cursor:pointer;
}

.v-bar { width:3px; background:rgba(255,255,255,0.35); border-radius:2px; }
.v-bar.played { background:rgba(255,255,255,0.85); }
.v-duration { font-size:11px; color:rgba(255,255,255,0.6); flex-shrink:0; }

/* Typing */
.typing-indicator {
  display:none;
  align-self:flex-start;
  background:var(--bubble-in);
  border:1px solid var(--border);
  border-radius:18px;
  border-bottom-left-radius:4px;
  padding:10px 16px;
  gap:4px;
  align-items:center;
}

.typing-indicator.active { display:flex; }

.t-dot {
  width:7px; height:7px;
  border-radius:50%;
  background:var(--text-muted);
  animation:bounce 1.4s ease infinite;
}

.t-dot:nth-child(2) { animation-delay:0.2s; }
.t-dot:nth-child(3) { animation-delay:0.4s; }

@keyframes bounce { 0%,60%,100% { transform:translateY(0); } 30% { transform:translateY(-6px); } }

/* ─── Footer ── */
.chat-footer {
  background:var(--surface);
  border-top:1px solid var(--border);
  padding:10px 12px;
  padding-bottom:max(10px, env(safe-area-inset-bottom));
  position:relative;
  z-index:10;
  flex-shrink:0;
}

.recording-bar {
  display:none;
  align-items:center;
  gap:10px;
  padding:9px 14px;
  background:rgba(239,68,68,0.1);
  border:1px solid rgba(239,68,68,0.3);
  border-radius:12px;
  margin-bottom:9px;
  animation:pulse 1.5s ease infinite;
}

.recording-bar.active { display:flex; }

@keyframes pulse {
  0%,100% { border-color:rgba(239,68,68,0.3); }
  50%      { border-color:rgba(239,68,68,0.7); }
}

.rec-dot { width:10px; height:10px; border-radius:50%; background:var(--red); animation:blink 1s ease infinite; }

@keyframes blink { 0%,100% { opacity:1; } 50% { opacity:0.2; } }

.rec-time { font-size:14px; font-weight:700; color:var(--red); flex:1; }
.rec-cancel { font-size:12px; color:var(--text-muted); cursor:pointer; padding:4px 10px; border-radius:8px; background:var(--surface2); border:1px solid var(--border); }
.rec-cancel:hover { color:var(--red); }

.input-row {
  display:flex;
  align-items:flex-end;
  gap:8px;
}

.attach-btn, .emoji-btn, .send-btn, .voice-btn {
  width:42px; height:42px;
  border-radius:11px;
  border:1px solid var(--border);
  background:var(--surface2);
  color:var(--text);
  cursor:pointer;
  display:flex; align-items:center; justify-content:center;
  font-size:18px;
  flex-shrink:0;
  transition:all 0.15s;
  -webkit-tap-highlight-color:transparent;
}

.attach-btn:hover, .emoji-btn:hover { background:var(--surface); color:var(--accent-light); }
.voice-btn:hover { background:var(--red); border-color:var(--red); color:#fff; }
.voice-btn.recording { background:var(--red); border-color:var(--red); color:#fff; animation:btnPulse 1s ease infinite; }

@keyframes btnPulse { 0%,100% { transform:scale(1); } 50% { transform:scale(1.05); } }

.msg-input-wrap {
  flex:1;
  background:var(--surface2);
  border:1px solid var(--border);
  border-radius:14px;
  display:flex; align-items:center; gap:6px;
  padding:0 12px;
  min-width:0;
  transition:border-color 0.2s;
}

.msg-input-wrap:focus-within { border-color:var(--accent); }

.msg-input {
  flex:1;
  background:transparent;
  border:none;
  outline:none;
  font-family:var(--font);
  font-size:16px; /* 16px prevents iOS auto-zoom on focus */
  color:var(--text);
  padding:11px 0;
  resize:none;
  max-height:110px;
  line-height:1.5;
  -webkit-appearance:none;
}

.msg-input::placeholder { color:var(--text-muted); }

.send-btn {
  background:var(--accent);
  border-color:var(--accent);
  color:#fff;
}
.send-btn:hover { background:var(--accent-light); border-color:var(--accent-light); }
.send-btn:active { transform:scale(0.95); }

/* File preview strip */
.file-preview-strip {
  display:none;
  align-items:center;
  gap:10px;
  padding:9px 12px;
  background:var(--surface2);
  border:1px solid var(--border);
  border-radius:11px;
  margin-bottom:9px;
}

.file-preview-strip.active { display:flex; }
.fp-icon { font-size:20px; }
.fp-name { flex:1; font-size:13px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.fp-remove { font-size:18px; cursor:pointer; color:var(--text-muted); }
.fp-remove:hover { color:var(--red); }

/* Emoji picker */
.emoji-picker {
  display:none;
  position:absolute; bottom:calc(100% + 6px); left:10px;
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:14px;
  padding:10px;
  z-index:100;
  box-shadow:0 8px 32px rgba(0,0,0,0.4);
  width:min(280px, calc(100vw - 24px));
}

.emoji-picker.active { display:block; }
.emoji-grid { display:flex; flex-wrap:wrap; gap:3px; }

.ep-emoji {
  width:34px; height:34px;
  border-radius:8px;
  display:flex; align-items:center; justify-content:center;
  font-size:19px; cursor:pointer;
  transition:background 0.1s;
}

.ep-emoji:hover { background:var(--surface2); }

/* ─── Video Modal ── */
.modal-overlay {
  display:none;
  position:fixed; inset:0;
  background:rgba(0,0,0,0.88);
  z-index:1000;
  align-items:center; justify-content:center;
  backdrop-filter:blur(8px);
  padding:12px;
}

.modal-overlay.active { display:flex; }

.video-modal {
  width:100%;
  max-width:900px;
  height:min(580px, calc(100dvh - 24px));
  background:var(--surface);
  border-radius:20px;
  border:1px solid var(--border);
  overflow:hidden;
  position:relative;
  display:flex; flex-direction:column;
  box-shadow:0 24px 64px rgba(0,0,0,0.6);
}

.vm-header {
  padding:14px 18px;
  display:flex; align-items:center; gap:10px;
  background:rgba(0,0,0,0.3);
  position:absolute; top:0; left:0; right:0;
  z-index:10;
}

.vm-info { flex:1; min-width:0; }
.vm-name { font-size:15px; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.vm-status { font-size:12px; color:var(--green); font-weight:600; }

.vm-timer {
  font-size:18px; font-weight:800;
  font-variant-numeric:tabular-nums;
  color:white;
  letter-spacing:1px;
  flex-shrink:0;
}

.video-grid { flex:1; display:grid; grid-template-columns:1fr 1fr; gap:2px; background:#000; }

.video-slot {
  position:relative;
  background:#0d1117;
  display:flex; align-items:center; justify-content:center;
}

.video-slot video { width:100%; height:100%; object-fit:cover; }

.video-slot .no-video {
  display:flex; flex-direction:column; align-items:center; gap:10px;
  color:var(--text-muted);
}

.no-video .big-avatar {
  width:70px; height:70px;
  border-radius:50%;
  background:linear-gradient(135deg, var(--accent), #7c3aed);
  display:flex; align-items:center; justify-content:center;
  font-size:28px; font-weight:800;
}

.video-slot .slot-label {
  position:absolute; bottom:10px; left:12px;
  font-size:12px; font-weight:600;
  background:rgba(0,0,0,0.55);
  padding:3px 10px; border-radius:20px; color:#fff;
}

.pip {
  position:absolute; bottom:80px; right:12px;
  width:120px; height:90px;
  border-radius:10px; overflow:hidden;
  border:2px solid var(--accent);
  background:#0d1117; z-index:20; cursor:pointer;
  box-shadow:0 6px 20px rgba(0,0,0,0.5);
}

.pip video, .pip .pip-placeholder { width:100%; height:100%; object-fit:cover; }

.pip-placeholder {
  display:flex; align-items:center; justify-content:center;
  font-size:24px; font-weight:800;
  background:linear-gradient(135deg, var(--accent), #7c3aed);
}

.pip-label { position:absolute; bottom:5px; left:7px; font-size:11px; font-weight:700; color:rgba(255,255,255,0.8); }

.call-controls {
  position:absolute; bottom:0; left:0; right:0;
  padding:14px 18px;
  display:flex; align-items:center; justify-content:center; gap:12px;
  background:linear-gradient(transparent, rgba(0,0,0,0.7));
}

.ctrl-btn {
  width:48px; height:48px;
  border-radius:50%;
  border:none; cursor:pointer;
  display:flex; align-items:center; justify-content:center;
  font-size:19px; transition:all 0.2s; color:#fff;
}

.ctrl-btn.mute  { background:var(--surface2); border:1px solid var(--border); }
.ctrl-btn.cam   { background:var(--surface2); border:1px solid var(--border); }
.ctrl-btn.end   { background:var(--red); width:58px; height:58px; font-size:22px; }
.ctrl-btn.end:hover { background:#dc2626; transform:scale(1.05); }
.ctrl-btn.mute:hover, .ctrl-btn.cam:hover { background:var(--surface); }
.ctrl-btn.off   { background:rgba(239,68,68,0.2); border-color:var(--red); }

/* ─── Incoming call toast ── */
.incoming-call {
  display:none;
  position:fixed; bottom:20px; right:16px;
  left:16px;
  max-width:320px;
  margin-left:auto;
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:18px;
  padding:14px 16px;
  z-index:2000;
  box-shadow:0 16px 40px rgba(0,0,0,0.5);
  animation:slideIn 0.3s ease;
}

.incoming-call.active { display:block; }

@keyframes slideIn {
  from { transform:translateY(120%); opacity:0; }
  to   { transform:translateY(0); opacity:1; }
}

.ic-header { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
.ic-avatar { width:42px; height:42px; border-radius:50%; background:linear-gradient(135deg, var(--accent), #7c3aed); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:15px; flex-shrink:0; }
.ic-info .ic-name { font-size:14px; font-weight:700; }
.ic-info .ic-type { font-size:12px; color:var(--text-muted); }
.ic-actions { display:flex; gap:10px; }
.ic-btn { flex:1; padding:10px; border-radius:11px; border:none; cursor:pointer; font-family:var(--font); font-size:13px; font-weight:700; -webkit-tap-highlight-color:transparent; }
.ic-btn.answer { background:var(--green); color:#fff; }
.ic-btn.decline { background:var(--red); color:#fff; }
.ic-btn:hover { opacity:0.9; }

/* ─── Mobile overlay backdrop ── */
.sidebar-backdrop {
  display:none;
  position:fixed; inset:0;
  background:rgba(0,0,0,0.6);
  z-index:190;
  backdrop-filter:blur(2px);
}

.sidebar-backdrop.active { display:block; }

.hidden { display:none !important; }

.contact-list::-webkit-scrollbar { width:3px; }
.contact-list::-webkit-scrollbar-thumb { background:var(--border); border-radius:3px; }

/* ─── RESPONSIVE ── */
@media (max-width:767px) {
  :root { --sidebar-w:280px; }

  /* Sidebar slides in from left on mobile */
  .sidebar {
    position:fixed;
    top:0; left:0;
    height:100dvh;
    height:100vh;
    transform:translateX(-100%);
    box-shadow:8px 0 32px rgba(0,0,0,0.5);
  }

  .sidebar.open { transform:translateX(0); }

  /* Show back/menu buttons on mobile */
  .back-btn { display:flex; }

  /* Wider bubbles on small screens */
  .msg-wrap { max-width:88%; }

  /* Tighter chat body padding */
  .chat-body { padding:12px 10px; }

  /* Slightly smaller h-btn label for narrow screens */
  .h-btn { width:36px; height:36px; font-size:15px; }

  /* Footer padding for iOS home bar */
  .chat-footer {
    padding-bottom:max(10px, env(safe-area-inset-bottom));
  }

  /* Attach + emoji collapse on very small screens */
  .emoji-btn { display:none; }

  /* Shrink buttons on mobile so textarea has room */
  .attach-btn, .emoji-btn, .send-btn, .voice-btn {
    width:38px; height:38px;
    font-size:16px;
    flex-shrink:0;
  }

  /* Input row gap */
  .input-row { gap:6px; }

  /* Force textarea wrapper to always take remaining space */
  .msg-input-wrap {
    flex:1 1 0;
    min-width:80px;
  }

  .msg-input {
    font-size:16px; /* prevents iOS auto-zoom on focus */
    min-width:0;
    width:100%;
  }

  /* Pip smaller on mobile */
  .pip { width:90px; height:68px; bottom:72px; right:8px; }

  /* Video modal full height on mobile */
  .video-modal {
    height:100dvh;
    height:100vh;
    border-radius:0;
    max-width:100%;
  }

  .modal-overlay { padding:0; align-items:stretch; }
}

@media (max-width:360px) {
  .h-actions .h-btn:last-child { display:none; }
  .msg-wrap { max-width:92%; }
}

@media (min-width:768px) {
  .sidebar-backdrop { display:none !important; }
  .back-btn { display:none !important; }
}

/* =========================
   MOBILE RESPONSIVENESS FIX ONLY
   (DO NOT CHANGE UI STRUCTURE)
========================= */

html, body {
    overflow-x: hidden;
}

/* IMPORTANT: allow flex children to shrink properly */
.shell,
.sidebar,
.chat-area {
    min-height: 0;
}

/* Fix scrolling inside chat/messages */
.messages {
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
}

/* Prevent flex overflow issues */
.sidebar,
.chat-area {
    min-width: 0;
}

/* =========================
   MOBILE FIX
========================= */
@media (max-width: 768px) {

    .shell {
        flex-direction: column;
        height: 100vh;
    }

    .sidebar {
        width: 100%;
        height: 35vh;
        flex-shrink: 0;
    }

    .chat-area {
        width: 100%;
        height: 65vh;
        flex-shrink: 0;
    }

    /* Fix message area scrolling */
    .messages {
        height: calc(65vh - 120px);
    }

    /* Prevent input overflow */
    .input-area {
        flex-shrink: 0;
    }

    /* Keep messages readable */
    .message {
        max-width: 85%;
    }

    /* Prevent input stretching issues */
    .input-area input {
        min-width: 0;
    }
}
</style>
</head>
<body>

<div class="sidebar-backdrop" id="sidebarBackdrop" onclick="closeSidebar()"></div>

<div class="shell">

  <!-- ─── Sidebar ─────────────────────────────────────────────── -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#2563eb,#7c3aed);display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;">⚕</div>
      <span class="sidebar-title">Tele<span>Med</span></span>
    </div>

    <div class="search-bar">
      <input type="text" placeholder="🔍  Search conversations...">
    </div>

    <div class="contact-list">
      <div class="contact-item active" onclick="closeSidebar()">
        <div class="c-avatar">
          {{ strtoupper(substr($otherUser->name, 0, 1)) }}
          @if($otherUser->is_online)
            <div class="online-dot"></div>
          @endif
        </div>
        <div class="c-info">
          <div class="c-name">{{ $otherUser->role === 'doctor' ? 'Dr. ' : '' }}{{ $otherUser->name }}</div>
          <div class="c-preview">{{ $otherUser->role === 'doctor' ? ($otherUser->specialization ?? 'General Practitioner') : 'Patient' }}</div>
        </div>
        <div class="c-time">Now</div>
      </div>
    </div>
  </div>

  <!-- ─── Main Chat ─────────────────────────────────────────────── -->
  <div class="chat-main">

    <!-- Header -->
    <div class="chat-header">
      <!-- Mobile menu button -->
      <button class="back-btn" onclick="openSidebar()" aria-label="Open contacts">☰</button>

      <div class="h-avatar">
        {{ strtoupper(substr($otherUser->name, 0, 1)) }}
        @if($otherUser->is_online)
          <div class="online-dot"></div>
        @endif
      </div>
      <div class="h-info">
        <div class="h-name">{{ $otherUser->role === 'doctor' ? 'Dr. ' : '' }}{{ $otherUser->name }}</div>
        @if($otherUser->is_online)
          <div class="h-status" style="color:var(--green)">● Online</div>
        @else
          <div class="h-status" style="color:var(--text-muted)">● Offline
            @if($otherUser->last_seen)
              · {{ $otherUser->last_seen->diffForHumans() }}
            @endif
          </div>
        @endif
      </div>
      <div class="h-actions">
        <button class="h-btn" title="Voice Call" onclick="initiateCall('audio')">📞</button>
        <button class="h-btn" title="Video Call" onclick="initiateCall('video')">🎥</button>
        <button class="h-btn" title="More options">⋯</button>
      </div>
    </div>

    <!-- Messages -->
    <div class="chat-body" id="chatBody">

      <div class="date-divider"><span>Today</span></div>

      @foreach($messages as $msg)
      @php $isMine = $msg->sender_id == Auth::id(); @endphp
      <div class="msg-wrap {{ $isMine ? 'out' : 'in' }}">
        <div class="bubble">
          @if($msg->message)<p>{{ $msg->message }}</p>@endif

          @if($msg->file)
          @php $ext = pathinfo($msg->file, PATHINFO_EXTENSION); @endphp
          @if(in_array(strtolower($ext), ['mp3','wav','ogg','m4a','webm']))
            <div class="voice-bubble">
              <button class="v-play" onclick="playVoice(this, '{{ asset('storage/'.$msg->file) }}')">▶</button>
              <div class="v-waveform" id="wv-{{ $loop->index }}">
                @for($b=0;$b<24;$b++)
                <div class="v-bar" style="height:{{ rand(6,26) }}px"></div>
                @endfor
              </div>
              <span class="v-duration">0:00</span>
            </div>
          @else
            <div class="file-bubble">
              <div class="file-icon">
                @if(in_array(strtolower($ext),['jpg','jpeg','png','gif','webp'])) 🖼️
                @elseif(strtolower($ext)=='pdf') 📄
                @elseif(in_array(strtolower($ext),['doc','docx'])) 📝
                @else 📎 @endif
              </div>
              <div class="file-info">
                <div class="file-name">{{ basename($msg->file) }}</div>
                <div class="file-size">Tap to open</div>
              </div>
              <a class="file-dl" href="{{ asset('storage/'.$msg->file) }}" download title="Download">⬇</a>
            </div>
          @endif
          @endif
        </div>
        <div class="msg-meta">
          <span>{{ $msg->created_at->format('g:i A') }}</span>
          @if($isMine)<span class="ticks">✓✓</span>@endif
        </div>
      </div>
      @endforeach

      <div class="typing-indicator" id="typingIndicator">
        <div class="t-dot"></div>
        <div class="t-dot"></div>
        <div class="t-dot"></div>
      </div>

    </div>

    <!-- Footer -->
    <div class="chat-footer">
      <div class="recording-bar" id="recordingBar">
        <div class="rec-dot"></div>
        <span class="rec-time" id="recTime">0:00</span>
        <button class="rec-cancel" onclick="cancelRecording()">✕ Cancel</button>
      </div>

      <div class="file-preview-strip" id="filePreviewStrip">
        <div class="fp-icon" id="fpIcon">📎</div>
        <div class="fp-name" id="fpName">file.pdf</div>
        <span class="fp-remove" onclick="clearFile()">✕</span>
      </div>

      <div class="emoji-picker" id="emojiPicker">
        <div class="emoji-grid" id="emojiGrid"></div>
      </div>

      <div class="input-row">
        <button class="emoji-btn" onclick="toggleEmoji()" title="Emoji">😊</button>

        <label class="attach-btn" title="Attach file" style="cursor:pointer;">
          📎
          <input type="file" id="medicalFile" style="display:none" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.mp3,.wav" onchange="handleFile(this)">
        </label>

        <div class="msg-input-wrap">
          <textarea id="messageInput" class="msg-input" rows="1" placeholder="Type a message..." oninput="autoResize(this)" onkeydown="handleKey(event)"></textarea>
        </div>

        <button class="voice-btn" id="voiceBtn" title="Voice note" onclick="toggleRecording()">🎙️</button>
        <button class="send-btn" onclick="sendMessage()" title="Send">➤</button>
      </div>
    </div>

  </div>
</div>

<!-- ─── Video Call Modal ──────────────────────────────────────── -->
<div class="modal-overlay" id="videoModal">
  <div class="video-modal">

    <div class="vm-header">
      <div class="h-avatar" style="width:36px;height:36px;font-size:13px;">
        {{ strtoupper(substr($otherUser->name, 0, 1)) }}
      </div>
      <div class="vm-info">
        <div class="vm-name">{{ $otherUser->role === 'doctor' ? 'Dr. ' : '' }}{{ $otherUser->name }}</div>
        <div class="vm-status" id="callStatusText">Calling...</div>
      </div>
      <div class="vm-timer" id="callTimer">0:00</div>
    </div>

    <div class="video-grid" id="videoGrid">
      <div class="video-slot" style="grid-column:1/-1;">
        <video id="remoteVideo" autoplay playsinline></video>
        <div class="no-video" id="remoteNoVideo">
          <div class="big-avatar">{{ strtoupper(substr($otherUser->name, 0, 1)) }}</div>
          <span>{{ $otherUser->role === 'doctor' ? 'Dr. ' : '' }}{{ $otherUser->name }}</span>
        </div>
        <span class="slot-label">{{ $otherUser->role === 'doctor' ? 'Dr. ' : '' }}{{ $otherUser->name }}</span>
      </div>
    </div>

    <div class="pip">
      <video id="localVideo" autoplay playsinline muted></video>
      <div class="pip-placeholder" id="localNoVideo">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
      <span class="pip-label">You</span>
    </div>

    <div class="call-controls">
      <button class="ctrl-btn mute" id="muteBtn" onclick="toggleMute()" title="Mute">🎤</button>
      <button class="ctrl-btn cam"  id="camBtn"  onclick="toggleCam()"  title="Camera">📹</button>
      <button class="ctrl-btn end"               onclick="endCall()"    title="End call">📵</button>
    </div>

  </div>
</div>

<!-- ─── Incoming Call Toast ──────────────────────────────────── -->
<div class="incoming-call" id="incomingCall">
  <div class="ic-header">
    <div class="ic-avatar">{{ strtoupper(substr($otherUser->name, 0, 1)) }}</div>
    <div class="ic-info">
      <div class="ic-name">{{ $otherUser->role === 'doctor' ? 'Dr. ' : '' }}{{ $otherUser->name }}</div>
      <div class="ic-type" id="icType">Incoming video call...</div>
    </div>
  </div>
  <div class="ic-actions">
    <button class="ic-btn decline" onclick="declineCall()">✕ Decline</button>
    <button class="ic-btn answer"  onclick="answerCall()">📞 Answer</button>
  </div>
</div>

<input type="hidden" id="receiverId" value="{{ $otherUser->id }}">

<script>
const USER_ID     = {{ Auth::id() }};
const RECEIVER_ID = {{ $otherUser->id }};
const CSRF        = document.querySelector('meta[name="csrf-token"]').content;

/* ── Sidebar toggle (mobile) ── */
function openSidebar() {
  document.getElementById('sidebar').classList.add('open');
  document.getElementById('sidebarBackdrop').classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('sidebarBackdrop').classList.remove('active');
  document.body.style.overflow = '';
}

/* Close sidebar on swipe left */
(function() {
  let startX = 0;
  const sidebar = document.getElementById('sidebar');
  sidebar.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive:true });
  sidebar.addEventListener('touchend', e => {
    if (startX - e.changedTouches[0].clientX > 60) closeSidebar();
  }, { passive:true });
})();

/* ── Textarea auto-resize ── */
function autoResize(el) {
  el.style.height = 'auto';
  el.style.height = Math.min(el.scrollHeight, 110) + 'px';
}

function handleKey(e) {
  if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
}

/* ── Emoji picker ── */
const EMOJIS = ['😊','😂','❤️','👍','🙏','😢','😍','🔥','✅','💊','🏥','🩺','💉','🩹','🧬','😷','🤒','🤧','💪','👨‍⚕️','👩‍⚕️','📋','💬','📞'];

(function buildEmoji() {
  const g = document.getElementById('emojiGrid');
  EMOJIS.forEach(em => {
    const d = document.createElement('div');
    d.className = 'ep-emoji'; d.textContent = em;
    d.onclick = () => {
      document.getElementById('messageInput').value += em;
      toggleEmoji();
      document.getElementById('messageInput').focus();
    };
    g.appendChild(d);
  });
})();

function toggleEmoji() {
  document.getElementById('emojiPicker').classList.toggle('active');
}

document.addEventListener('click', e => {
  if (!e.target.closest('.emoji-btn') && !e.target.closest('.emoji-picker')) {
    document.getElementById('emojiPicker').classList.remove('active');
  }
});

/* ── File handling ── */
const FILE_ICONS = { pdf:'📄', jpg:'🖼️', jpeg:'🖼️', png:'🖼️', doc:'📝', docx:'📝', mp3:'🎵', wav:'🎵' };

function handleFile(input) {
  const file = input.files[0];
  if (!file) return;
  const ext = file.name.split('.').pop().toLowerCase();
  document.getElementById('fpIcon').textContent = FILE_ICONS[ext] || '📎';
  document.getElementById('fpName').textContent = file.name;
  document.getElementById('filePreviewStrip').classList.add('active');
}

function clearFile() {
  document.getElementById('medicalFile').value = '';
  document.getElementById('filePreviewStrip').classList.remove('active');
}

/* ── Send message ── */
async function sendMessage() {
  const input = document.getElementById('messageInput');
  const fileInput = document.getElementById('medicalFile');
  const body = input.value.trim();
  const file = fileInput.files[0];
  if (!body && !file) return;

  const fd = new FormData();
  fd.append('_token', CSRF);
  fd.append('receiver_id', RECEIVER_ID);
  if (body) fd.append('message', body);
  if (file) fd.append('file', file);

  appendMessage({ message: body, file: null }, true);
  input.value = ''; input.style.height = 'auto';
  clearFile();

  try {
    await fetch('{{ url("chat/send") }}', { method: 'POST', body: fd });
  } catch(e) { console.error('Send failed', e); }

  scrollBottom();
}

/* ── Append message ── */
function appendMessage(msg, isMine, isVoice = false, voiceUrl = null) {
  const chatBody = document.getElementById('chatBody');
  const typing   = document.getElementById('typingIndicator');
  const wrap     = document.createElement('div');
  wrap.className = 'msg-wrap ' + (isMine ? 'out' : 'in');

  const now  = new Date();
  const time = now.toLocaleTimeString([], { hour:'numeric', minute:'2-digit' });
  let content = '';

  if (isVoice && voiceUrl) {
    const bars = Array.from({length:24}, () =>
      `<div class="v-bar" style="height:${6 + Math.random()*20}px"></div>`
    ).join('');
    content = `<div class="voice-bubble">
      <button class="v-play" onclick="playVoice(this, '${voiceUrl}')">▶</button>
      <div class="v-waveform">${bars}</div>
      <span class="v-duration">0:00</span>
    </div>`;
  } else if (msg.message) {
    content = `<p>${escHtml(msg.message)}</p>`;
  }

  wrap.innerHTML = `<div class="bubble">${content}</div>
    <div class="msg-meta">
      <span>${time}</span>
      ${isMine ? '<span class="ticks">✓</span>' : ''}
    </div>`;

  chatBody.insertBefore(wrap, typing);
  scrollBottom();
}

function escHtml(str) {
  return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function scrollBottom() {
  const cb = document.getElementById('chatBody');
  requestAnimationFrame(() => { cb.scrollTop = cb.scrollHeight; });
}

/* ── Voice recording ── */
let mediaRecorder = null, audioChunks = [], recInterval = null, recSeconds = 0, isRecording = false;

async function toggleRecording() {
  if (isRecording) { stopRecording(); return; }
  try {
    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    mediaRecorder = new MediaRecorder(stream);
    audioChunks   = [];

    mediaRecorder.ondataavailable = e => audioChunks.push(e.data);
    mediaRecorder.onstop = async () => {
      const blob = new Blob(audioChunks, { type: 'audio/webm' });
      const url  = URL.createObjectURL(blob);
      appendMessage({}, true, true, url);
      await uploadVoice(blob);
      stream.getTracks().forEach(t => t.stop());
    };

    mediaRecorder.start();
    isRecording = true;
    recSeconds  = 0;

    document.getElementById('voiceBtn').classList.add('recording');
    document.getElementById('recordingBar').classList.add('active');

    recInterval = setInterval(() => {
      recSeconds++;
      const m = Math.floor(recSeconds / 60);
      const s = recSeconds % 60;
      document.getElementById('recTime').textContent = `${m}:${s.toString().padStart(2,'0')}`;
    }, 1000);

  } catch(e) {
    alert('Microphone access denied. Please allow microphone in your browser settings.');
  }
}

function stopRecording() {
  if (mediaRecorder && mediaRecorder.state !== 'inactive') mediaRecorder.stop();
  isRecording = false;
  clearInterval(recInterval);
  document.getElementById('voiceBtn').classList.remove('recording');
  document.getElementById('recordingBar').classList.remove('active');
}

function cancelRecording() {
  if (mediaRecorder && mediaRecorder.state !== 'inactive') {
    mediaRecorder.ondataavailable = null;
    mediaRecorder.onstop = null;
    mediaRecorder.stop();
  }
  isRecording = false;
  clearInterval(recInterval);
  document.getElementById('voiceBtn').classList.remove('recording');
  document.getElementById('recordingBar').classList.remove('active');
  audioChunks = [];
}

async function uploadVoice(blob) {
  const fd = new FormData();
  fd.append('_token', CSRF);
  fd.append('receiver_id', RECEIVER_ID);
  fd.append('file', blob, 'voice-note.webm');
  try { await fetch('{{ url("chat/send") }}', { method: 'POST', body: fd }); }
  catch(e) { console.error('Voice upload failed', e); }
}

function playVoice(btn, url) {
  if (btn._audio) {
    if (btn._audio.paused) { btn._audio.play(); btn.textContent = '⏸'; btn.classList.add('playing'); }
    else                   { btn._audio.pause(); btn.textContent = '▶'; btn.classList.remove('playing'); }
    return;
  }
  const audio = new Audio(url);
  btn._audio  = audio;
  const dur   = btn.closest('.voice-bubble').querySelector('.v-duration');

  audio.play();
  btn.textContent = '⏸'; btn.classList.add('playing');

  audio.ontimeupdate = () => {
    const t = Math.floor(audio.currentTime);
    dur.textContent = `${Math.floor(t/60)}:${(t%60).toString().padStart(2,'0')}`;
    const bars   = btn.closest('.voice-bubble').querySelectorAll('.v-bar');
    const prog   = audio.currentTime / (audio.duration || 1);
    const played = Math.floor(prog * bars.length);
    bars.forEach((b,i) => b.classList.toggle('played', i < played));
  };

  audio.onended = () => {
    btn.textContent = '▶'; btn.classList.remove('playing');
    btn.closest('.voice-bubble').querySelectorAll('.v-bar').forEach(b => b.classList.remove('played'));
  };
}

/* ── WebRTC / Calls ── */
let localStream = null, peerConnection = null, callTimerInterval = null;
let callSeconds = 0, isMuted = false, isCamOff = false;
let currentCallType = 'video', incomingCallerId = null, isCallerRole = false;

const RTC_CONFIG = {
  iceServers: [
    { urls: 'stun:stun.l.google.com:19302' },
    { urls: 'stun:stun1.l.google.com:19302' },
  ]
};

async function sendSignal(toId, type, payload) {
  await fetch('{{ url("chat/signal") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
    body: JSON.stringify({ to_id: toId, type: type, payload: { data: JSON.stringify(payload) } }),
  });
}

function createPeer(remoteUserId) {
  const pc = new RTCPeerConnection(RTC_CONFIG);
  if (localStream) localStream.getTracks().forEach(track => pc.addTrack(track, localStream));

  pc.ontrack = (e) => {
    document.getElementById('remoteVideo').srcObject = e.streams[0];
    document.getElementById('remoteNoVideo').style.display = 'none';
    document.getElementById('callStatusText').textContent = '● Connected';
    if (!callTimerInterval) startCallTimer();
  };

  pc.onicecandidate = (e) => {
    if (e.candidate) sendSignal(remoteUserId, 'ice', { candidate: e.candidate });
  };

  pc.onconnectionstatechange = () => {
    if (pc.connectionState === 'disconnected' || pc.connectionState === 'failed') endCall();
  };

  return pc;
}

async function initiateCall(type) {
  currentCallType = type;
  isCallerRole    = true;

  try {
    await fetch('{{ url("chat/call") }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
      body: JSON.stringify({ receiver_id: RECEIVER_ID, call_type: type }),
    });
  } catch(e) { console.error('Call signal failed', e); }

  document.getElementById('callStatusText').textContent = type === 'video' ? '📹 Calling...' : '📞 Calling...';
  document.getElementById('videoModal').classList.add('active');

  try {
    localStream = await navigator.mediaDevices.getUserMedia({ video: type === 'video', audio: true });
    document.getElementById('localVideo').srcObject = localStream;
    document.getElementById('localNoVideo').style.display = type === 'video' ? 'none' : 'flex';
    document.getElementById('callStatusText').textContent = '⏳ Waiting for answer...';
  } catch(e) {
    alert('Camera/microphone access denied.');
    endCall();
  }
}

async function onCallAnswered() {
  document.getElementById('callStatusText').textContent = '🔗 Connecting...';
  peerConnection = createPeer(RECEIVER_ID);
  const offer = await peerConnection.createOffer();
  await peerConnection.setLocalDescription(offer);
  await sendSignal(RECEIVER_ID, 'offer', { sdp: peerConnection.localDescription.toJSON() });
}

async function answerCall() {
  document.getElementById('incomingCall').classList.remove('active');
  document.getElementById('callStatusText').textContent = '🔗 Connecting...';
  document.getElementById('videoModal').classList.add('active');
  isCallerRole = false;

  try {
    localStream = await navigator.mediaDevices.getUserMedia({ video: currentCallType === 'video', audio: true });
    document.getElementById('localVideo').srcObject = localStream;
    document.getElementById('localNoVideo').style.display = currentCallType === 'video' ? 'none' : 'flex';

    await fetch('{{ url("chat/call") }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
      body: JSON.stringify({ receiver_id: incomingCallerId, call_type: 'answered' }),
    });
  } catch(e) {
    alert('Camera/microphone access denied.');
    endCall();
  }
}

async function handleOffer(fromId, rawPayload) {
  const payload = JSON.parse(rawPayload.data);
  peerConnection = createPeer(fromId);
  await peerConnection.setRemoteDescription(new RTCSessionDescription(payload.sdp));
  const answer = await peerConnection.createAnswer();
  await peerConnection.setLocalDescription(answer);
  await sendSignal(fromId, 'answer', { sdp: peerConnection.localDescription.toJSON() });
}

async function handleAnswer(rawPayload) {
  const payload = JSON.parse(rawPayload.data);
  if (!peerConnection) return;
  await peerConnection.setRemoteDescription(new RTCSessionDescription(payload.sdp));
}

async function handleIce(rawPayload) {
  const payload = JSON.parse(rawPayload.data);
  if (!peerConnection) return;
  try { await peerConnection.addIceCandidate(new RTCIceCandidate(payload.candidate)); }
  catch(e) { console.warn('ICE error', e); }
}

function endCall() {
  if (peerConnection)  { peerConnection.close(); peerConnection = null; }
  if (localStream)     { localStream.getTracks().forEach(t => t.stop()); localStream = null; }
  clearInterval(callTimerInterval); callTimerInterval = null;

  document.getElementById('videoModal').classList.remove('active');
  document.getElementById('remoteVideo').srcObject = null;
  document.getElementById('localVideo').srcObject  = null;
  document.getElementById('remoteNoVideo').style.display = 'flex';
  document.getElementById('localNoVideo').style.display  = 'flex';
  document.getElementById('callTimer').textContent       = '0:00';
  document.getElementById('callStatusText').textContent  = 'Calling...';

  isMuted = false; isCamOff = false; isCallerRole = false;
  document.getElementById('muteBtn').textContent = '🎤';
  document.getElementById('camBtn').textContent  = '📹';
  document.getElementById('muteBtn').classList.remove('off');
  document.getElementById('camBtn').classList.remove('off');
}

function declineCall() {
  document.getElementById('incomingCall').classList.remove('active');
}

function startCallTimer() {
  callSeconds = 0;
  callTimerInterval = setInterval(() => {
    callSeconds++;
    const m = Math.floor(callSeconds / 60);
    const s = callSeconds % 60;
    document.getElementById('callTimer').textContent = `${m}:${s.toString().padStart(2,'0')}`;
  }, 1000);
}

function showIncomingCall(type) {
  document.getElementById('icType').textContent = type === 'video' ? '📹 Incoming video call...' : '📞 Incoming voice call...';
  document.getElementById('incomingCall').classList.add('active');
}

function toggleMute() {
  if (!localStream) return;
  isMuted = !isMuted;
  localStream.getAudioTracks().forEach(t => t.enabled = !isMuted);
  const btn = document.getElementById('muteBtn');
  btn.textContent = isMuted ? '🔇' : '🎤';
  btn.classList.toggle('off', isMuted);
}

function toggleCam() {
  if (!localStream) return;
  isCamOff = !isCamOff;
  localStream.getVideoTracks().forEach(t => t.enabled = !isCamOff);
  const btn = document.getElementById('camBtn');
  btn.textContent = isCamOff ? '🚫' : '📹';
  btn.classList.toggle('off', isCamOff);
  document.getElementById('localNoVideo').style.display = isCamOff ? 'flex' : 'none';
}

/* ── Init ── */
window.addEventListener('load', function () {
  scrollBottom();

  if (!window.Echo) return;

  window.Echo.channel('chat.' + USER_ID)

    .listen('.message.sent', (e) => {
      if (e.message.sender_id !== USER_ID) {
        document.getElementById('typingIndicator').classList.remove('active');
        const isVoice = e.message.file && /\.(webm|mp3|wav|ogg|m4a)$/i.test(e.message.file);
        appendMessage(e.message, false, isVoice, isVoice ? '/storage/' + e.message.file : null);
      }
    })

    .listen('.user.typing', (e) => {
      if (e.user_id !== USER_ID) {
        document.getElementById('typingIndicator').classList.add('active');
        scrollBottom();
        clearTimeout(window._typingTimer);
        window._typingTimer = setTimeout(() => {
          document.getElementById('typingIndicator').classList.remove('active');
        }, 2500);
      }
    })

    .listen('.call.incoming', (e) => {
      if (e.receiver_id === USER_ID && e.call_type !== 'answered') {
        incomingCallerId = e.caller_id;
        currentCallType  = e.call_type;
        showIncomingCall(e.call_type);
      }
      if (e.receiver_id === USER_ID && e.call_type === 'answered') {
        onCallAnswered();
      }
    })

    .listen('.webrtc.signal', async (e) => {
      if (e.to_id !== USER_ID) return;
      if (e.type === 'offer')       await handleOffer(e.from_id, e.payload);
      else if (e.type === 'answer') await handleAnswer(e.payload);
      else if (e.type === 'ice')    await handleIce(e.payload);
    });
});
</script>

</body>
</html>
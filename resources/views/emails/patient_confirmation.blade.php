<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Appointment Confirmed</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap');

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: #f0f4f8;
    color: #1a2332;
    padding: 40px 20px;
  }

  .wrapper { max-width: 580px; margin: 0 auto; }

  .header {
    background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
    border-radius: 16px 16px 0 0;
    padding: 36px 40px;
    text-align: center;
  }

  .header .logo {
    font-family: 'DM Serif Display', serif;
    font-size: 22px;
    color: #a5d6a7;
    letter-spacing: 1px;
    margin-bottom: 20px;
  }

  .header .icon {
    width: 64px; height: 64px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-bottom: 16px;
  }

  .header h1 {
    font-family: 'DM Serif Display', serif;
    font-size: 26px;
    color: #ffffff;
    font-weight: 400;
  }

  .header p { color: #c8e6c9; font-size: 14px; margin-top: 8px; }

  .body { background: #ffffff; padding: 40px; }

  .greeting { font-size: 16px; color: #4a5568; margin-bottom: 24px; line-height: 1.6; }
  .greeting strong { color: #1b5e20; }

  .detail-card {
    background: #f7fff7;
    border: 1px solid #c8e6c9;
    border-left: 4px solid #2e7d32;
    border-radius: 10px;
    padding: 24px;
    margin: 24px 0;
  }

  .detail-card h3 {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #2e7d32;
    margin-bottom: 16px;
    font-weight: 600;
  }

  .detail-row {
    display: flex;
    align-items: flex-start;
    padding: 10px 0;
    border-bottom: 1px solid #e8f5e9;
  }

  .detail-row:last-child { border-bottom: none; }

  .detail-label {
    font-size: 12px;
    color: #7a8fa6;
    font-weight: 500;
    width: 110px;
    flex-shrink: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding-top: 2px;
  }

  .detail-value { font-size: 15px; color: #1a2332; font-weight: 500; flex: 1; }

  .tips-box {
    background: #e3f2fd;
    border: 1px solid #bbdefb;
    border-radius: 10px;
    padding: 20px;
    margin: 20px 0;
  }

  .tips-box h4 {
    font-size: 13px;
    color: #0d47a1;
    font-weight: 600;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .tips-box ul { padding-left: 18px; }
  .tips-box li { font-size: 13px; color: #1565c0; line-height: 1.8; }

  .cta-wrap { text-align: center; margin: 32px 0; }

  .cta-btn {
    display: inline-block;
    background: linear-gradient(135deg, #1b5e20, #2e7d32);
    color: #ffffff !important;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    padding: 16px 40px;
    border-radius: 50px;
  }

  .cta-hint { font-size: 12px; color: #a0aec0; margin-top: 10px; }

  .footer {
    background: #f7fff7;
    border-top: 1px solid #c8e6c9;
    border-radius: 0 0 16px 16px;
    padding: 28px 40px;
    text-align: center;
  }

  .footer p { font-size: 12px; color: #a0aec0; line-height: 1.8; }
  .footer a { color: #2e7d32; text-decoration: none; }
</style>
</head>
<body>
<div class="wrapper">

  <div class="header">
    <div class="logo">⚕ TeleMed</div>
    <div class="icon">✅</div>
    <h1>Appointment Confirmed!</h1>
    <p>Your consultation has been successfully scheduled</p>
  </div>

  <div class="body">

    <p class="greeting">
      Hello, <strong>{{ $patient_name }}</strong> —<br>
      Your appointment has been confirmed. Here are your booking details:
    </p>

    <div class="detail-card">
      <h3>Your Appointment</h3>

      <div class="detail-row">
        <span class="detail-label">Doctor</span>
        <span class="detail-value">Dr. {{ $doctor_name }}</span>
      </div>

      <div class="detail-row">
        <span class="detail-label">Specialty</span>
        <span class="detail-value">{{ $doctor_specialty }}</span>
      </div>

      <div class="detail-row">
        <span class="detail-label">Date</span>
        <span class="detail-value">{{ $appointment_date }}</span>
      </div>

      <div class="detail-row">
        <span class="detail-label">Time</span>
        <span class="detail-value">{{ $appointment_time }}</span>
      </div>

      <div class="detail-row">
        <span class="detail-label">Reason</span>
        <span class="detail-value">{{ $reason }}</span>
      </div>
    </div>

    <div class="tips-box">
      <h4>📋 Before Your Appointment</h4>
      <ul>
        <li>Test your camera and microphone beforehand</li>
        <li>Find a quiet, well-lit space for the consultation</li>
        <li>Have any relevant medical records ready</li>
        <li>Join 5 minutes early to avoid delays</li>
      </ul>
    </div>

    <div class="cta-wrap">
      <a href="{{ $join_link }}" class="cta-btn">Join Your Consultation</a>
      <p class="cta-hint">Use this link at the time of your appointment</p>
    </div>

  </div>

  <div class="footer">
    <p>
      <strong>TeleMed Platform</strong> — Quality Care, Anywhere<br>
      Need help? <a href="mailto:support@telemed.com">support@telemed.com</a><br>
      Appointment ID: #{{ $appointment_id }}
    </p>
  </div>

</div>
</body>
</html>

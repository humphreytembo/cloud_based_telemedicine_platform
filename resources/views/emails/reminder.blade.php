<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Appointment Reminder</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap');

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body { font-family: 'DM Sans', sans-serif; background: #f0f4f8; color: #1a2332; padding: 40px 20px; }

  .wrapper { max-width: 580px; margin: 0 auto; }

  .header {
    background: linear-gradient(135deg, #e65100 0%, #f57c00 100%);
    border-radius: 16px 16px 0 0;
    padding: 36px 40px;
    text-align: center;
  }

  .header .logo { font-family: 'DM Serif Display', serif; font-size: 22px; color: #ffe0b2; letter-spacing: 1px; margin-bottom: 20px; }
  .header .icon { width: 64px; height: 64px; background: rgba(255,255,255,0.15); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 16px; }
  .header h1 { font-family: 'DM Serif Display', serif; font-size: 26px; color: #fff; font-weight: 400; }
  .header p { color: #ffe0b2; font-size: 14px; margin-top: 8px; }

  .body { background: #fff; padding: 40px; }

  .greeting { font-size: 16px; color: #4a5568; margin-bottom: 24px; line-height: 1.6; }
  .greeting strong { color: #e65100; }

  .countdown {
    background: linear-gradient(135deg, #fff3e0, #ffe0b2);
    border: 1px solid #ffcc80;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    margin: 20px 0;
  }

  .countdown .time { font-family: 'DM Serif Display', serif; font-size: 42px; color: #e65100; }
  .countdown .label { font-size: 13px; color: #bf360c; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }

  .detail-card {
    background: #fff8f5;
    border: 1px solid #ffccbc;
    border-left: 4px solid #f57c00;
    border-radius: 10px;
    padding: 24px;
    margin: 24px 0;
  }

  .detail-card h3 { font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #f57c00; margin-bottom: 16px; font-weight: 600; }

  .detail-row { display: flex; align-items: flex-start; padding: 10px 0; border-bottom: 1px solid #fce3d8; }
  .detail-row:last-child { border-bottom: none; }
  .detail-label { font-size: 12px; color: #7a8fa6; font-weight: 500; width: 110px; flex-shrink: 0; text-transform: uppercase; letter-spacing: 0.5px; padding-top: 2px; }
  .detail-value { font-size: 15px; color: #1a2332; font-weight: 500; flex: 1; }

  .cta-wrap { text-align: center; margin: 32px 0; }

  .cta-btn {
    display: inline-block;
    background: linear-gradient(135deg, #e65100, #f57c00);
    color: #fff !important;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    padding: 16px 40px;
    border-radius: 50px;
  }

  .footer { background: #fff8f5; border-top: 1px solid #ffccbc; border-radius: 0 0 16px 16px; padding: 28px 40px; text-align: center; }
  .footer p { font-size: 12px; color: #a0aec0; line-height: 1.8; }
  .footer a { color: #f57c00; text-decoration: none; }
</style>
</head>
<body>
<div class="wrapper">

  <div class="header">
    <div class="logo">⚕ TeleMed</div>
    <div class="icon">⏰</div>
    <h1>Appointment Reminder</h1>
    <p>Your consultation is coming up soon</p>
  </div>

  <div class="body">

    <p class="greeting">
      Hello, <strong>
        @if($recipient_type === 'doctor') Dr. {{ $doctor_name }}
        @else {{ $patient_name }}
        @endif
      </strong> —<br>
      This is a friendly reminder that you have an upcoming appointment in <strong>1 hour</strong>.
    </p>

    <div class="countdown">
      <div class="time">1 Hour</div>
      <div class="label">Until Your Appointment</div>
    </div>

    <div class="detail-card">
      <h3>Appointment Details</h3>

      @if($recipient_type === 'doctor')
      <div class="detail-row">
        <span class="detail-label">Patient</span>
        <span class="detail-value">{{ $patient_name }}</span>
      </div>
      @else
      <div class="detail-row">
        <span class="detail-label">Doctor</span>
        <span class="detail-value">Dr. {{ $doctor_name }}</span>
      </div>
      @endif

      <div class="detail-row">
        <span class="detail-label">Date</span>
        <span class="detail-value">{{ $appointment_date }}</span>
      </div>

      <div class="detail-row">
        <span class="detail-label">Time</span>
        <span class="detail-value">{{ $appointment_time }}</span>
      </div>
    </div>

    <div class="cta-wrap">
      <a href="{{ $join_link }}" class="cta-btn">Join Consultation Now</a>
    </div>

  </div>

  <div class="footer">
    <p>
      <strong>TeleMed Platform</strong><br>
      <a href="mailto:support@telemed.com">support@telemed.com</a>
    </p>
  </div>

</div>
</body>
</html>

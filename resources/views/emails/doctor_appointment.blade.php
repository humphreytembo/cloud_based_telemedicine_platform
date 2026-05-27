<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>New Appointment</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap');

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: #f0f4f8;
    color: #1a2332;
    padding: 40px 20px;
  }

  .wrapper {
    max-width: 580px;
    margin: 0 auto;
  }

  /* Header */
  .header {
    background: linear-gradient(135deg, #0a3d62 0%, #1565c0 100%);
    border-radius: 16px 16px 0 0;
    padding: 36px 40px;
    text-align: center;
  }

  .header .logo {
    font-family: 'DM Serif Display', serif;
    font-size: 22px;
    color: #7ec8f7;
    letter-spacing: 1px;
    margin-bottom: 20px;
  }

  .header .icon {
    width: 64px;
    height: 64px;
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
    line-height: 1.3;
  }

  .header p {
    color: #a8d4f5;
    font-size: 14px;
    margin-top: 8px;
  }

  /* Body */
  .body {
    background: #ffffff;
    padding: 40px;
  }

  .greeting {
    font-size: 16px;
    color: #4a5568;
    margin-bottom: 24px;
    line-height: 1.6;
  }

  .greeting strong {
    color: #0a3d62;
  }

  /* Detail card */
  .detail-card {
    background: #f7faff;
    border: 1px solid #d0e4ff;
    border-left: 4px solid #1565c0;
    border-radius: 10px;
    padding: 24px;
    margin: 24px 0;
  }

  .detail-card h3 {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #1565c0;
    margin-bottom: 16px;
    font-weight: 600;
  }

  .detail-row {
    display: flex;
    align-items: flex-start;
    padding: 10px 0;
    border-bottom: 1px solid #e8f0fe;
  }

  .detail-row:last-child { border-bottom: none; }

  .detail-label {
    font-size: 12px;
    color: #7a8fa6;
    font-weight: 500;
    width: 110px;
    flex-shrink: 0;
    padding-top: 2px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .detail-value {
    font-size: 15px;
    color: #1a2332;
    font-weight: 500;
    flex: 1;
    line-height: 1.5;
  }

  .badge {
    display: inline-block;
    background: #e8f5e9;
    color: #2e7d32;
    font-size: 12px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
  }

  /* CTA Button */
  .cta-wrap {
    text-align: center;
    margin: 32px 0;
  }

  .cta-btn {
    display: inline-block;
    background: linear-gradient(135deg, #0a3d62, #1565c0);
    color: #ffffff !important;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    padding: 16px 40px;
    border-radius: 50px;
    letter-spacing: 0.3px;
  }

  .cta-hint {
    font-size: 12px;
    color: #a0aec0;
    margin-top: 10px;
  }

  /* Notes */
  .notes-box {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 10px;
    padding: 16px 20px;
    margin: 20px 0;
  }

  .notes-box p {
    font-size: 13px;
    color: #92400e;
    line-height: 1.6;
  }

  .notes-box strong {
    display: block;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 6px;
    color: #b45309;
  }

  /* Footer */
  .footer {
    background: #f7faff;
    border-top: 1px solid #e2ecff;
    border-radius: 0 0 16px 16px;
    padding: 28px 40px;
    text-align: center;
  }

  .footer p {
    font-size: 12px;
    color: #a0aec0;
    line-height: 1.8;
  }

  .footer a {
    color: #1565c0;
    text-decoration: none;
  }
</style>
</head>
<body>
<div class="wrapper">

  <!-- HEADER -->
  <div class="header">
    <div class="logo">⚕ TeleMed</div>
    <div class="icon">📅</div>
    <h1>New Appointment Booked</h1>
    <p>A patient has scheduled a consultation with you</p>
  </div>

  <!-- BODY -->
  <div class="body">

    <p class="greeting">
      Hello, <strong>Dr. {{ $doctor_name }}</strong> —<br>
      A new appointment has been confirmed on your schedule. Please review the details below and be available at the listed time.
    </p>

    <!-- Appointment Details -->
    <div class="detail-card">
      <h3>Appointment Details</h3>

      <div class="detail-row">
        <span class="detail-label">Patient</span>
        <span class="detail-value">{{ $patient_name }}</span>
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

      <div class="detail-row">
        <span class="detail-label">Status</span>
        <span class="detail-value"><span class="badge">✓ Confirmed</span></span>
      </div>
    </div>

    @if(!empty($notes))
    <div class="notes-box">
      <strong>Patient Notes</strong>
      <p>{{ $notes }}</p>
    </div>
    @endif

    <!-- Join Button -->
    <div class="cta-wrap">
      <a href="{{ $join_link }}" class="cta-btn">Join Consultation Session</a>
      <p class="cta-hint">This link will be active at the time of the appointment</p>
    </div>

  </div>

  <!-- FOOTER -->
  <div class="footer">
    <p>
      This notification was sent by <strong>TeleMed Platform</strong>.<br>
      If you have questions, contact <a href="mailto:support@telemed.com">support@telemed.com</a><br>
      Appointment ID: #{{ $appointment_id }}
    </p>
  </div>

</div>
</body>
</html>

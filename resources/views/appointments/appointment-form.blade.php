<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Book Appointment — TeleMed</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
  <style>
    :root {
      --blue-dark:  #0a3d62;
      --blue:       #1565c0;
      --blue-light: #e8f0fe;
      --green:      #2e7d32;
      --red:        #c62828;
      --text:       #1a2332;
      --muted:      #6b7a90;
      --border:     #d0e4ff;
      --bg:         #f4f7fb;
      --white:      #ffffff;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      align-items: flex-start;
      justify-content: center;
      padding: 48px 16px;
    }

    .card {
      background: var(--white);
      border-radius: 20px;
      box-shadow: 0 4px 40px rgba(21,101,192,0.10);
      width: 100%;
      max-width: 560px;
      overflow: hidden;
    }

    /* Card Header */
    .card-header {
      background: linear-gradient(135deg, var(--blue-dark), var(--blue));
      padding: 36px 40px;
      color: var(--white);
    }

    .card-header .logo {
      font-family: 'DM Serif Display', serif;
      font-size: 18px;
      color: #7ec8f7;
      margin-bottom: 16px;
    }

    .card-header h1 {
      font-family: 'DM Serif Display', serif;
      font-size: 26px;
      font-weight: 400;
      margin-bottom: 6px;
    }

    .card-header p {
      color: #a8d4f5;
      font-size: 14px;
    }

    /* Form Body */
    .card-body { padding: 36px 40px; }

    .form-group { margin-bottom: 22px; }

    label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: var(--muted);
      margin-bottom: 8px;
    }

    input, select, textarea {
      width: 100%;
      padding: 13px 16px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-family: 'DM Sans', sans-serif;
      font-size: 15px;
      color: var(--text);
      background: var(--white);
      transition: border-color 0.2s, box-shadow 0.2s;
      outline: none;
    }

    input:focus, select:focus, textarea:focus {
      border-color: var(--blue);
      box-shadow: 0 0 0 3px rgba(21,101,192,0.10);
    }

    textarea { resize: vertical; min-height: 90px; }

    .row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    /* Submit Button */
    #book-btn {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, var(--blue-dark), var(--blue));
      color: var(--white);
      border: none;
      border-radius: 50px;
      font-family: 'DM Sans', sans-serif;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 8px;
      transition: opacity 0.2s, transform 0.1s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    #book-btn:hover:not(:disabled) { opacity: 0.92; transform: translateY(-1px); }
    #book-btn:disabled { opacity: 0.65; cursor: not-allowed; }

    /* Spinner */
    .spinner {
      width: 18px; height: 18px;
      border: 2px solid rgba(255,255,255,0.4);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
      display: inline-block;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    /* Status Messages */
    #booking-status {
      margin-top: 20px;
      padding: 14px 18px;
      border-radius: 10px;
      font-size: 14px;
      line-height: 1.6;
      display: none;
    }

    #booking-status.status-success {
      display: block;
      background: #e8f5e9;
      border: 1px solid #c8e6c9;
      color: #1b5e20;
    }

    #booking-status.status-error {
      display: block;
      background: #ffebee;
      border: 1px solid #ffcdd2;
      color: var(--red);
    }

    /* Join Button */
    #join-session-wrap {
      display: none;
      margin-top: 16px;
      text-align: center;
    }

    #join-session-btn {
      display: inline-block;
      background: var(--green);
      color: var(--white);
      text-decoration: none;
      font-size: 15px;
      font-weight: 600;
      padding: 14px 36px;
      border-radius: 50px;
    }

    /* Divider */
    .divider {
      border: none;
      border-top: 1px solid var(--border);
      margin: 28px 0;
    }

    @media (max-width: 500px) {
      .card-header, .card-body { padding: 28px 24px; }
      .row { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<div class="card">

  <!-- Header -->
  <div class="card-header">
    <div class="logo">⚕ TeleMed</div>
    <h1>Book an Appointment</h1>
    <p>Schedule a consultation with an available doctor</p>
  </div>

  <!-- Form -->
  <div class="card-body">
    <form id="appointment-form" novalidate>

      <!-- Hidden fields (populated dynamically from your auth session) -->
      <input type="hidden" name="patient_id" id="patient_id" value="{{ auth()->id() }}">

      <!-- Doctor Selection -->
      <div class="form-group">
        <label for="doctor_id">Select Doctor</label>
        <select name="doctor_id" id="doctor_id" required>
          <option value="" disabled selected>Choose an available doctor...</option>
          {{-- Populate from your doctors table --}}
          @foreach($doctors as $doctor)
            <option value="{{ $doctor->id }}">
              Dr. {{ $doctor->name }} — {{ $doctor->specialty }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Date & Time -->
      <div class="row">
        <div class="form-group">
          <label for="appointment_date">Date</label>
          <input type="date" name="appointment_date" id="appointment_date"
                 min="{{ date('Y-m-d') }}" required>
        </div>
        <div class="form-group">
          <label for="appointment_time">Time</label>
          <input type="time" name="appointment_time" id="appointment_time" required>
        </div>
      </div>

      <!-- Reason -->
      <div class="form-group">
        <label for="reason">Reason for Visit</label>
        <input type="text" name="reason" id="reason"
               placeholder="e.g. Headache, Follow-up, Flu symptoms..." required>
      </div>

      <!-- Notes -->
      <div class="form-group">
        <label for="notes">Additional Notes <span style="font-weight:400;opacity:0.6">(optional)</span></label>
        <textarea name="notes" id="notes"
                  placeholder="Any extra information for the doctor..."></textarea>
      </div>

      <hr class="divider">

      <!-- Submit -->
      <button type="submit" id="book-btn">
        📅 Book Appointment
      </button>

      <!-- Status Message -->
      <div id="booking-status"></div>

      <!-- Join Link (shown after booking) -->
      <div id="join-session-wrap">
        <a id="join-session-btn" href="#">🎥 Join Consultation Session</a>
      </div>

    </form>
  </div>

</div>

<script src="{{ asset('js/appointment-booking.js') }}"></script>
</body>
</html>

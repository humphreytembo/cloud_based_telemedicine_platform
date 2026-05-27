/**
 * TeleMed - Appointment Booking
 * Handles the frontend booking form and API call to Laravel backend
 */

const AppointmentBooking = {

  /**
   * Book an appointment via the Laravel API
   * @param {Object} formData - Appointment form data
   */
  async book(formData) {
    const btn = document.getElementById('book-btn');
    const statusMsg = document.getElementById('booking-status');

    try {
      // Show loading state
      btn.disabled = true;
      btn.innerHTML = `
        <span class="spinner"></span> Booking...
      `;
      statusMsg.className = '';
      statusMsg.textContent = '';

      const response = await fetch('/api/appointments', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
        body: JSON.stringify(formData),
      });

      const result = await response.json();

      if (response.ok && result.success) {
        // ✅ Success
        statusMsg.className = 'status-success';
        statusMsg.innerHTML = `
          ✅ Appointment confirmed! Confirmation emails have been sent to
          you and your doctor. <br>
          <strong>Appointment ID: #${result.appointment_id}</strong>
        `;

        // Store join link for later
        sessionStorage.setItem('join_link', result.join_link);

        // Show join button
        document.getElementById('join-session-wrap').style.display = 'block';
        document.getElementById('join-session-btn').href = result.join_link;

        // Reset form
        document.getElementById('appointment-form').reset();

      } else {
        // ❌ Validation errors or server error
        const errors = result.errors
          ? Object.values(result.errors).flat().join('<br>')
          : result.message || 'Something went wrong. Please try again.';

        statusMsg.className = 'status-error';
        statusMsg.innerHTML = `❌ ${errors}`;
      }

    } catch (error) {
      console.error('Booking error:', error);
      statusMsg.className = 'status-error';
      statusMsg.textContent = '❌ Network error. Please check your connection and try again.';
    } finally {
      btn.disabled = false;
      btn.textContent = 'Book Appointment';
    }
  },

  /**
   * Cancel an appointment
   * @param {number} appointmentId
   * @param {string} cancelledBy - 'doctor' or 'patient'
   */
  async cancel(appointmentId, cancelledBy = 'patient') {
    if (!confirm('Are you sure you want to cancel this appointment?')) return;

    try {
      const response = await fetch(`/api/appointments/${appointmentId}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
        body: JSON.stringify({ cancelled_by: cancelledBy }),
      });

      const result = await response.json();

      if (response.ok && result.success) {
        alert('✅ Appointment cancelled. Both you and your doctor have been notified.');
        // Optionally reload or redirect
        window.location.reload();
      } else {
        alert('❌ ' + (result.message || 'Could not cancel. Please try again.'));
      }

    } catch (error) {
      console.error('Cancel error:', error);
      alert('❌ Network error. Please try again.');
    }
  }
};


// ─── Form Submit Handler ───────────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('appointment-form');
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = {
      doctor_id:        form.doctor_id.value,
      patient_id:       form.patient_id.value,
      appointment_date: form.appointment_date.value,
      appointment_time: form.appointment_time.value,
      reason:           form.reason.value,
      notes:            form.notes?.value || '',
    };

    await AppointmentBooking.book(formData);
  });

  // Attach cancel buttons
  document.querySelectorAll('[data-cancel-appointment]').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.cancelAppointment;
      AppointmentBooking.cancel(id, 'patient');
    });
  });
});

// public/js/reservations-history.js
(function () {
  // expose function ke global supaya onclick di blade tetap bekerja
  function openDetail(id) {
    const modalEl = document.getElementById('detailModal');
    if (!modalEl) return console.warn('Modal element not found');
    const modal = new bootstrap.Modal(modalEl);
    const content = document.getElementById('detailContent');
    content.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-secondary" role="status"></div></div>';

    fetch('/reservations/' + id, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then(function (r) {
        if (!r.ok) throw new Error('Gagal memuat');
        return r.json();
      })
      .then(function (data) {
        var html = ''
          + '<h5>' + (data.treatment ? data.treatment.name : '-') + '</h5>'
          + '<p><strong>Status:</strong> ' + (data.status || '-') + '</p>'
          + '<p><i class="bi bi-calendar"></i> ' + (data.tanggal ? new Date(data.tanggal).toLocaleDateString('id-ID') : '-') + '</p>'
          + '<p><i class="bi bi-clock"></i> ' + (data.waktu || '-') + '</p>'
          + '<p><i class="bi bi-person"></i> ' + (data.doctor ? data.doctor.name : '-') + '</p>'
          + '<p><strong>Harga:</strong> Rp ' + (Number(data.harga || 0).toLocaleString('id-ID')) + '</p>'
          + '<p><strong>Booking ID:</strong> ' + (data.booking_id || '-') + '</p>'
          + '<p><strong>Catatan:</strong> ' + (data.notes || '-') + '</p>';

        content.innerHTML = html;
        modal.show();
      })
      .catch(function () {
        content.innerHTML = '<div class="alert alert-danger">Gagal memuat data.</div>';
        modal.show();
      });
  }

  // expose ke window supaya onclick di blade panggilnya window.openReservationDetail(...)
  window.openReservationDetail = openDetail;
})();
// resources/js/reservations-history.js
export async function openReservationDetail(id) {
  const modalEl = document.getElementById('detailModal');
  const content = document.getElementById('detailContent');
  if (!modalEl || !content) return console.warn('Modal element or content not found');

  content.innerHTML = '<div class="text-center py-4"><div class="loader"></div></div>';

  try {
    const r = await fetch('/reservations/' + id, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    if (!r.ok) throw new Error('Gagal memuat');
    const data = await r.json();

    const html = `
      <h5 class="text-lg font-semibold">${data.treatment?.name ?? '-'}</h5>
      <p class="mt-2"><strong>Status:</strong> ${data.status ?? '-'}</p>
      <p><strong>Tanggal:</strong> ${data.reservation_date ? new Date(data.reservation_date).toLocaleDateString('id-ID') : '-'}</p>
      <p><strong>Waktu:</strong> ${data.reservation_time ?? '-'}</p>
      <p><strong>Dokter:</strong> ${data.doctor?.name ?? '-'}</p>
      <p><strong>Harga:</strong> Rp ${Number(data.total_price ?? 0).toLocaleString('id-ID')}</p>
      <p><strong>Booking ID:</strong> ${data.reservation_code ?? '-'}</p>
      <p class="mt-2"><strong>Catatan:</strong> ${data.notes ?? '-'}</p>
    `;
    content.innerHTML = html;

    // Trigger Alpine modal: set data attribute to show
    if (window.Alpine) {
      const alpineEl = modalEl.__x;
      // find Alpine store "detailModal" - simpler: toggle class
      modalEl.classList.remove('hidden');
      modalEl.__open = true;
    } else {
      // fallback: remove hidden
      modalEl.classList.remove('hidden');
    }
  } catch (err) {
    content.innerHTML = '<div class="text-red-500">Gagal memuat data.</div>';
    modalEl.classList.remove('hidden');
  }
}

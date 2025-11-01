// resources/js/reservations-history.js
export async function openReservationDetail(id) {
    window.dispatchEvent(new CustomEvent('open-detail-modal', { detail: { id: id } }));
}
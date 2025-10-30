import '../css/app.css'; // Impor CSS (termasuk Tailwind)
import './bootstrap';   // Impor Axios
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Impor fungsi modal dari file terpisah
import { openReservationDetail } from './reservations-history.js';

// Jadikan fungsi tersedia secara global
window.openReservationDetail = openReservationDetail;
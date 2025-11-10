import '../css/app.css';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// expose reservation helper
import * as ResHist from './reservations-history';
window.openReservationDetail = ResHist.openReservationDetail;

// import custom animations
import './animations';

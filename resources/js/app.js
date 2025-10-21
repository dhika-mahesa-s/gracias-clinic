import './bootstrap';
<<<<<<< HEAD

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

=======
import Chart from 'chart.js/auto';

// Grafik Layanan
const ctxLayanan = document.getElementById('chartLayanan');
if (ctxLayanan) {
  new Chart(ctxLayanan, {
    type: 'bar',
    data: {
      labels: ['Facial', 'Body', 'Lainnya'],
      datasets: [{
        label: 'Reservasi',
        data: [35, 68, 20],
        backgroundColor: '#3b82f6'
      }]
    }
  });
}

// Grafik Per Bulan
const ctxBulan = document.getElementById('chartBulan');
if (ctxBulan) {
  new Chart(ctxBulan, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
      datasets: [{
        label: 'Total Reservasi',
        data: [45, 67, 90, 120, 145, 180],
        borderColor: '#3b82f6',
        fill: false
      }]
    }
  });
}
>>>>>>> b8b22b9aa63bc256fd5fe7fe48e52544b8352ceb

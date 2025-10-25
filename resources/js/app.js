import './bootstrap';
import Alpine from 'alpinejs';
<<<<<<< HEAD
import Chart from 'chart.js/auto';

// Inisialisasi Alpine.js
window.Alpine = Alpine;
Alpine.start();

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
=======
window.Alpine = Alpine;
Alpine.start();
>>>>>>> 2ecc4f31a4267163115066c244ff1ef1533615c4

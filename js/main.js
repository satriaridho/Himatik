const monthYearElemen = document.getElementById('monthYear');
const datesElemen = document.getElementById('dates');
const prevBtn = document.getElementById('prev');
const nextBtn = document.getElementById('next');

let currentDate = new Date();

const updateCalendar = () => {
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();

  const firstDay = new Date(year, month, 1);  // Pertama bulan
  const lastDay = new Date(year, month + 1, 0);  // Terakhir bulan
  const daysInMonth = lastDay.getDate();
  const firstDayIndex = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;  // Mengubah hari pertama (Sunday => 0)

  const monthYearString = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });
  monthYearElemen.textContent = monthYearString;

  let datesHTML = '';

  // Menambahkan tanggal bulan sebelumnya (inactive)
  for (let i = firstDayIndex; i > 0; i--) {
    const prevDate = new Date(year, month, 0 - i + 1);
    datesHTML += `<div class="date inactive">${prevDate.getDate()}</div>`;
  }

  // Menambahkan tanggal bulan ini
  for (let i = 1; i <= daysInMonth; i++) {
    const date = new Date(year, month, i);
    const activeClass = date.toDateString() === new Date().toDateString() ? 'active' : '';
    datesHTML += `<div class="date ${activeClass}">${i}</div>`;
  }

  // Menambahkan tanggal bulan berikutnya (inactive)
  const lastDayIndex = lastDay.getDay();
  for (let i = 1; i <= 7 - lastDayIndex; i++) {
    const nextDate = new Date(year, month + 1, i);
    datesHTML += `<div class="date inactive">${nextDate.getDate()}</div>`;
  }

  datesElemen.innerHTML = datesHTML;
}

prevBtn.addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() - 1); // Navigasi mundur ke bulan sebelumnya
  updateCalendar();
});

nextBtn.addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() + 1); // Navigasi maju ke bulan berikutnya
  updateCalendar();
});

updateCalendar();



// chart data stok
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Tipe', 'Stok', 'Terjual'],
    ['CA', 1000, 400],
    ['IL', 1170, 460],
    ['NY', 660, 1120]
  ]);

  var options = {
    bars: 'horizontal', // Required for Material Bar Charts.
    hAxis: { format: 'decimal' },
    height: 200,  // Adjust the height of the entire chart
    width: 850,   // Adjust the width of the entire chart
    colors: ['#43766C', '#12372A'],
    backgroundColor: '#DCD7C9',
    chartArea: {
      backgroundColor: '#DCD7C9',
      left: 400,   // Optional: Space to the left of the chart
      right: 400,  // Optional: Space to the right of the chart
      top: 20,    // Optional: Space above the chart
      bottom: 40  // Optional: Space below the chart
    },
    barGroupWidth: 50, // Controls the gap between groups (i.e., the bars for 'Stok' and 'Terjual')
    barSpacing: 30,    // Controls the spacing between the bars in each group
  };

  var chart = new google.charts.Bar(document.getElementById('chart_div'));
  chart.draw(data, google.charts.Bar.convertOptions(options));

  var btns = document.getElementById('btn-group');

  btns.onclick = function (e) {
    if (e.target.tagName === 'BUTTON') {
      options.hAxis.format = e.target.id === 'none' ? '' : e.target.id;
      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
  }
}

// Pilih semua link di sidebar
const navLinks = document.querySelectorAll('.nav-link');

// Tambahkan event listener untuk setiap link
navLinks.forEach(link => {
    link.addEventListener('click', function() {
        // Hapus kelas active dari semua link
        navLinks.forEach(item => item.classList.remove('active'));
        
        // Tambahkan kelas active ke link yang diklik
        this.classList.add('active');
    });
});

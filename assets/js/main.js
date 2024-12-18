const monthYearElemen = document.getElementById('monthYear');
const datesElemen = document.getElementById('dates');
const prevBtn = document.getElementById('prev');
const nextBtn = document.getElementById('next');

let currentDate = new Date();

const updateCalendar = () => {
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();

  const firstDay = new Date(year, month, 1);  
  const lastDay = new Date(year, month + 1, 0);  
  const daysInMonth = lastDay.getDate();
  const firstDayIndex = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1; 

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
  currentDate.setMonth(currentDate.getMonth() - 1); 
  updateCalendar();
});

nextBtn.addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() + 1); 
  updateCalendar();
});

updateCalendar();

const navLinks = document.querySelectorAll('.nav-link');

navLinks.forEach(link => {
    link.addEventListener('click', function() {
        navLinks.forEach(item => item.classList.remove('active'));
        
        this.classList.add('active');
    });
});


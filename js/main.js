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

// pagination
// Sample data (this should be replaced with your actual data)
const totalData = 1240;
let rowsPerPage = 8; // default rows per page
let currentPage = 1;

// Function to update the table or data display based on current page and rows per page
function updateTable() {
    rowsPerPage = parseInt(document.getElementById("rowsPerPage").value);
    currentPage = 1; // Reset to the first page when rows per page changes
    displayData();
}

// Function to display data for the current page
function displayData() {
    const start = (currentPage - 1) * rowsPerPage + 1;
    const end = Math.min(currentPage * rowsPerPage, totalData);
    const pageInfo = `${start}-${end} of ${totalData}`;
    document.getElementById("pageInfo").textContent = pageInfo;

    // Show the data dynamically (replace with actual data rendering)
    const dataContainer = document.getElementById("dataContainer");
    dataContainer.innerHTML = ""; // Clear previous data (for demo purposes)
    for (let i = start; i <= end; i++) {
        const item = document.createElement("div");
        item.textContent = `Item ${i}`;
        dataContainer.appendChild(item);
    }
}

// Function to go to the previous page
function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        displayData();
    }
}

// Function to go to the next page
function nextPage() {
    const totalPages = Math.ceil(totalData / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        displayData();
    }
}

// Initialize the data display
displayData();

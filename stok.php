<link rel="stylesheet" href="./style/table.css">
<div class="col-md-9 content" style="margin-left: 400px;">
    <div class="row">
        <div class="contr">
            <div style="color:#DCD7C9; font-size: 40px; margin-bottom: 40px;">
                <i class="fa-solid fa-clipboard-list"></i> Manajemen Stok Barang
            </div>
            <div class="hdr">
                <div class="title">
                    <i class="fas fa-plus-circle" style="color: #DCD7C9;"></i>
                    <button class="btn-add"><a style="text-decoration: none; color: #DCD7C9;" href="index.php?page=tambahitem">ADD ITEM</a></button>
                </div>
                <div class="search">
                    <div style="position: relative;">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: -2px; top: 50%; transform: translateY(-50%); color: #76453B;"></i>
                        <input type="text" placeholder="Type to Search" class="inpt" style="padding-left: 40px; border-radius: 50px;">
                    </div>
                    <i class="fas fa-sort" style="margin:10px;"></i> Sort
                    <i class="fas fa-filter" style="margin:10px;"></i> Filter
                </div>
            </div>
            <table id="dataContainer">
                <thead style="color: #D5CEC0;">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kategori Barang</th>
                        <th>Stok Barang</th>
                        <th>Harga Barang</th>
                        <th>Action Button</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Data rows will go here -->
                </tbody>
            </table>
            <div class="footer d-flex justify-content-center align-items-center" style="color: #DCD7C9;">
                <div>
                    Rows per page:
                    <select id="rowsPerPage" onchange="updateTable()" style="background-color: #76453B; color: #DCD7C9;">
                        <option value="8">8</option>
                        <option value="16">16</option>
                        <option value="32">32</option>
                    </select>
                </div>
                <div class="pagination" style="margin-left: 20px;">
                    <span id="pageInfo">1-8 of 1240</span>
                    <i class="fas fa-chevron-left" onclick="previousPage()"></i>
                    <i class="fas fa-chevron-right" onclick="nextPage()"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const items = [
    { id: 1, name: 'Sabun', category: 'Elektronik', stock: 70, price: 100000 },
    { id: 2, name: 'Shampoo', category: 'Elektronik', stock: 50, price: 50000 },
    { id: 3, name: 'Sikat Gigi', category: 'Elektronik', stock: 20, price: 25000 },
    { id: 4, name: 'Kipas Angin', category: 'Elektronik', stock: 100, price: 150000 },
    { id: 5, name: 'Lampu', category: 'Elektronik', stock: 120, price: 30000 },
    { id: 6, name: 'Kulkas', category: 'Elektronik', stock: 10, price: 2000000 },
    { id: 7, name: 'Microwave', category: 'Elektronik', stock: 5, price: 1500000 },
    { id: 8, name: 'Televisi', category: 'Elektronik', stock: 15, price: 3000000 },
    { id: 9, name: 'Ponsel', category: 'Elektronik', stock: 30, price: 500000 },
    { id: 10, name: 'Laptop', category: 'Elektronik', stock: 8, price: 7000000 },
    // Add more items as needed
];

let currentPage = 1;
let rowsPerPage = 8;

function updateTable() {
    const tableBody = document.getElementById('tableBody');
    const rowsPerPageSelect = document.getElementById('rowsPerPage');
    rowsPerPage = parseInt(rowsPerPageSelect.value);
    currentPage = 1;
    renderTable();
}

function renderTable() {
    const tableBody = document.getElementById('tableBody');
    const startIndex = (currentPage - 1) * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;
    const currentItems = items.slice(startIndex, endIndex);

    tableBody.innerHTML = '';
    currentItems.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${startIndex + index + 1}</td>
            <td>${item.name}</td>
            <td>${item.category}</td>
            <td>${item.stock}</td>
            <td>${formatCurrency(item.price)}</td>
            <td class="action-buttons">
                <a class="edit-btn" href="index.php?page=edititem" style="text-decoration: none;">EDIT</a>
                <a class="delete-btn" href="index.php?page=hapusitem" style="text-decoration: none;">DELETE</a>
            </td>
        `;
        tableBody.appendChild(row);
    });

    updatePaginationInfo();
}

// Function to format numbers as Indonesian Rupiah
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
}

function updatePaginationInfo() {
    const pageInfo = document.getElementById('pageInfo');
    const startIndex = (currentPage - 1) * rowsPerPage + 1;
    const endIndex = Math.min(currentPage * rowsPerPage, items.length);
    pageInfo.textContent = `${startIndex}-${endIndex} of ${items.length}`;
}

function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        renderTable();
    }
}

function nextPage() {
    const totalPages = Math.ceil(items.length / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable();
    }
}

// Initial render
renderTable();
</script>


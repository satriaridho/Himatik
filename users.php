<?php
include 'config.php';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch product data
    $stmt = $pdo->prepare("
        SELECT user_id, username, email, join_date
        FROM users
    ");
    $stmt->execute();

    // Fetch data as an associative array
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<link rel="stylesheet" href="./style/table.css">
<div class="col-md-9 content" style="margin-left: 400px;">
  <div class="row">
    <div class="contr">
      <div style="color:#DCD7C9; font-size: 40px; margin-bottom: 40px;">
        <i class="fas fa-users"></i> Users Data
      </div>
      <div class="hdr">
        <div class="title">
          <i class="fas fa-plus-circle" style="color: #DCD7C9;"></i>
          <button class="btn-add"><a style="text-decoration: none; color: #DCD7C9;" href="index.php?page=tambahuser">ADD USER</a></button>
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
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Join Date</th>
                    <th>Action Button</th>
                </tr>
            </thead>
            <tbody id="dataContainer">
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['join_date']); ?></td>
                    <td class="action-buttons">
                        <a class="edit-btn" href="index.php?page=edituser&user_id=<?php echo $user['user_id']; ?>" style="text-decoration: none;">EDIT</a>
                        <a class="delete-btn" href="index.php?page=deleteuser&user_id=<?php echo $user['user_id']; ?>" style="text-decoration: none;">DELETE</a>
                    </td>
                </tr>
                <?php endforeach; ?>
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
<!-- 
<script>
// Sample data
const usersData = [
  { no: 1, username: 'Sabun', email: 'Elektronik@gmail.com', joinDate: '04/04/2019' },
  { no: 2, username: 'Jhon', email: 'jhon@example.com', joinDate: '01/01/2020' },
  { no: 3, username: 'Lisa', email: 'lisa@example.com', joinDate: '10/10/2021' },
  { no: 4, username: 'Alice', email: 'alice@example.com', joinDate: '12/12/2022' },
  { no: 5, username: 'Bob', email: 'bob@example.com', joinDate: '02/02/2023' },
  { no: 6, username: 'Charlie', email: 'charlie@example.com', joinDate: '03/03/2024' },
  { no: 7, username: 'David', email: 'david@example.com', joinDate: '05/05/2018' },
  { no: 8, username: 'Eve', email: 'eve@example.com', joinDate: '06/06/2022' },
  { no: 9, username: 'Frank', email: 'frank@example.com', joinDate: '07/07/2019' },
  { no: 10, username: 'Grace', email: 'grace@example.com', joinDate: '08/08/2020' },
  // Add more sample data if needed
];

let currentPage = 1;
let rowsPerPage = 8;
let totalRows = usersData.length;

// Function to update the table
function updateTable() {
  rowsPerPage = parseInt(document.getElementById('rowsPerPage').value);
  currentPage = 1;  // Reset to first page when changing rows per page
  renderTable();
}

// Function to render the table based on current page and rows per page
function renderTable() {
  const tableBody = document.getElementById('tableBody');
  const startIndex = (currentPage - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const paginatedData = usersData.slice(startIndex, endIndex);
  
  tableBody.innerHTML = '';

  paginatedData.forEach(user => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${user.no}</td>
      <td>${user.username}</td>
      <td>${user.email}</td>
      <td>${user.joinDate}</td>
      <td class="action-buttons">
        <a class="edit-btn" href="index.php?page=edituser" style="text-decoration: none;">EDIT</a>
        <a class="delete-btn" href="index.php?page=hapususer" style="text-decoration: none;">DELETE</a>
      </td>
    `;
    tableBody.appendChild(row);
  });

  updatePageInfo();
}

// Function to update pagination info (e.g., showing 1-8 of 1240)
function updatePageInfo() {
  const totalPages = Math.ceil(totalRows / rowsPerPage);
  const startRow = (currentPage - 1) * rowsPerPage + 1;
  const endRow = Math.min(currentPage * rowsPerPage, totalRows);

  document.getElementById('pageInfo').textContent = `${startRow}-${endRow} of ${totalRows}`;
  document.querySelector('.pagination').style.display = totalPages > 1 ? 'block' : 'none'; // Show pagination if more than one page
}

// Function to go to the previous page
function previousPage() {
  if (currentPage > 1) {
    currentPage--;
    renderTable();
  }
}

// Function to go to the next page
function nextPage() {
  const totalPages = Math.ceil(totalRows / rowsPerPage);
  if (currentPage < totalPages) {
    currentPage++;
    renderTable();
  }
}

// Initial rendering of the table
renderTable();
</script> -->

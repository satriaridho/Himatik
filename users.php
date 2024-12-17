<?php
include 'config.php';

// Get current page and rows per page
$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1; // Default to page 1
$rowsPerPage = isset($_GET['rows_per_page']) ? (int)$_GET['rows_per_page'] : 8; // Default to 8 rows per page
$offset = ($page - 1) * $rowsPerPage;

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to count total number of users
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    $totalUsers = $stmt->fetchColumn();

    // Calculate total pages
    $totalPages = ceil($totalUsers / $rowsPerPage);

    // Query to fetch user data with pagination
    $stmt = $pdo->prepare("SELECT user_id, username, email, join_date FROM users LIMIT :offset, :rowsPerPage");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':rowsPerPage', $rowsPerPage, PDO::PARAM_INT);
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
                        <th>No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Join Date</th>
                        <th>Action Button</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = $offset + 1; // Start the index from the correct number based on the current page
                        if (!empty($users)):
                        foreach ($users as $user):
                    ?>
                            <tr>
                                <td><?php echo htmlspecialchars($i++); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['join_date']); ?></td>
                                <td class="action-buttons">
                                    <a class="edit-btn" href="index.php?page=edituser&user_id=<?php echo $user['user_id']; ?>" style="text-decoration: none;">EDIT</a>
                                    <a class="delete-btn" href="index.php?page=deleteuser&user_id=<?php echo $user['user_id']; ?>" style="text-decoration: none;">DELETE</a>
                                </td>
                            </tr>
                    <?php
                        endforeach;
                    else:
                    ?>
                        <tr>
                            <td colspan="5">Tidak ada data pengguna</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="footer d-flex justify-content-center align-items-center" style="color: #DCD7C9;">
                <div>
                    Rows per page:
                    <select id="rowsPerPage" onchange="updateTable()" style="background-color: #76453B; color: #DCD7C9;">
                        <option value="8" <?php if ($rowsPerPage == 8) echo "selected"; ?>>8</option>
                        <option value="16" <?php if ($rowsPerPage == 16) echo "selected"; ?>>16</option>
                        <option value="32" <?php if ($rowsPerPage == 32) echo "selected"; ?>>32</option>
                    </select>
                </div>
                <div class="pagination" style="margin-left: 20px;">
                    <span id="pageInfo"><?php echo "1 - " . ($offset + count($users)) . " of $totalUsers"; ?></span>
                    <a href="index.php?page=users&page_num=<?php echo $page - 1; ?>&rows_per_page=<?php echo $rowsPerPage; ?>" class="pagination-btn" <?php if ($page <= 1) echo 'disabled'; ?>>
                        <i class="fas fa-chevron-left" style="color: white;"></i>
                    </a>
                    <a href="index.php?page=users&page_num=<?php echo $page + 1; ?>&rows_per_page=<?php echo $rowsPerPage; ?>" class="pagination-btn" <?php if ($page >= $totalPages) echo 'disabled'; ?>>
                        <i class="fas fa-chevron-right" style="color: white;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- <script>
// Convert PHP array to JavaScript array
const usersData = <?php echo json_encode($users); ?>;
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

    paginatedData.forEach((user, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${startIndex + index + 1}</td>
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td>${user.join_date}</td>
            <td class="action-buttons">
                <a class="edit-btn" href="index.php?page=edituser&user_id=${user.user_id}" style="text-decoration: none;">EDIT</a>
                <a class="delete-btn" href="index.php?page=deleteuser&user_id=${user.user_id}" style="text-decoration: none;">DELETE</a>
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

    // Show pagination only if there's more than 1 page
    document.querySelector('.pagination').style.display = totalPages > 1 ? 'flex' : 'none';
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
window.onload = function() {
    renderTable(); // Initial render on page load
    updatePageInfo(); // Update pagination info on page load
};
</script> -->

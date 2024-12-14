<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<title>Dashboard</title>
<link
    crossorigin="anonymous"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    rel="stylesheet"/>
<link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    rel="stylesheet"/>
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
<link rel="stylesheet" href="./style/dash.css" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar">
        <nav class="nav flex-column">
        <h1 style="color: #76453b; font-weight: bold; opacity: 0.7;">Dashboard Admin</h1>
        <br />
        <a class="nav-link " href="index.php?page=home">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        
        <a class="nav-link " href="index.php?page=stok">
            <i class="fas fa-box"></i> Manajemen Stok
        </a>
        <a class="nav-link " href="#">
            <i class="fas fa-users"></i> Users
        </a>
        
        <a class="nav-link " href="#">
            <i class="fas fa-bell"></i> Notifications
        </a>
        <div> 
            <a class="nav-link " href="logout.html">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
        </nav>

       
        
    </div>

    



        <?php

        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        include $page . '.php';
        
        ?>
        

</div>

<script
    crossorigin="anonymous"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+3i5d5L5hb5g7v4l5Y5n5Y5n5Y5n5"
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="./js/main.js"></script>
<script>

    // Sales Chart
    function generateDates() {
        let dates = [];
        let currentDate = new Date();
        for (let i = 6; i >= 0; i--) {
            let date = new Date(currentDate);
            date.setDate(currentDate.getDate() - i);
            dates.push(date.toLocaleDateString());
        }
        return dates;
    }

    const labels = generateDates();

    const data = Array.from({ length: 7 }, () => Math.floor(Math.random() * (500 - 100 + 1)) + 100);

    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels, 
            datasets: [
                {
                    label: 'Sales',
                    data: data, 
                    borderColor: '#4caf50',
                    backgroundColor: 'rgba(76, 175, 80, 0.0)', 
                    fill: true, 
                    tension: 0.4, 
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 600,
                },
            },
        },
    });

    // Activity Chart
    var ctx2 = document.getElementById('activityChart').getContext('2d');
    var activityChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [
        {
            label: 'Activity',
            data: [5, 10, 15, 20, 25, 30, 35],
            backgroundColor: '#4caf50',
        },
        ],
    },
    options: {
        scales: {
        y: {
            beginAtZero: true,
        },
        },
    },
    });

</script>
</body>
</html>

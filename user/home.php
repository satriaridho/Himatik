<?php
include '../config.php';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch users who have joined within the last 7 days
    $stmt = $pdo->prepare("SELECT username, join_date FROM users WHERE join_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY join_date DESC");
    $stmt->execute();
    $new_users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch total number of users
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total_users FROM users");
    $stmt->execute();
    $userCountResult = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalUsers = $userCountResult['total_users'];

    // Fetch total number of notifications
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total_notifications FROM notifications");
    $stmt->execute();
    $notificationCountResult = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalNotifications = $notificationCountResult['total_notifications'];

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!-- Content -->
<div class="col-md-9 content" style="margin-left: 340px; overflow-x: hidden;">
    <h1 style="visibility: hidden;">hehe</h1>
    <!-- Statistics Cards -->
    <div class="row">

        <!-- Charts and Calendar -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Sales</div>
                    <div class="card-body">
                        <canvas class="chart" id="salesChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Calendar -->
                <div class="calendar" style="margin-bottom: 20px; margin-top: 0;">
                    <div class="headr">
                        <button id="prev" class="prev">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <span id="monthYear"></span>
                        <button id="next" class="next">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="days">
                        <div class="day">Mon</div>
                        <div class="day">Tue</div>
                        <div class="day">Wed</div>
                        <div class="day">Thu</div>
                        <div class="day">Fri</div>
                        <div class="day">Sat</div>
                        <div class="day">Sun</div>
                    </div>
                    <div id="dates" class="dates" style="gap: 34px;"></div>
                </div>

                <!-- Data Stock Chart -->
                

            </div>
            <div class="" style="width: 120%; margin-left: 0;">
                    <div class="col-md-8" style="position: relative; margin-top: 0; width: 120%;  ">
                        <div class="card" style="color: black;">
                            <div class="card-header" style="margin-bottom: 10px;">Data Stok</div>
                            <div id="chart_div" style="font-size: small; height: 212px; "></div>
                        </div>
                    </div>
                </div>

        </div>

    </div>
</div>



<script
    crossorigin="anonymous"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+3i5d5L5hb5g7v4l5Y5n5Y5n5Y5n5"
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../assets/js/main.js"></script>
<script>

fetch('../sales_chart_connection.php')
    .then(response => response.json())
    .then(data => {
        // Extract dates and sales from the response
        const labels = data.map(item => item.sale_date);
        const sales = data.map(item => item.total_sales);

        // Calculate the maximum y-axis value with a 10% margin
        const maxSales = Math.max(...sales);
        const yAxisMax = maxSales * 1.1; // Add 10% margin

        // Create the chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales',
                    data: sales,
                    borderColor: 'green',
                    backgroundColor: 'rgba(0, 255, 0, 0.1)',
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const index = tooltipItem.dataIndex;
                                const salesValue = sales[index];
                                return `Sales: ${salesValue}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: yAxisMax
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching data:', error));



    // chart data stok
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    // Fetch data from stock_chart_connection.php
    fetch('../stock_chart_connection.php')
        .then(response => response.json())
        .then(data => {
            // Add column headers to the data
            data.unshift(['category', 'stock', 'sales']);

            var chartData = google.visualization.arrayToDataTable(data);

            var options = {
                bars: 'horizontal', // Required for Material Bar Charts.
                hAxis: { format: 'decimal' },
                height: 200,  // Adjust the height of the entire chart
                width: 1300,   // Adjust the width of the entire chart
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
                barSpacing: 50,    // Controls the spacing between the bars in each group
            };

            var chart = new google.charts.Bar(document.getElementById('chart_div'));
            chart.draw(chartData, google.charts.Bar.convertOptions(options));

            var btns = document.getElementById('btn-group');

            btns.onclick = function (e) {
                if (e.target.tagName === 'BUTTON') {
                    options.hAxis.format = e.target.id === 'none' ? '' : e.target.id;
                    chart.draw(chartData, google.charts.Bar.convertOptions(options));
                }
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}

</script>

    <!-- Content -->
    <div class="col-md-9 content">
        <!-- Statistics Cards -->
        <div class="row">

        <div class="col-md-2">
            <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x mb-2"></i>
                <p>100</p>
                <p>Users</p>
            </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-check-square fa-2x mb-2"></i>
                <p>32</p>
                <p>Completed</p>
            </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-bell fa-2x mb-2"></i>
                <p>2</p>
                <p>Notifications</p>
            </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                <p>4</p>
                <p>Reports</p>
            </div>
            </div>
        </div>
        </div>

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
            <div class="calendar" style="margin-bottom: 20px;">
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
            <div id="dates" class="dates"></div>
            </div>

            <!-- Activity Card -->
            <div class="card act">
            <div class="card-header">Activity</div>
            <div class="card-body">
                <canvas class="chart" id="activityChart"></canvas>
            </div>
            </div>
        </div>
        </div>

        <!-- New User and Stock Data -->
        <div class="row">
        <div class="col-md-4" >
            <div class="card" style="color: black;">
            <div class="card-header">New User</div>
            <div class="card-body user-list">
                <div class="user-item">
                <img
                    alt="User profile picture"
                    height="40"
                    src="https://storage.googleapis.com/a1aa/image/aj9sDhcKAioIJBedHNXM9BYg125p4dr7KBWrecBtvrctcK6TA.jpg"
                    width="40"
                />
                <div>
                    <h6 class="mb-0">Nicci Troiani</h6>
                    <small>Chicago, IL</small>
                </div>
                </div>
                <div class="user-item">
                <img
                    alt="User profile picture"
                    height="40"
                    src="https://storage.googleapis.com/a1aa/image/aj9sDhcKAioIJBedHNXM9BYg125p4dr7KBWrecBtvrctcK6TA.jpg"
                    width="40"
                />
                <div>
                    <h6 class="mb-0">George Fields</h6>
                    <small>New York, NY</small>
                </div>
                </div>
                <div class="user-item">
                <img
                    alt="User profile picture"
                    height="40"
                    src="https://storage.googleapis.com/a1aa/image/aj9sDhcKAioIJBedHNXM9BYg125p4dr7KBWrecBtvrctcK6TA.jpg"
                    width="40"
                />
                <div>
                    <h6 class="mb-0">Jones Dermot</h6>
                    <small>San Francisco, CA</small>
                </div>
                </div>
                <div class="user-item">
                    <img
                        alt="User profile picture"
                        height="40"
                        src="https://storage.googleapis.com/a1aa/image/aj9sDhcKAioIJBedHNXM9BYg125p4dr7KBWrecBtvrctcK6TA.jpg"
                        width="40"
                    />
                    <div>
                        <h6 class="mb-0">Jones Dermot</h6>
                        <small>San Francisco, CA</small>
                    </div>
                    </div>
            </div>
            </div>
        </div>

        <div class="col-md-8 " >
            <div class="card" style="color: black;">
            <div class="card-header" style="margin-bottom: 10px;">Data Stok
            </div>
            <div id="chart_div" style="font-size: small; height: 212px; border-radius: 5px;"></div>    
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
<script src="./js/main.js"></script>
<script>

    // Fetch sales data from the PHP script
    fetch('sales_chart_connection.php')
        .then(response => response.json())
        .then(data => {
            // Extract dates, sales, product names, and categories from the response
            const labels = data.map(item => item.sale_date);
            const sales = data.map(item => item.total_sales);
            // const productNames = data.map(item => item.product_name);
            // const categories = data.map(item => item.category);

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
                                    // Show sales, product name, and category in the tooltip
                                    const index = tooltipItem.dataIndex;
                                    const salesValue = sales[index];
                                    // const product = productNames[index];
                                    // const category = categories[index];
                                    return [
                                        `Sales: ${salesValue}`,
                                        // `Product: ${product}`,
                                        // `Category: ${category}`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));

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

    // chart data stok
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    // Fetch data from stock_chart_connection.php
    fetch('stock_chart_connection.php')
        .then(response => response.json())
        .then(data => {
            // Add column headers to the data
            data.unshift(['category', 'stock', 'sales']);

            var chartData = google.visualization.arrayToDataTable(data);

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

<?php
include '../config.php';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch recent notifications (less than 7 days old)
    $stmt = $pdo->prepare("SELECT * FROM notifications WHERE created_at >= NOW() - INTERVAL 7 DAY ORDER BY created_at DESC");
    $stmt->execute();
    $recent_notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch older notifications (7 days or more)
    $stmt = $pdo->prepare("SELECT * FROM notifications WHERE created_at < NOW() - INTERVAL 7 DAY ORDER BY created_at DESC");
    $stmt->execute();
    $older_notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<link rel="stylesheet" href="../assets/style/notif.css">
<div class="col-md-9 content" style="margin-left: 400px;">
    <div class="row">
        <div class="container mt-3">
            <div class="notification-header">
                <i class="fas fa-bell"></i> Notifications
            </div>
            <div class="cont">
                <div class="section-header mt-3" style="border-radius: 5px 5px 0 0;">
                    Recent
                </div>
                <div class="progress-container">
                    <p style="margin-left: 20px; margin-bottom: -10px; font-weight: bold;">Unduh Data Barang </p>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-download fa-2x ms-4"></i>
                        <div class="flex-grow-1 ms-5 mt-4">
                            <div class="progress">
                                <div id="progress-bar" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" class="progress-bar" role="progressbar" style="width: 0%;"></div>
                            </div>
                            <p id="progress-text" style="float: right; color: #333333; font-weight: bold;">0% processed</p>
                            <div class="actions">
                                <p id="loading-text" style="display: none;">Please wait while we load your file.</p>
                                <a href="#" id="cancel-btn" style="color: #333333; display: none;" onclick="cancelDownload()">Cancel</a>
                                <a href="#" id="pause-btn" style="font-weight: bold; display: none;" onclick="pauseDownload()">Pause Download</a>
                                <a href="#" id="start-btn" style="font-weight: bold;" onclick="startDownload()">Start Download</a>
                            </div>
                        </div>
                    </div>
                </div>
                

                <!-- Recent Notification Items -->
                <?php foreach ($recent_notifications as $notification): ?>
                <div class="notification-item">
                    <div class="content">
                        <?php echo htmlspecialchars($notification['message']); ?>
                    </div>
                    <div class="time">
                        <?php echo htmlspecialchars($notification['created_at']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="section-header" style="padding: 20px; border-radius: 0 0 5px 5px;"></div>
            </div> 

            <div class="cont">
                <div class="section-header mt-3" style="border-radius: 5px 5px 0 0;">
                    Older
                </div>
                <!-- Older Notification Items -->
                <?php foreach ($older_notifications as $notification): ?>
                <div class="notification-item">
                    <div class="content">
                        <?php echo htmlspecialchars($notification['message']); ?>
                    </div>
                    <div class="time">
                        <?php echo htmlspecialchars($notification['created_at']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="section-header" style="padding: 20px; border-radius: 0 0 5px 5px;"></div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/download.js"></script>
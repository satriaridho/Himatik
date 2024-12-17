<link rel="stylesheet" href="./style/notif.css">
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

                <!-- Notification Items -->
                <div class="notification-item">
                    <img alt="Profile picture of Admin 1" height="50" src="https://storage.googleapis.com/a1aa/image/cFbnm3qRnvodP5b10xVrvBD0z6HTAairfV6bzyvFynI3g29JA.jpg" width="50"/>
                    <div class="content">
                        <strong>Admin 1</strong><br/>
                        Menambahkan stok sejumlah 10 barang untuk barang bernama Sabun dengan kategori Elektronik
                    </div>
                    <div class="time">
                        just now
                    </div>
                </div>
                
                <div class="section-header" style="padding: 20px; border-radius: 0 0 5px 5px;"></div>
            </div> 

            <div class="cont">
                <div class="section-header mt-3" style="border-radius: 5px 5px 0 0;">
                    Earlier
                </div>
                <div class="notification-item">
                    <img alt="Profile picture of User 5" height="50" src="https://storage.googleapis.com/a1aa/image/xNyUPch65c7DEpckKqMf8g1Un2ZB9oxwVxVK4p0S9ww3g29JA.jpg" width="50"/>
                    <div class="content">
                        <strong>User 5</strong><br/>
                        Just registered as a new user
                    </div>
                    <div class="time">
                        yesterday
                    </div>
                </div>

                <div class="section-header" style="padding: 20px; border-radius: 0 0 5px 5px;"></div>
            </div>
        </div>
    </div>
</div>
<script src="./js/download.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  
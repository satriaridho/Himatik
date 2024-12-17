let downloadProgress = 0;
let downloadInterval;
let isPaused = false;

const fileUrl = 'export-data.php'; // URL of the page you want to redirect to after login

function startDownload() {
    // Show loading text and hide Start button
    document.getElementById('loading-text').style.display = 'block';
    document.getElementById('start-btn').style.display = 'none';
    document.getElementById('cancel-btn').style.display = 'inline';
    document.getElementById('pause-btn').style.display = 'inline';

    downloadInterval = setInterval(function() {
        if (!isPaused) {
            if (downloadProgress < 100) {
                downloadProgress += 1;
                document.getElementById('progress-bar').style.width = downloadProgress + '%';
                document.getElementById('progress-text').innerText = downloadProgress + '% processed';
            } else {
                clearInterval(downloadInterval);
                document.getElementById('progress-text').innerText = 'Loading complete!';
                document.getElementById('loading-text').style.display = 'none';
                document.getElementById('pause-btn').style.display = 'none';
                document.getElementById('cancel-btn').style.display = 'none';
                document.getElementById('start-btn').style.display = 'inline';

                redirectToExportData();
            }
        }
    }, 100); // Update every 100ms
}

function redirectToExportData() {
    window.location.href = fileUrl; // Redirect to the export-data.php page
}

// Function to cancel the download
function cancelDownload() {
    clearInterval(downloadInterval);
    downloadProgress = 0;
    document.getElementById('progress-bar').style.width = '0%';
    document.getElementById('progress-text').innerText = 'Download canceled';
    document.getElementById('loading-text').style.display = 'none';
    document.getElementById('pause-btn').style.display = 'none';
    document.getElementById('cancel-btn').style.display = 'none';
    document.getElementById('start-btn').style.display = 'inline';
}

// Function to pause/resume the download
function pauseDownload() {
    isPaused = !isPaused; // Toggle pause state
    const pauseBtnText = isPaused ? 'Resume Download' : 'Pause Download';
    document.getElementById('pause-btn').innerText = pauseBtnText;
}

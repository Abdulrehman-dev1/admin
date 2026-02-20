<?php

/**
 * Laravel Queue Status Checker
 * 
 * This script provides a quick way to check if Laravel queued jobs are running
 * and view any errors in the failed_jobs table.
 */

// Load .env variables
function loadEnv($path) {
    if (!file_exists($path)) {
        return false;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        // Handle quotes
        if (preg_match('/^"(.*)"$/', $value, $matches)) {
            $value = $matches[1];
        }
        putenv(sprintf('%s=%s', $name, $value));
        $_ENV[$name] = $value;
    }
    return true;
}

$envLoaded = loadEnv(__DIR__ . '/../.env');

if (!$envLoaded) {
    die("Error: .env file not found.");
}

$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbPort = getenv('DB_PORT') ?: '3306';
$dbName = getenv('DB_DATABASE');
$dbUser = getenv('DB_USERNAME');
$dbPass = getenv('DB_PASSWORD');

try {
    $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

// Get counts
$pendingJobs = $pdo->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
$failedJobsCount = $pdo->query("SELECT COUNT(*) FROM failed_jobs")->fetchColumn();

// Get recent failures
$recentFailures = $pdo->query("SELECT * FROM failed_jobs ORDER BY failed_at DESC LIMIT 10")->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Status Checker</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; max-width: 1000px; margin: 0 auto; padding: 20px; background: #f4f7f6; }
        .card { background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        .status-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
        .status-box { padding: 20px; border-radius: 8px; text-align: center; color: #fff; }
        .pending { background: #3498db; }
        .failed { background: #e74c3c; }
        .status-box h2 { margin: 0; font-size: 2.5rem; }
        .status-box p { margin: 5px 0 0; font-weight: bold; text-transform: uppercase; font-size: 0.9rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
        .exception { font-family: monospace; font-size: 0.85rem; background: #fdf2f2; padding: 10px; border-radius: 4px; border-left: 4px solid #e74c3c; white-space: pre-wrap; word-break: break-all; max-height: 200px; overflow-y: auto; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: bold; color: #fff; }
        .badge-queue { background: #9b59b6; }
        .timestamp { color: #666; font-size: 0.85rem; }
        .refresh-btn { background: #2ecc71; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; text-decoration: none; font-weight: bold; }
        .refresh-btn:hover { background: #27ae60; }
    </style>
</head>
<body>

<div class="card">
    <div class="header">
        <h1>Laravel Queue Status</h1>
        <a href="" class="refresh-btn">Refresh Now</a>
    </div>

    <div class="status-container">
        <div class="status-box pending">
            <h2><?php echo $pendingJobs; ?></h2>
            <p>Pending Jobs</p>
        </div>
        <div class="status-box failed">
            <h2><?php echo $failedJobsCount; ?></h2>
            <p>Total Failed Jobs</p>
        </div>
    </div>
</div>

<div class="card">
    <h2>Recent Failed Jobs (Last 10)</h2>
    <?php if (empty($recentFailures)): ?>
        <p style="color: #27ae60; font-weight: bold;">No failed jobs found! Everything looks good.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Queue</th>
                    <th>Failed At</th>
                    <th>Error Message</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentFailures as $fail): ?>
                    <tr>
                        <td><?php echo $fail['id']; ?></td>
                        <td><span class="badge badge-queue"><?php echo htmlspecialchars($fail['queue']); ?></span></td>
                        <td class="timestamp"><?php echo $fail['failed_at']; ?></td>
                        <td>
                            <div class="exception"><?php 
                                // Clean up the exception message to show the most relevant part first
                                $exc = htmlspecialchars($fail['exception']);
                                echo $exc;
                            ?></div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<div style="text-align: center; color: #999; font-size: 0.8rem;">
    Last checked: <?php echo date('Y-m-d H:i:s'); ?>
</div>

</body>
</html>

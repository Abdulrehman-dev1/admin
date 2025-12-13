<?php
$logFile = 'd:\Nextjs\xpertbid\admin\storage\logs\laravel.log';
if (file_exists($logFile)) {
       $lines = file($logFile);
       $count = count($lines);
       // Read last 50 lines
       $slice = array_slice($lines, max(0, $count - 50));
       echo implode("", $slice);
} else {
       echo "Log file not found.";
}

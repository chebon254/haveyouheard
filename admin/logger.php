<?php
/**
 * Log an event to a file
 *
 * @param string $level The log level (e.g., 'info', 'warning', 'error')
 * @param string $message The log message
 * @param string $file The file name to log to (optional)
 */
function logEvent($level, $message, $file = 'logs/app.log')
{
    $logEntry = date('Y-m-d H:i:s') . ' [' . strtoupper($level) . '] ' . $message . PHP_EOL;

    if (!file_exists(dirname($file))) {
        mkdir(dirname($file), 0755, true);
    }

    file_put_contents($file, $logEntry, FILE_APPEND);
}
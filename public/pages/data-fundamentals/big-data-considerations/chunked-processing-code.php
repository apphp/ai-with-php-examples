<?php

class ChunkedProcessor {
    private $chunkSize;
    private $maxMemoryUsage;
    private $logHandler;

    // Adjusted the constructor to avoid type errors
    public function __construct($chunkSize = 1000, $maxMemoryUsage = '256M', LogHandler $logHandler = null) {
        $this->chunkSize = $chunkSize;
        $this->maxMemoryUsage = $maxMemoryUsage;
        $this->logHandler = $logHandler ?? new LogHandler(); // Default if not provided
    }

    public function processLargeDataset($filename, callable $processor) {
        try {
            // Validate and set memory limit
            if (!ini_set('memory_limit', $this->maxMemoryUsage)) {
                throw new Exception('Failed to set memory limit.');
            }

            if (!file_exists($filename)) {
                throw new Exception("File not found: $filename");
            }

            $handle = fopen($filename, 'r');
            if ($handle === false) {
                throw new Exception("Failed to open file: $filename");
            }

            $stats = [
                'processed_rows' => 0,
                'failed_rows' => 0,
                'start_time' => microtime(true),
                'memory_peak' => 0,
            ];

            // Process file in chunks
            while (!feof($handle)) {
                try {
                    $chunk = [];
                    $count = 0;

                    // Build chunk
                    while ($count < $this->chunkSize && ($line = fgets($handle)) !== false) {
                        $decodedLine = json_decode($line, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $chunk[] = $decodedLine;
                        } else {
                            $this->logHandler->warning("Failed to decode line: $line");
                            $stats['failed_rows']++;
                        }
                        $count++;
                    }

                    // Process current chunk
                    $processor($chunk);

                    // Update statistics
                    $stats['processed_rows'] += count($chunk);
                    $stats['memory_peak'] = max($stats['memory_peak'], memory_get_peak_usage(true));

                    // Log progress
                    $this->logProgress($stats);

                    // Clean up
                    unset($chunk);
                    if ($stats['processed_rows'] % ($this->chunkSize * 10) === 0) {
                        gc_collect_cycles();
                    }
                } catch (Exception $e) {
                    $stats['failed_rows'] += count($chunk);
                    $this->logHandler->error('Chunk processing failed: ' . $e->getMessage());
                    continue;
                }
            }

            fclose($handle);
            return $this->generateReport($stats);
        } catch (Exception $e) {
            throw new Exception('Dataset processing failed: ' . $e->getMessage());
        }
    }

    private function logProgress(array $stats) {
        $memoryUsage = memory_get_usage(true) / 1024 / 1024;
        $timeElapsed = microtime(true) - $stats['start_time'];
        $rowsPerSecond = $stats['processed_rows'] / $timeElapsed;

        $this->logHandler->info(sprintf(
            'Processed %d rows | Memory: %.2f MB | Speed: %.2f rows/sec',
            $stats['processed_rows'],
            $memoryUsage,
            $rowsPerSecond
        ));
    }

    private function generateReport(array $stats) {
        return [
            'total_processed' => $stats['processed_rows'],
            'total_failed' => $stats['failed_rows'],
            'memory_peak_mb' => $stats['memory_peak'] / 1024 / 1024,
            'time_taken_sec' => microtime(true) - $stats['start_time'],
        ];
    }
}

// Example of use
class LogHandler {
    public function info($message) {
        echo "\nINFO: $message";
    }
    public function error($message) {
        echo "\nERROR: $message";
    }
    public function warning($message) {
        echo "\nWARNING: $message";
    }
}

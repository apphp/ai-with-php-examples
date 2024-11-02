<?php

class DatasetGenerator {
    private $bufferSize;

    public function __construct($bufferSize = 8192) {
        $this->bufferSize = $bufferSize;
    }

    public function readLargeFile($filename) {
        $handle = fopen($filename, 'r');

        while (!feof($handle)) {
            $buffer = fread($handle, $this->bufferSize);
            $lines = explode("\n", $buffer);

            foreach ($lines as $line) {
                if (trim($line) !== '') {
                    yield json_decode($line, true);
                }
            }
        }

        fclose($handle);
    }

    public function processBatchedData($filename, $batchSize = 100) {
        $batch = [];

        foreach ($this->readLargeFile($filename) as $item) {
            $batch[] = $item;

            if (count($batch) >= $batchSize) {
                yield $batch;
                $batch = [];
            }
        }

        if (!empty($batch)) {
            yield $batch;
        }
    }
}

<?php

class Fixtures {
    private $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

    public function generate() {
        $data = [
            'line' => array_map(function () { return rand(10, 100); }, range(1, 10)),
            'bar' => array_map(function () { return rand(10, 100); }, range(1, 5)),
            'pie' => array_map(function () { return rand(10, 100); }, range(1, 3)),
        ];

        if (!file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT))) {
            throw new Exception("Error: Unable to write fixtures to file.");
        }
    }

    public function getData() {
        if (!file_exists($this->filePath)) {
            throw new Exception("Error: Fixtures file not found.");
        }

        $data = json_decode(file_get_contents($this->filePath), true);
        if (!$data || !isset($data['line']) || !isset($data['bar']) || !isset($data['pie'])) {
            throw new Exception("Error: Invalid data in fixtures file.");
        }

        return $data;
    }
}

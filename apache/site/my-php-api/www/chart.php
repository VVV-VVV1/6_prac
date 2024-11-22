<?php
class ChartGenerator {
    private $imageDir;

    public function __construct($imageDir) {
        $this->imageDir = $imageDir;
        if (!file_exists($this->imageDir)) {
            mkdir($this->imageDir, 0777, true);
        }
    }

    public function generateLineChart($values, $fileName) {
        $this->createLineChart($values, $this->imageDir . '/' . $fileName);
    }

    public function generateBarChart($values, $fileName) {
        $this->createBarChart($values, $this->imageDir . '/' . $fileName);
    }

    public function generatePieChart($values, $fileName) {
        $this->createPieChart($values, $this->imageDir . '/' . $fileName);
    }

    public function addWatermark($fileName, $text) {
        $this->applyWatermark($this->imageDir . '/' . $fileName, $text);
    }


    private function createLineChart($values, $path) {
        // Реализация создания линейного графика (копируйте из вашего кода)
        $width = 800;
        $height = 400;
        $image = imagecreate($width, $height);

        $background = imagecolorallocate($image, 255, 255, 255);
        $lineColor = imagecolorallocate($image, 0, 0, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);

        imageline($image, 0, $height - 20, $width, $height - 20, $textColor); // X-Axis
        imageline($image, 20, 0, 20, $height, $textColor); // Y-Axis

        $maxValue = max($values);
        $step = ($width - 40) / count($values);

        foreach ($values as $i => $value) {
            if ($i > 0) {
                imageline(
                    $image,
                    20 + $step * ($i - 1), 
                    $height - 20 - ($values[$i - 1] / $maxValue) * ($height - 40),
                    20 + $step * $i,
                    $height - 20 - ($value / $maxValue) * ($height - 40),
                    $lineColor
                );
            }
        }

    imagepng($image, $path);
    imagedestroy($image);
    }

    private function createBarChart($values, $path) {
        $width = 800;
        $height = 400;
        $image = imagecreate($width, $height);

        $background = imagecolorallocate($image, 255, 255, 255);
        $barColor = imagecolorallocate($image, 0, 255, 0);
        $textColor = imagecolorallocate($image, 0, 0, 0);

        imageline($image, 0, $height - 20, $width, $height - 20, $textColor); // X-Axis
        imageline($image, 20, 0, 20, $height, $textColor); // Y-Axis

        $maxValue = max($values);
        $barWidth = ($width - 40) / count($values) - 10;

        foreach ($values as $i => $value) {
            $x1 = 30 + ($barWidth + 10) * $i;
            $y1 = $height - 20 - ($value / $maxValue) * ($height - 40);
            $x2 = $x1 + $barWidth;
            $y2 = $height - 20;

            imagefilledrectangle($image, $x1, $y1, $x2, $y2, $barColor);
        }

        imagepng($image, $path);
        imagedestroy($image);
    }

    private function createPieChart($values, $path) {
        $width = 400;
        $height = 400;
        $image = imagecreate($width, $height);

        $background = imagecolorallocate($image, 255, 255, 255);
        $colors = [
            imagecolorallocate($image, 255, 0, 0),
            imagecolorallocate($image, 0, 255, 0),
            imagecolorallocate($image, 0, 0, 255),
            imagecolorallocate($image, 255, 255, 0)
        ];

        $total = array_sum($values);
        $startAngle = 0;

        foreach ($values as $i => $value) {
            $endAngle = $startAngle + ($value / $total) * 360;
            imagefilledarc($image, $width / 2, $height / 2, $width - 20, $height - 20, $startAngle, $endAngle, $colors[$i % count($colors)], IMG_ARC_PIE);
            $startAngle = $endAngle;
        }

        imagepng($image, $path);
        imagedestroy($image);
    }

    private function applyWatermark($imagePath, $text) {
        $image = imagecreatefrompng($imagePath);
    if (!$image) {
        die("Error: Unable to open image for watermarking.");
    }

    $textColor = imagecolorallocatealpha($image, 0, 0, 0, 75); // Полупрозрачный черный цвет
    $fontSize = 5;
    $margin = 10;

    $textWidth = imagefontwidth($fontSize) * strlen($text);
    $textHeight = imagefontheight($fontSize);

    $x = imagesx($image) - $textWidth - $margin;
    $y = imagesy($image) - $textHeight - $margin;

    imagestring($image, $fontSize, $x, $y, $text, $textColor);

    imagepng($image, $imagePath);
    imagedestroy($image);
    }
}
?>

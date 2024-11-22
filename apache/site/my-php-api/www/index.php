<?php

require_once 'fixtures.php';
require_once 'chart.php';
require_once 'SessionManager.php';

try {
    // Настройка сессии
    $redisHost = getenv('REDIS_HOST');
    $redisPort = getenv('REDIS_PORT');
    new SessionManager($redisHost, $redisPort);

    // Работа с фикстурами
    $fixtures = new Fixtures(__DIR__ . '/fixtures/fixtures.json');
    $fixtures->generate();
    $data = $fixtures->getData();

    // Генерация графиков
    $chartGenerator = new ChartGenerator(__DIR__ . '/images');
    $chartGenerator->generateLineChart($data['line'], 'line_chart.png');
    $chartGenerator->generateBarChart($data['bar'], 'bar_chart.png');
    $chartGenerator->generatePieChart($data['pie'], 'pie_chart.png');

    // Добавление водяных знаков
    $chartGenerator->addWatermark('line_chart.png', 'Pavel Trineev');
    $chartGenerator->addWatermark('bar_chart.png', 'Pavel Trineev');
    $chartGenerator->addWatermark('pie_chart.png', 'Pavel Trineev');
} catch (Exception $e) {
    die($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div>
        <img src="images/line_chart.png" alt="Line Chart">
        <img src="images/bar_chart.png" alt="Bar Chart">
        <img src="images/pie_chart.png" alt="Pie Chart">
    </div>
</body>
</html>

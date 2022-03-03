<?php

namespace app\commands;

use app\services\ParsingService;
use yii\console\Controller;

class ParsingController extends Controller
{
    private $service;

    public function __construct($id, $modules, $config = [])
    {
        $this->service = new ParsingService();

        parent::__construct($id, $modules, $config);
    }

    public function actionDromRecords(int $start = 45000000, int $num = 10)
    {
        $arr = $this->service->carsDromRu($start, $num);

        foreach ($arr as $car) {
            if (!empty($car))
                $this->service->createCar($car);
        }

        echo 'Автомобили добавлены' . PHP_EOL;
    }

    public function actionDromEntry(int $id = 40000000)
    {
        $car = $this->service->carDromRu($id);
        $this->service->createCar($car);

        echo 'Автомобиль добавлен' . PHP_EOL;
    }
}
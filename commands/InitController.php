<?php

namespace app\commands;

use app\components\Parser;
use app\entities\EntityCar;
use app\entities\EntityCountry;
use app\entities\EntityLocality;
use app\entities\EntityOption;
use app\entities\EntityRegion;
use app\services\CarService;
use app\services\CountryService;
use app\services\LocalityService;
use app\services\ParsingService;
use app\services\RegionService;
use yii\console\Controller;

class InitController extends Controller
{
    private $locality;
    private $region;
    private $parser;
    private $country;

    public function __construct($id, $modules, $config = [])
    {
        $this->locality = new LocalityService(new EntityLocality());
        $this->region = new RegionService(new EntityRegion());
        $this->country = new CountryService(new EntityCountry());

        $this->parser = new ParsingService();

        parent::__construct($id, $modules, $config);
    }

    public function actionData()
    {
        $this->City();
    }

    public function City()
    {
        $this->country->create(['title' => 'Россия']);
        $arr = $this->country->list();

        $id = 1;
        foreach ($arr as $num)
            if ($num['title'] == 'Россия')
                $id = $num['id'];


        $arr = $this->parser->parserCity();

        foreach ($arr as $key => $num)
            $regions[] = $num[3];

        $regions = array_unique($regions);


        foreach ($regions as $num)
            $this->region->create(['title' => $num, 'country_id' => $id]);

        $regions = $this->region->list();

        foreach ($arr as $key => $a) {
            foreach ($regions as $b)
            {
                if ($arr[$key][3] == $b['title'])
                    $arr[$key][3] = $b['id'];
            }
        }

        foreach ($arr as $num) {
            $this->locality->create(['title' => $num[2], 'region_id' => $num[3]]);
        }

        echo 'Регионы и города России добавленны' . PHP_EOL;
    }
}
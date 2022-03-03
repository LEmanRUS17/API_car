<?php

namespace app\commands;

use app\services\CarService;
use app\services\CountryService;
use app\services\LocalityService;
use app\services\OptionService;
use app\services\RegionService;
use app\services\UserService;
use Faker\Factory;
use Faker\Provider\Fakecar;

use yii\console\Controller;
use yii\console\ExitCode;

class GeneratorController extends Controller
{
    private $serviceOption;
    private $serviceCountry;
    private $serviceRegion;
    private $serviceLocality;
    private $serviceUser;
    private $serviceCar;

    public function __construct($id,
                                $modules,
                                $config = [],
                                OptionService $option,
                                CountryService $country,
                                RegionService $region,
                                LocalityService $locality,
                                UserService $user,
                                CarService $car)
    {
        $this->serviceOption = $option;
        $this->serviceCountry = $country;
        $this->serviceRegion = $region;
        $this->serviceLocality = $locality;
        $this->serviceUser = $user;
        $this->serviceCar = $car;


        parent::__construct($id, $modules, $config);
    }

    public function actionOption(int $num = 1)
    {
        for ($i = 0; $i < $num; $i++ )
        {
            $faker = Factory::create('ru_RU');

            $arr['title'] = $faker->text(10);
            $this->serviceOption->create($arr);
        }

        echo 'Генерация опций завершена' . PHP_EOL;
        return ExitCode::OK;
    }

    public function actionCountry(int $num = 1)
    {
        for ($i = 0; $i < $num; $i++ )
        {
            $faker = Factory::create('ru_RU');
            $arr['title'] = $faker->country;
            $this->serviceCountry->create($arr);
        }

        echo 'Генерация стран завершена' . PHP_EOL;
        return ExitCode::OK;
    }

    public function actionRegion(int $num = 1)
    {
        $list = $this->serviceCountry->list();

        for ($i = 0; $i < $num; $i++ )
        {
            $faker = Factory::create('ru_RU');
            $key = array_rand($list);
            $arr['country_id'] = $list[$key]['id'];
            $arr['title'] = $faker->city;

            $this->serviceRegion->create($arr);
        }

        echo 'Генерация регионов завершена' . PHP_EOL;
        return ExitCode::OK;
    }

    public function actionLocality(int $num = 1)
    {
        $list = $this->serviceRegion->list();

        for ($i = 0; $i < $num; $i++)
        {
            $faker = Factory::create('ru_RU');

            $key = array_rand($list);
            $arr['region_id'] = $list[$key]['id'];
            $arr['title'] = $faker->city;

            $this->serviceLocality->create($arr);
        }

        echo 'Генерация населенных пунктов завершена' . PHP_EOL;
        return ExitCode::OK;
    }

    public function actionUser(int $num = 1)
    {
        for ($i = 0; $i < $num; $i++ )
        {
            $faker = Factory::create('ru_RU');
            $arr['lastname'] = $faker->lastName;
            $arr['firstname'] = $faker->firstName;
            $arr['surname'] = $faker->userName;
            $arr['telephone'] = $faker->phoneNumber;
            $arr['mail'] = $faker->email;

            $this->serviceUser->create($arr);
        }

        echo 'Генерация пользователей завершена' . PHP_EOL;
        return ExitCode::OK;
    }

    public function actionCar(int $num = 1)
    {
        $listLocation = $this->serviceLocality->list();
        $listUser = $this->serviceUser->listUser();
        $listOption = $this->serviceOption->list();

        for ($i = 0; $i < $num; $i++) {

            $faker = Factory::create('ru_RU');

            $arr['title'] = $faker->title;
            $arr['decoration'] = $faker->text(200);
            $arr['price'] = $faker->numberBetween(100, 1000000);
            $arr['user'] = $listUser[array_rand($listUser)]['id'];
            $arr['locality'] = $listLocation[array_rand($listLocation)]['id'];

            $_FILES['photos'] = [
                'name' => ['test.jpg'],
                'type' => ['image/jpeg'],
                'tmp_name' => ['/var/www/html/projectyii/API_test/web/image/imageTest/test'],
                'error' => [0],
                'size' => [52066]];

            if($a = rand(1,2) % 2) {
                $arr['specification']['brand'] = $faker->title;
                $arr['specification']['model'] = $faker->title;
                $arr['specification']['body'] = $faker->title;
                $arr['specification']['mileage'] = $faker->numberBetween(100, 1000000);
                $arr['specification']['year_of_issue'] = $faker->numberBetween(1980, 2010);
            }

            if($a = rand(1,2) % 2) {
                $numberOption = rand(1, 5);
                $arrOption = [];
                for ($i = 1; $i < $numberOption; $i++) {
                    $arrOption[] = $listOption[array_rand($listOption)]['id'];
                }
                $arr['options'] = array_unique($arrOption);
            }

            $this->serviceCar->create($arr);
        }

        echo 'Генерация машин завершена' . PHP_EOL;
        return ExitCode::OK;
    }
}
<?php

use app\tests\fixtures\CarFixture;
use app\tests\fixtures\CarOptionFixture;
use app\tests\fixtures\CountryFixture;
use app\tests\fixtures\LocalityFixture;
use app\tests\fixtures\OptionFixture;
use app\tests\fixtures\RegionFixture;
use app\tests\fixtures\UserCarFixture;
use app\tests\fixtures\UserFixture;
use Codeception\Util\HttpCode;
use Faker\Factory;

class CarCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'Car' => CarFixture::class,
            'Option' => OptionFixture::class,
            'CarOption' => CarOptionFixture::class,
            'Locality' => LocalityFixture::class,
            'Region' => RegionFixture::class,
            'Country' => CountryFixture::class,
            'User' => UserFixture::class,
            'UserCar' => UserCarFixture::class
        ]);
    }

    // tests
    public function createNewCar(ApiTester $I)
    {
        $faker = Factory::create();
        $I->sendPost(
            '/car/create',
            [
                'title' => $faker->title,
                'decoration' => $faker->text(200),
                'price' => $faker->numberBetween(100, 1000000),
                'user' => 51,
                'locality' => 51,
                'specification' => [
                    'brand' => $faker->title,
                    'model' => $faker->title,
                    'body' => $faker->title,
                    'mileage' => $faker->numberBetween(100, 100000),
                    'year_of_issue' => $faker->numberBetween(1980, 2020)
                ],
                'options' => [51]
            ],
            ['photos' => $faker->image]
        );

        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => ['message' => 'Машина создана']]);
    }

    public function getAllCars(ApiTester $I)
    {
        $I->sendGet('/car/list');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"object"}');
        $validResponseJsonSchema = [
            'properties' => [
                'list' => ['type' => 'array'],
                'totalCount' => ['type' => 'integer'],
                'pagination' => ['type' => 'string']
            ]
        ];
        $I->seeResponseIsValidOnJsonSchemaString(json_encode($validResponseJsonSchema));
    }

//    public function getCar(ApiTester $I)
//    {
//        $I->sendGet('/car/view?id=51'); // Метод запроса sendPost, sendPut, sendPatch, sendDelete, sendPatch
//        $I->seeResponseCodeIs(HttpCode::OK);
//        $I->seeResponseIsJson(); // Проверка структуры
//        $I->seeResponseIsValidOnJsonSchemaString('{"type":"object"}');
//        $validResponseJsonSchema = [
//            'properties' => [
//                'id' => ['type' => 'integer'],
//                'title' => ['type' => 'string'],
//                'decoration' => ['type' => 'string'],
//                'price' => ['type' => 'integer'],
//                'photo' => ['type' => 'array'],
//                'locality' => ['type' => 'object'],
//                'options' => ['type' => 'array']
//            ]
//        ];
//        $I->seeResponseIsValidOnJsonSchemaString(json_encode($validResponseJsonSchema));
//    }
}

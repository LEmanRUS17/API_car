<?php

use Codeception\Util\HttpCode;
use Faker\Factory;

class CarCest extends ApiTester
{

    public function _before(ApiTester $I)
    {
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
                'user' => 1,
                'locality' => 1,
                'specification' => [
                    'brand' => $faker->title,
                    'model' => $faker->title,
                    'body' => $faker->title,
                    'mileage' => $faker->numberBetween(100, 100000),
                    'year_of_issue' => $faker->numberBetween(1970, 2020)
                ],
                'options' => [1]
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

    public function getCar(ApiTester $I)
    {
        $I->sendGet('/car/view?id=101'); // Метод запроса sendPost, sendPut, sendPatch, sendDelete, sendPatch
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson(); // Проверка структуры
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"object"}');
        $validResponseJsonSchema = [
            'properties' => [
                'id' => ['type' => 'integer'],
                'title' => ['type' => 'string'],
                'decoration' => ['type' => 'string'],
                'price' => ['type' => 'integer'],
                'photo' => ['type' => 'array'],
                'locality' => ['type' => 'object'],
                'options' => ['type' => 'array']
            ]
        ];
        $I->seeResponseIsValidOnJsonSchemaString(json_encode($validResponseJsonSchema));
    }

}

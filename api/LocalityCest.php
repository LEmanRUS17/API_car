<?php

use Codeception\Util\HttpCode;
use Faker\Factory;

class LocalityCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

    public function getAllLocations(ApiTester $I)
    {
        $I->sendGet('/locality/list');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"array"}');
        $validResponseJsonSchema = json_encode(
            [
                'properties' => [
                    'id'         => ['type' => 'integer'],
                    'country_id' => ['type' => 'integer'],
                    'title'       => ['type' => 'string'],
                ]
            ]
        );
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    public function createNewRegion(ApiTester $I) {

        $faker = Factory::create();
        $I->sendPost(
            '/locality/create',
            [
                'country_id' => 1,
                'region_id' => 1,
                'title' => $faker->city,
            ]
        );
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => ['message' => 'Населенный пункт дабавлен']]);
    }

    public function deleteRegion(ApiTester $I) {

        $I->sendDelete('/locality/delete?id=101');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
        //try to get deleted user
        $I->sendGet('option/101');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
    }
}

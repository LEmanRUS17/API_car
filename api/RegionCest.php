<?php

use Codeception\Util\HttpCode;
use Faker\Factory;

class RegionCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

    public function getAllRegions(ApiTester $I)
    {
        $I->sendGet('/region/list');
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
            '/region/create',
            [
                'country_id' => 1,
                'title' => $faker->name,
            ]
        );
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => ['message' => 'Регион дабавлен']]);
    }

    public function deleteRegion(ApiTester $I) {

        $I->sendDelete('/region/delete?id=101');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
        //try to get deleted user
//        $I->sendGet('option/1');
//        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
//        $I->seeResponseIsJson();
    }
}

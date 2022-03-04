<?php

use app\tests\fixtures\LocalityFixture;
use app\tests\fixtures\RegionFixture;
use Codeception\Util\HttpCode;
use Faker\Factory;

class LocalityCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'locality' => LocalityFixture::class,
            'Region' => RegionFixture::class
        ]);
    }

    // tests
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
                'region_id' => 51,
                'title' => $faker->city,
            ]
        );
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => ['message' => 'Населенный пункт дабавлен']]);
    }

    public function deleteRegion(ApiTester $I) {

        $I->sendDelete('/locality/delete?id=51');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

    }
}

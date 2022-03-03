<?php

use app\tests\fixtures\CountryFixture;
use Codeception\Util\HttpCode;
use Faker\Factory;

class CountryCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures(['Country' => CountryFixture::class]);
    }

    // tests
    public function getAllLocations(ApiTester $I)
    {
        $I->sendGet('/country/list');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"array"}');
        $validResponseJsonSchema = json_encode(
            [
                'properties' => [
                    'id'         => ['type' => 'integer'],
                    'title'       => ['type' => 'string'],
                ]
            ]
        );
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    public function createNewRegion(ApiTester $I) {

        $faker = Factory::create();
        $I->sendPost(
            '/country/create',
            [
                'country_id' => 1,
                'title' => $faker->country,
            ]
        );
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => ['message' => 'Страна дабавленна']]);
    }

    public function deleteRegion(ApiTester $I) {

        $I->sendDelete('/country/delete?id=51');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
}

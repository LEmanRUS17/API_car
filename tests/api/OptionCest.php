<?php

use app\tests\fixtures\OptionFixture;
use Codeception\Util\HttpCode;
use Faker\Factory;

class OptionCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures(['option' => OptionFixture::class]);
    }

    // tests
    public function getAllOptions(ApiTester $I)
    {
        $I->sendGet('/option/list');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"array"}');
        $validResponseJsonSchema = json_encode(
            [
                'properties' => [
                    'id' => ['type' => 'integer'],
                    'title' => ['type' => 'string'],
                ]
            ]
        );
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    public function createNewOption(ApiTester $I)
    {

        $faker = Factory::create();
        $I->sendPost('/option/create',
            [
                'title' => $faker->name,
            ]
        );
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => ['message' => 'Опция дабавленна']]);
    }

    public function getMember(ApiTester $I) {

        $I->sendGet('/option/get?id=51');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"object"}');
        $validResponseJsonSchema = json_encode(
            [
                'properties' => [
                    'id' => ['type' => 'integer'],
                    'title' => ['type' => 'string'],
                ]
            ]
        );
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    public function deleteOption(ApiTester $I)
    {
        $I->sendDelete('/option/delete?id=51');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
        // try to get deleted option
        $I->sendGet('/option/get?id=51');
        $I->seeResponseCodeIs(HttpCode::MISDIRECTED_REQUEST);
        $I->seeResponseIsJson();
    }
}

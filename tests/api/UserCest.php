<?php

use app\tests\fixtures\CarFixture;
use app\tests\fixtures\CountryFixture;
use app\tests\fixtures\LocalityFixture;
use app\tests\fixtures\RegionFixture;
use app\tests\fixtures\UserCarFixture;
use app\tests\fixtures\UserFixture;
use Codeception\Util\HttpCode;
use Faker\Factory;

class UserCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'User' => UserFixture::class,
            'UserCar' => UserCarFixture::class,
            'Car' => CarFixture::class,
            'Locality' => LocalityFixture::class,
            'Region' => RegionFixture::class,
            'Country' => CountryFixture::class
        ]);
    }

    // tests
    public function getAllMembers(ApiTester $I)
    {
        $I->sendGet('/user/list');
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

    public function getUser(ApiTester $I)
    {
        $I->sendGet('/user/view?id=51'); // Метод запроса sendPost, sendPut, sendPatch, sendDelete, sendPatch
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson(); // Проверка структуры
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"object"}');
        $validResponseJsonSchema = [
            'properties' => [
                'id' => ['type' => 'integer'],
                'lastname' => ['type' => 'string'],
                'firstname' => ['type' => 'string'],
                'surname' => ['type' => 'string'],
                'telephone' => ['type' => 'string'],
                'mail' => ['type' => 'string'],
                'cars' => ['type' => 'array']
            ]
        ];
        $I->seeResponseIsValidOnJsonSchemaString(json_encode($validResponseJsonSchema));
    }

    public function createNewUser(ApiTester $I)
    {

        $faker = Factory::create();
        $I->sendPost(
            '/user/create',
            [
                'lastname' => $faker->lastName,
                'firstname' => $faker->firstName,
                'surname' => $faker->userName,
                'telephone' => $faker->phoneNumber,
                'mail' => $faker->email,
            ]
        );
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => ['message' => 'Владелец создан']]);
    }

    public function updateUser(ApiTester $I)
    {
        $faker = Factory::create();
        $newName = $faker->name;
        $I->sendPost(
            '/user/update?id=51',
            [
                'lastname' => $newName,
                'firstname' => $newName,
                'surname' => $newName,
                'telephone' => 88005553535,
                'mail' => 'test@mail.ru',
            ]
        );
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => ['message' => 'Владелец обновлен']]);
    }

    public function deleteUser(ApiTester $I) {

        $I->sendDelete('/user/delete?id=51');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
        // пытаемся получить удаленного пользователя
        $I->sendGet('/user/view?id=51');
        $I->seeResponseCodeIs(HttpCode::MISDIRECTED_REQUEST);
        $I->seeResponseIsJson();
    }
}

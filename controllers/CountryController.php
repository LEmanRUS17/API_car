<?php

namespace app\controllers;


use app\services\CountryService;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\tests\Fixture;

class CountryController extends Controller
{
    private $service;

    public function __construct($id, $modules, CountryService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $modules, $config);
    }

    public function actionTest()
    {
        $test = new \app\tests\Fixture();
        $test->testFix();
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['delete'],
                    'list'   => ['get'],
                ]
            ]
        ];
    }

    public function actionCreate()
    {
        $result = $this->service->create(Yii::$app->request->post());

        Yii::$app->response->statusCode = 201;
        return $result;
    }

    public function actionDelete(int $id)
    {
        $result = $this->service->delete($id);

        Yii::$app->response->statusCode = 204;
        return $result;
    }

    public function actionList()
    {
        return $this->service->list();
    }
}
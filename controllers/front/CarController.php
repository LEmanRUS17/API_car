<?php

namespace app\controllers\front;

use app\entities\EntityCar;
use app\entities\EntityOption;
use app\services\CarService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class CarController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;

        return $this->render('index');
    }

    public function actionView(int $id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;

        $service = new CarService(new EntityCar([]));
        $car = $service->get($id);

        return $this->render('view', compact('car'));
    }

    public function actionCreate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        return $this->render('create');
    }
}
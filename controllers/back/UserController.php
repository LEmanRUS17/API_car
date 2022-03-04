<?php

namespace app\controllers\back;

use app\components\YourLinkPager;
use app\services\UserService;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class UserController extends Controller
{
    private $service;

    public function __construct($id, $modules, UserService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $modules, $config);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create'          => ['post'],
                    'update'          => ['get', 'post'],
                    'delete'          => ['delete'],
                    'view'            => ['get'],
                    'list'            => ['get'],
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

    public function actionUpdate(int $id)
    {
        $user = $this->service->get($id);

        if (Yii::$app->request->isPost)
            $user = $this->service->update(Yii::$app->request->post());

        return $user;
    }

    public function actionDelete(int $id)
    {
        $result = $this->service->delete($id);

        Yii::$app->response->statusCode = 204;
        return $result;
    }

    public function actionView(int $id)
    {
        return $this->service->get($id);
    }

    public function actionList()
    {
        $list = $this->service->list();

        $link = new YourLinkPager(['pagination' => $list->pagination]);

        return [
            'list' => $list,
            'totalCount' => $list->totalCount,
            'pagination' =>  $link->getPage(),
        ];
    }
}
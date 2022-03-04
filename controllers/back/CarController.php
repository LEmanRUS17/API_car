<?php
namespace app\controllers\back;

use app\components\YourLinkPager;
use app\services\CarService;
use Faker\Factory;
use PHPUnit\Util\FileLoader;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class CarController extends Controller
{
    private $service;

    public $enableCsrfValidation = false;

    public function __construct($id, $modules, CarService $service, $config = [])
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
                    'search'          => ['get'],
                    'search-advanced' => ['post']
                ]
            ]
        ];
    }

    public function actionCreate() // создать
    {
        $result = $this->service->create(Yii::$app->request->post());

        Yii::$app->response->statusCode = 201;
        return $result;
    }

    public function actionUpdate(int $id) // обновить
    {
        $car = $this->service->get($id);

        if (Yii::$app->request->isPost)
            $car = $this->service->update(Yii::$app->request->post());

        return $car;
    }

    public function actionDelete(int $id)
    {
        $result = $this->service->delete($id);

        Yii::$app->response->statusCode = 204;
        return $result;
    }

    public function actionView(int $id) // просмотр
    {
        return $this->service->get($id);
    }

    public function actionList() // список записей
    {
        $list = $this->service->list();
        $link = new YourLinkPager(['pagination' => $list->pagination]);

        return [
            'list'       => $list,
            'totalCount' => $list->totalCount,
            'pagination' => $link->getPage(),
        ];
    }

    public function actionSearch(string $value) // Поиск
    {
        $list = $this->service->search(['title' => $value]);
        $link = new YourLinkPager(['pagination' => $list->pagination]);

        return [
            'list'       => $list,
            'totalCount' => $list->totalCount,
            'pagination' => $link->getPage(),
        ];
    }

    public function actionSearchAdvanced()
    {
        $list = $this->service->searchAdvanced(Yii::$app->request->post());
        $link = new YourLinkPager(['pagination' => $list->pagination]);

        return [
            'list'       => $list,
            'totalCount' => $list->totalCount,
            'pagination' => $link->getPage(),
        ];
    }
}



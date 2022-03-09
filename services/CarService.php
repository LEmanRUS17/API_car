<?php

namespace app\services;

use app\director\CreateCarValidateDirector;
use app\director\GetValidatorDirector;
use app\director\SearchDataValidateDirector;
use app\director\ValidateDirector;
use app\dataMapper\CarMapper;
use app\dataMapper\ImageMapper;
use app\dataMapper\OptionMapper;
use app\dataMapper\SpecificationMapper;
use app\entities\EntityCar;

use app\entities\EntitySpecification;
use app\entities\EntityLocality;
use app\entities\EntityOption;
use app\interface\CarServicesInterface;
use app\interface\ServicesInterface;
use app\storage\CarStorage;

use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class CarService implements ServicesInterface, CarServicesInterface // Сервисный класс для контроллера CarController
{
    private $storage; // хранилище
    private $entity;

    public function __construct(EntityCar $entity)
    {
        $this->entity = $entity;
        $this->storage = new CarStorage(new CarMapper($this->entity),
                                        new SpecificationMapper($this->entity),
                                        new OptionMapper($this->entity),
                                        new ImageMapper($this->entity));
    }

    public function create(array $arr)
    {
//        print_r($arr);
//        die;
        $this->filling($arr);

        $validator = new CreateCarValidateDirector($this->entity);
        if (!$validator->validate())
            return $validator->validate();

        $this->uploadImage();
        $this->storage->create();

        return ['success' => ['message' => 'Машина создана']];
    }

    public function createPars(array $arr)
    {
        $this->filling($arr);
        $this->storage->create();
    }

    public function update(array $arr)
    {
        $this->filling($arr);

        $validator = new ValidateDirector($this->entity);
        if (!$validator->validate())
            return $validator->validate();

        $img = $this->storage->imagePath();

            $this->uploadImage();
            $this->storage->update();
            $this->deleteImg($img);


        return ['success' => ['message' => 'Машина обновлена']];
    }

    public function delete(int $id)
    {
        $this->entity->init(['id' => $id]);

        $validator = new GetValidatorDirector($this->entity);
        if (!$validator->validate())
            return $validator->validate();

        $img = $this->storage->imagePath();

            $this->storage->delete();
            $this->deleteImg($img);


        return ['success' => ['message' => 'Машина удалена']];
    }

    public function get(int $id)
    {
        $this->entity->init(['id' => $id]);

        $validator = new GetValidatorDirector($this->entity);
        if (!$validator->validate())
            return $validator->validate();

        $this->storage->get();
        return $this->entity->getAll();
    }

    public function search(array $arr)
    {
        $this->entity->init($arr);

        $dataProvider = $this->storage->search();

        $arr = $dataProvider->getModels();
        $result = $this->getEntity($arr);
        $dataProvider->setModels($result);

        return $dataProvider;
    }

    private function filling(array $arr) // Внести данные в entity
    {
        if(empty($arr['photos']))
            $arr['photos'] = UploadedFile::getInstancesByName('photos');

        if(is_array($arr['locality'])) {
            $arr['locality']['locality'] = new EntityLocality(['id' => $arr['locality']['locality']]);
            $arr['locality']['region'] = new EntityLocality(['id' => $arr['locality']['region']]);
            $arr['locality']['country'] = new EntityLocality(['id' => $arr['locality']['country']]);
        }

        $this->entity->init($arr);

        if (isset($arr['specification'])) {
            $this->entity->setSpecification(new EntitySpecification($arr['specification']));
        }

        $result = [];
        if(isset($arr['options'])) {
            foreach ($arr['options'] as $elem) {
                    $result[] = new EntityOption(['id' => $elem, 'title' => $elem]);
            }
        }

        $this->entity->setOptions($result);
    }

    private function uploadImage()
    {
        $photos = $this->entity->getPhotos();

        $str = [];

        foreach ($photos as $key => $num) {
            $path = dirname(dirname(__FILE__)) . '/web/image/';
            FileHelper::createDirectory($path);
            $rand = rand();
            $num->saveAs($path . time() . '_' . $key. '_' . $rand . '.' . $num->extension);
            $str[] = '/image/' . time() . '_' .$key. '_' . $rand . '.'. $num->extension;
        }

        $this->entity->setPhotos($str);
    }

    private function deleteImg(array $img)
    {
        foreach ($img as $num)
            $path['photo'] = dirname(dirname(__FILE__)) . '/web' . $num['photo'];
            unlink(array_shift($path));
    }

    private function getEntity(array $arr)
    {
        $arrResult = [];
        foreach ($arr as $elem) {
            $arrResult[] = $elem->getAll();
        }
        return $arrResult;
    }

    public function list()
    {
        $dataProvider = $this->storage->list();

        $arr = $dataProvider->getModels();
        $arr = $this->getEntity($arr);
        $dataProvider->setModels($arr);

        return $dataProvider;
    }

    public function searchAdvanced(array $arr)
    {
        $this->filling($arr);

        $validate = new SearchDataValidateDirector($this->entity);
        $validate->validate();

        $dataProvider = $this->storage->searchAdvanced();

        $arr = $dataProvider->getModels();
        $result = $this->getEntity($arr);
        $dataProvider->setModels($result);

        return $dataProvider;
    }

    public function listCar()
    {
        $cars = $this->storage->listCar();

        $arrResult = [];
        foreach ($cars as $elem) {
            $arrResult[] = $elem->getId();
        }

        return $arrResult;
    }

}
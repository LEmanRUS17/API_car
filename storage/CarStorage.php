<?php

namespace app\storage;

use app\dataMapper\CarMapper;
use app\dataMapper\ImageMapper;
use app\dataMapper\OptionMapper;
use app\dataMapper\SpecificationMapper;
use app\dataMapper\UserMapper;
use app\interface\CarStorageInterface;
use app\interface\StorageInterface;
use Yii;
use yii\base\ExitException;
use yii\data\ArrayDataProvider;
use yii\db\Exception;
use yii\db\IntegrityException;

class CarStorage implements StorageInterface, CarStorageInterface
{
    private $mapper;
    private $specificationMapper;
    private $optionMapper;

    public function __construct(CarMapper $mapper, SpecificationMapper $specificationMapper, OptionMapper $optionMapper, ImageMapper $imageMapper)
    {
        $this->mapper = $mapper;
        $this->specificationMapper = $specificationMapper;
        $this->optionMapper = $optionMapper;
        $this->imageMapper = $imageMapper;
        $this->db = Yii::$app->db; // Подключение Базы данных
    }

    public function create()
    {
        $transaction = $this->db->beginTransaction();
        try {
            $this->mapper->createCar();

            $id = $this->db->getLastInsertId();

            $this->mapper->createUserCar($id);
            $this->imageMapper->create($id);
            $this->specificationMapper->createSpecification($id);
            $this->optionMapper->createCarOption($id);

            $transaction->commit();
        } catch(Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function update()
    {
        $transaction = $this->db->beginTransaction();
        try {
            $this->specificationMapper->deleteSpecification();
            $this->optionMapper->deleteOptions();
            $this->imageMapper->deletePhotos();

            $this->mapper->updateCar();

            $this->specificationMapper->createSpecification();
            $this->optionMapper->createCarOption();
            $this->imageMapper->create();

            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function delete()
    {
        $this->mapper->delete();
    }

    public function get()
    {
        $this->mapper->get();
    }

    public function list()
    {
        return $this->mapper->list();
    }

    public function search()
    {
        return $this->mapper->search();
    }

    public function imagePath()
    {
        return $this->mapper->imagePath();
    }

    public function searchAdvanced()
    {
        return $this->mapper->searchAdvanced();
    }

    public function listCar()
    {
        return $this->mapper->listCar();
    }

}
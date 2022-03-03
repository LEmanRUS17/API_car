<?php

namespace app\dataMapper;


use app\director\SearchDirector;
use app\entities\EntityCar;
use app\entities\EntitySpecification;
use app\entities\EntityCountry;
use app\entities\EntityLocality;
use app\entities\EntityOption;
use app\entities\EntityPhoto;
use app\entities\EntityRegion;
use app\entities\EntityUser;
use app\interface\CarMapperInterface;
use app\interface\MapperInterface;
use Yii;
use yii\data\SqlDataProvider;

class CarMapper implements MapperInterface, CarMapperInterface
{
    private $entityCar; // entity
    private $db;        // БД

    public function __construct(EntityCar $entityCar)
    {
        $this->entityCar = $entityCar; // Подключение entity
        $this->db = Yii::$app->db; // Подключение Базы данных
    }

    public function get() // Получить обект по id
    {
        $result = $this->db->createCommand("
            select c.*, 
            jsonb_array_elements(jsonb_agg(distinct s.*)) as specification,
            jsonb_agg(distinct o.*) as options,
            jsonb_array_elements(jsonb_agg(distinct u.*)) as user,
            jsonb_agg(distinct i.*) as photos,
            jsonb_array_elements(jsonb_agg(distinct l.*)) as locality,
            jsonb_array_elements(jsonb_agg(distinct r.*)) as region,
            jsonb_array_elements(jsonb_agg(distinct c2.*)) as country 
            from car c 
                left join user_car uc on c.id = uc.car_id 
                left join \"user\" u on uc.user_id = u.id 
                left join specification s on c.id = s.car_id
                left join car_option co on c.id = co.car_id
                left join option o on co.option_id = o.id
                left join image i on c.id = i.car_id 
                left join locality l on c.locality = l.id 
                left join region r on l.region_id = r.id 
                left join country c2 on r.country_id = c2.id 
            where c.id = :id group by c.id, c.title, c.decoration, c.price
        ", [':id' => $this->entityCar->getId()])->queryOne();

        $this->entityCar->init($result);
        $this->fillingInit($this->entityCar, $result);
    }

    public function createCar() // Добавить машину
    {
        $this->db->createCommand("INSERT INTO car (title, decoration, price, locality) 
            VALUES (:title, :decoration, :price, :locality)", [
            ':title' => $this->entityCar->getTitle(),
            ':decoration' => $this->entityCar->getDecoration(),
            ':price' => $this->entityCar->getPrice(),
            ':locality' => $this->entityCar->getLocality()
        ])->execute();
    }

    public function delete() // Удаление записи из бд по id
    {
        $this->db->createCommand("DELETE FROM car WHERE id = :id", [':id' => $this->entityCar->getId()])->execute(); // запрос в бд на удаление записи
    }

    public function updateCar() // Обновление характеристик машины
    {
        $this->db->createCommand("UPDATE car
            SET 
                title      = :title,
                decoration = :decoration,
                price      = :price,
                locality   = :locality
            WHERE id = :id", [
            ':title' => $this->entityCar->getTitle(),
            ':decoration' => $this->entityCar->getDecoration(),
            ':price' => $this->entityCar->getPrice(),
            ':locality' => $this->entityCar->getLocality(),
            ':id' => $this->entityCar->getId()
        ])->execute();
    }

    public function list()
    {
        $dataProvider = new SqlDataProvider([
            'sql' => '
                select c.*, 
                jsonb_array_elements(jsonb_agg(distinct s.*)) as specification,
                jsonb_agg(distinct o.*) as options,
                jsonb_array_elements(jsonb_agg(distinct u.*)) as user,
                jsonb_agg(distinct i.*) as photos,
                jsonb_array_elements(jsonb_agg(distinct l.*)) as locality,
                jsonb_array_elements(jsonb_agg(distinct r.*)) as region,
                jsonb_array_elements(jsonb_agg(distinct c2.*)) as country 
                from car c 
                    left join user_car uc on c.id = uc.car_id 
                    left join "user" u on uc.user_id = u.id 
                    left join specification s on c.id = s.car_id
                    left join car_option co on c.id = co.car_id
                    left join option o on co.option_id = o.id
                    left join image i on c.id = i.car_id 
                    left join locality l on c.locality = l.id 
                    left join region r on l.region_id = r.id 
                    left join country c2 on r.country_id = c2.id 
                group by c.id, c.title, c.decoration, c.price
            ', //запрос на выборку
            'totalCount' => $this->countList(), // количество
            'pagination' => [ // постраничная разбивка
                'pageSize' => 10, // 10 на странице
            ],
            'sort' => [
                'attributes' => [
                    'id'
                ]
            ]
        ]);

        $arr = $dataProvider->getModels();
        $arr = $this->entityInit($arr);
        $dataProvider->setModels($arr);

        return $dataProvider;
    }

    public function countList()
    {
        return $this->db->createCommand('SELECT COUNT(*) FROM car')->queryScalar();
    }

    public function search()
    {
        $string = $this->entityCar->getTitle();

        $dataProvider = new SqlDataProvider([
            'sql' => "
                select c.*, 
                jsonb_array_elements(jsonb_agg(distinct s.*)) as specification,
                jsonb_agg(distinct o.*) as options,
                jsonb_array_elements(jsonb_agg(distinct u.*)) as user,
                jsonb_agg(distinct i.*) as photos,
                jsonb_array_elements(jsonb_agg(distinct l.*)) as locality,
                jsonb_array_elements(jsonb_agg(distinct r.*)) as region,
                jsonb_array_elements(jsonb_agg(distinct c2.*)) as country 
                from car c 
                    left join user_car uc on c.id = uc.car_id 
                    left join \"user\" u on uc.user_id = u.id 
                    left join specification s on c.id = s.car_id
                    left join car_option co on c.id = co.car_id
                    left join option o on co.option_id = o.id
                    left join image i on c.id = i.car_id 
                    left join locality l on c.locality = l.id 
                    left join region r on l.region_id = r.id 
                    left join country c2 on r.country_id = c2.id
                where c.title = :string
	                or c.decoration = :string
	                or s.body = :string
	                or s.brand = :string
	                or s.model = :string
	                or l.title = :string
	                or r.title = :string
	                or c2.title like :string
                    or c.price = :int
                    or s.year_of_issue = :int
                group by c.id, c.title, c.decoration, c.price
            ", //запрос на выборку
            'params' => [':string' => $string,
                ':int' => (int)$string],
            'pagination' => [ // постраничная разбивка
                'pageSize' => 10, // 10 на странице
            ],
            'sort' => [
                'attributes' => [
                    'id'
                ]
            ]
        ]);

        $arr = $dataProvider->getModels();
        $arr = $this->entityInit($arr);
        $dataProvider->setModels($arr);

        return $dataProvider;
    }

    public function searchAdvanced()
    {
        $director = new SearchDirector();
        $inquiry = $director->constructSearch($this->entityCar);

        $dataProvider = new SqlDataProvider([
            'sql' => $inquiry, //запрос на выборку
            'pagination' => [ // постраничная разбивка
                'pageSize' => 10, // 10 на странице
            ],
            'sort' => [
                'attributes' => [
                    'id'
                ]
            ]
        ]);

        $dataProvider->setTotalCount($dataProvider->getCount()); // Количество найденых элементов

        $arr = $dataProvider->getModels();
        $arr = $this->entityInit($arr);
        $dataProvider->setModels($arr);

        return $dataProvider;
    }

    public function imagePath()
    {
        return $this->db->createCommand("select photo from image where car_id = :id
        ", [':id' => $this->entityCar->getId()])->queryAll();

    }

    public function numberRecord()
    {
        return $this->db->createCommand('select count(*) from car ')->queryScalar();
    }

    private function entityInit(array $arr)
    {
        $result = [];

        foreach ($arr as $num) {
            $entity = new EntityCar($num);

            $this->fillingInit($entity, $num);

            $result[] = $entity;
        }

        return $result;
    }

    private function fillingInit(EntityCar $entity, array $arr)
    {
        $arr['specification'] = json_decode($arr['specification'], true);
        $arr['options'] = json_decode($arr['options'], true);
        $arr['photos'] = json_decode($arr['photos'], true);
        $arr['locality'] = json_decode($arr['locality'], true);
        $arr['region'] = json_decode($arr['region'], true);
        $arr['country'] = json_decode($arr['country'], true);
        $arr['user'] = json_decode($arr['user'], true);

        if (!empty($arr['specification'])) {
            $entity->setSpecification(new EntitySpecification($arr['specification']));
        }

        if (!empty($arr['options']))
        foreach ($arr['options'] as $elem) {
            if ($elem !== null)
                $arrOption[] = new EntityOption($elem);
        }

        if (!empty($arrOption))
            $entity->setOptions($arrOption);

        foreach ($arr['photos'] as $num) {
            $arrPhoto[] = new EntityPhoto($num);
        }
        if (!empty($arrPhoto))
            $entity->setPhotos($arrPhoto);

        if (!empty($arr['locality']))
            $entity->setLocality([
                'locality' => new EntityLocality($arr['locality']),
                'region' => new EntityRegion($arr['region']),
                'country' => new EntityCountry($arr['country'])
            ]);

        if (!empty($arr['user']))
            $entity->setUser(new EntityUser($arr['user']));
    }

    public function createUserCar(int $id)
    {
        $this->db->createCommand("insert into user_car (user_id, car_id) values (:user_id, :car_id)", [
            ':user_id' => $this->entityCar->getUser(),
            ':car_id' => $id
        ])->execute();
    }

    public function listCar()
    {
        $arr = $this->db->createCommand('select distinct * FROM car order by id')->queryAll();

        $result = [];
        foreach ($arr as $elem) {
            $result[] = new EntityCar($elem);
        }

        return $result;
    }
}
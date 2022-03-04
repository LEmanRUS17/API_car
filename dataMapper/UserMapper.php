<?php

namespace app\dataMapper;

use app\entities\EntityCar;
use app\entities\EntitySpecification;
use app\entities\EntityCountry;
use app\entities\EntityLocality;
use app\entities\EntityOption;
use app\entities\EntityPhoto;
use app\entities\EntityRegion;
use app\entities\EntityUser;
use app\interface\MapperInterface;
use Yii;
use yii\data\SqlDataProvider;

class UserMapper implements MapperInterface
{
    private $entity; // entity
    private $db;        // БД

    public function __construct(EntityUser $entity)
    {
        $this->entity = $entity; // Подключение entity
        $this->db = Yii::$app->db; // Подключение Базы данных
    }

    public function create()
    {
        $this->db->createCommand("insert into \"user\" (lastname, firstname, surname, telephone, mail) 
            values (:lastname, :firstname, :surname, :telephone, :mail)", [
            ':lastname' => $this->entity->getLastname(),
            ':firstname' => $this->entity->getFirstname(),
            ':surname' => $this->entity->getSurname(),
            ':telephone' => $this->entity->getTelephone(),
            ':mail' => $this->entity->getMail()
        ])->execute();
    }

    public function delete()
    {
        $this->db->createCommand("delete from \"user\" where id = :id", [':id' => $this->entity->getId()])->execute();
    }

    public function get()
    {
        $user = $this->db->createCommand("
			with cars as (
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
                group by c.id, c.title, c.decoration, c.price)
            select u.*,
            jsonb_agg(distinct c.*) as cars 
            from \"user\" u 
            	left join user_car uc on u.id = uc.user_id 
            	left join cars c on uc.car_id = c.id 
            where u.id = :id
            group by u.id
            ", [':id' => $this->entity->getId()])->queryOne();

        $this->entity->init($user);
        $this->filling($this->entity, $user);
    }

    public function update()
    {
        $this->db->createCommand("UPDATE \"user\"
            SET 
                lastname  = :lastname,
                firstname = :firstname,
                surname   = :surname,
                telephone = :telephone,
                mail      = :mail
            WHERE id = :id", [
            ':lastname'  => $this->entity->getLastname(),
            ':firstname' => $this->entity->getFirstname(),
            ':surname'   => $this->entity->getSurname(),
            ':telephone' => $this->entity->getTelephone(),
            ':mail'      => $this->entity->getMail(),
            ':id'        => $this->entity->getId()
        ])->execute();
    }

    public function list()
    {
        $dataProvider = new SqlDataProvider([
            'sql' => '
			with cars as (
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
                group by c.id, c.title, c.decoration, c.price)
            select u.*,
            jsonb_agg(distinct c.*) as cars 
            from "user" u 
            	left join user_car uc on u.id = uc.user_id 
            	left join cars c on uc.car_id = c.id 
            group by u.id
            ', //запрос на выборку
            'totalCount' => $this->countList(), // количество
            'pagination' => [ // постраничная разбивка
                'pageSize' => 10, // 10  на странице
            ],
            'sort' => [
                'attributes' => [
                    'id'
                ]
            ]
        ]);

        $arr = $dataProvider->getModels();
        $result = $this->arrFilling($arr);
        $dataProvider->setModels($result);

        return $dataProvider;
    }

    public function countList()
    {
        return $this->db->createCommand('SELECT COUNT(*) FROM "user"')->queryScalar();
    }

    private function arrFilling(array $arr)
    {
        $arrEntity = [];

        foreach ($arr as $num) {
            $entity = new EntityUser($num);
            $this->filling($entity, $num);
            $arrEntity[] = $entity;
        }

        return $arrEntity;
    }

    private function filling(EntityUser $entity, array $arr)
    {
        $arr['cars'] = json_decode($arr['cars'], true);

        if ($arr['cars'][0] != null) {
            foreach ($arr['cars'] as $num) {
                $entityCar = new EntityCar($num);
                if (!empty($num['specification'])) {
                    $entityCar->setSpecification(new EntitySpecification($num['specification']));
                }

                $arrOption = [];
                foreach ($num['options'] as $elem) {
                    if ($elem !== null)
                        $arrOption[] = new EntityOption($elem);
                }
                if (!empty($arrOption))
                    $entityCar->setOptions($arrOption);

                $arrPhoto = [];
                foreach ($num['photos'] as $elem) {
                    $arrPhoto[] = new EntityPhoto($elem);
                }
                if (!empty($arrPhoto))
                    $entityCar->setPhotos($arrPhoto);


                $entityCar->setLocality([
                    'locality' => new EntityLocality($num['locality']),
                    'region' => new EntityRegion($num['region']),
                    'country' => new EntityCountry($num['country'])
                ]);

                $entityCar->setUser(new EntityUser($num['user']));

                $cars[] = $entityCar;
            }

            $entity->setCars($cars);
        }
    }

    public function listUser()
    {
        $arr = $this->db->createCommand('select distinct id from "user" order by id')->queryAll();

        foreach ($arr as $num)
            $list[] = new EntityRegion($num);

        return $list;
    }

}
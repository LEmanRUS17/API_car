<?php

namespace app\builders;

use app\interface\InterfaceSearchBuilder;

class SearchBuilder implements InterfaceSearchBuilder
{
    private $result = [];

    public function setTitle(string $str)
    {
        $this->result[] = "c.title like '%$str%' ";
    }

    public function setDecoration(string $str)
    {
        $this->result[] = "c.decoration like '%$str%' ";
    }

    public function setPrice(int $min, int $max)
    {
        $this->result[] = "c.price between $min and $max ";
        return $this->result;
    }

    public function setBrand(string $str)
    {
        $this->result[] = "s.brand like '%$str%' ";
    }

    public function setModel(string $str)
    {
        $this->result[] = "s.model like '%$str%' ";
    }

    public function setYear(int $min, int $max)
    {
        $this->result[] = "s.year_of_issue between $min and $max ";
    }

    public function setBody(string $str)
    {
        $this->result[] = "s.body like '%$str%' ";
    }

    public function setLocality(int $id)
    {
        $this->result[] = "l.id = $id ";
    }
    public function setRegion(int $id)
    {
        $this->result[] = "r.id = $id ";
    }
    public function setCountry(int $id)
    {
        $this->result[] = "c2.id = $id ";
    }

    public function setMileage(int $min, int $max)
    {
        $this->result[] = "s.mileage between $min and $max ";
    }

    public function setOption(int $num)
    {
        $this->result[] = "co.option_id = $num";
    }

    public function getResult()
    {
        $inquiry = '
                select c.*, 
                jsonb_array_elements(jsonb_agg(distinct s.*)) as specification,
                (select jsonb_agg(distinct o2.*) from option o2 join car_option co2 on co2.option_id =o2.id where co2.car_id=c.id) as options,
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
                ';

        $a = array_key_last($this->result);

        if(!empty($this->result))
            $inquiry .= ' where ';
        foreach ($this->result as $key => $num)
        {
            $inquiry .= $num;
            if($key != $a)
                $inquiry .= 'and ';
        }

        $inquiry .= ' group by c.id, c.title, c.decoration, c.price ';
        return $inquiry;
    }
}
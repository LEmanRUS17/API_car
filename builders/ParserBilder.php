<?php

namespace app\builders;

use app\interface\ParserInterfase;

class ParserBilder implements ParserInterfase
{
    private $document;
    private $car = [];

    public function __construct($data)
    {
        $this->document = \phpQuery::newDocumentHTML($data);
    }

    public function setCarTitle()
    {
        preg_match('/Продажа\s.*,/', $this->document->find('.css-987tv1')->text(), $found);
        $this->car['title'] = 'не указан';
        if (!empty($found)) {
            $title = preg_replace('/Продажа\s/', '', $found[0]);
            $title = preg_replace('/,/', '', $title);
            $this->car['title'] = $title;
        }
    }

    public function setCarDecoration()
    {
        preg_match('/Дополнительно:.*/s', $this->document->find('.css-zuhr9c')->text(), $found);
        $this->car['decoration'] = 'не указан';
        if (!empty($found)) {
            $decoration = preg_replace('/Дополнительно:/', '', $found[0]);
            $decoration = preg_replace('/Город:\s.*/s', '', $decoration);
            $decoration = preg_replace('/Обмен:\s.*/s', '', $decoration);
            $this->car['decoration'] = $decoration;
        }
    }

    public function setCarPrice()
    {
        $this->car['price'] = (int)str_replace(" ", '', $this->document->find('.css-10qq2x7')->text());
    }

    public function setCarLocality()
    {
        preg_match('/Город:\s.*/', $this->document->find('.css-zuhr9c')->text(), $found);
        $this->car['locality'] = 'не указан';
        if (!empty($found)) {
            $locality = preg_replace('/Город:\s/', '', $found[0]);
            $locality = preg_replace('/,.*/', '', $locality);
            $this->car['locality'] = $locality;
        }
    }

    public function setCarBrand()
    {
        $description = explode("\n", $this->document->find('.css-1ohqla')->text());
        $this->car['specification']['brand'] = $description[2];
    }

    public function setCarModel()
    {
        $description = explode("\n", $this->document->find('.css-1ohqla')->text());
        $this->car['specification']['model'] = $description[3];
    }

    public function setCarBody()
    {
        preg_match('/Тип\sкузова.*/', $this->document->find('tr.css-11ylakv')->text(), $found);
        $this->car['specification']['body'] = 'не указан';
        if (!empty($found)) {
            $body = preg_replace('/Тип\sкузова/', '', $found[0]);
            $this->car['specification']['body'] = str_replace(" ", '', $body);
        }
    }

    public function setCarMileage()
    {
        preg_match('/Пробег,\sкм\d*.*\d*/', $this->document->find('tr.css-11ylakv')->text(), $found);
        $this->car['specification']['mileage'] = 'не указан';
        if (!empty($found)) {
            $mileage = preg_replace('/Пробег,\sкм/', '', $found[0]);
            $this->car['specification']['mileage'] = (int)str_replace(" ", '', $mileage);
        }
    }

    public function setCarYear()
    {
        preg_match('/\d\d\d\d\sгод/', $this->document->find('.css-987tv1')->text(), $found);
        if (!empty($found)) {
            $yearOfIssue = preg_replace('/\sгод/', '', $found[0]);
            $this->car['specification']['year_of_issue'] = $yearOfIssue;
        }
    }

    public function setCarPhoto()
    {
        preg_match_all('/<img.*?src=["\'](.*?)["\'].*?>/i', $this->document, $images, PREG_SET_ORDER);

        foreach ($images as $num) {
            if (str_starts_with($num[1], 'https://s.auto.drom.ru/photo/'))
                $this->car['photos'][] = $num[1];
        }
    }

    public function getCar()
    {
        return $this->car;
    }
}
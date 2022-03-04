<?php

namespace app\services;

use app\director\ParserDirector;
use app\entities\EntityCar;
use app\entities\EntityLocality;
use app\entities\EntityOption;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ParsingService
{
    private $locality;
    private $service;
    private $client;

    public function __construct()
    {
        $this->locality = new LocalityService(new EntityLocality());
        $this->service = new CarService(new EntityCar([]), new EntityOption());
        // подключаем Guzzle
        $this->client = new Client(['timeout' => 10,'base_uri' => '203.30.188.245:80']);
    }

    public function carsDromRu(int $start, int $num)
    {
        for ($i = $start; $i > $start - $num;) {
            $data = $this->carDromRu($i);
            if ($data != false) {
                $i--;
                $arr[] = $data;
            }
        }
        return $arr;
    }

    public function carDromRu(int $id)
    {
        try {
            // передаем параметры в запрос яндекса
            $res = $this->client->request('GET', 'https://kurgan.drom.ru/toyota/land_cruiser/' . $id . '.html');
            // получаем страницу
            $data = $res->getBody();
        } catch (ClientException $e) {}

        if (!empty($data)) {
            $builder = new ParserDirector($data);
            return $builder->getCarDromRu();
        }

        return false;
    }

    public function parserCity()
    {
        // передаем параметры в запрос яндекса
        $res = $this->client->request('GET', 'https://ru.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%BE%D0%B2_%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D0%B8');
        // получаем страницу
        $data = $res->getBody();
        // подключаем phpQuery для обработки страницы
        $document = \phpQuery::newDocumentHTML($data);

        $cities = $document->find('.standard > tbody > tr > td')->texts();

        $arr = array_chunk($cities, 9);

        return $arr;
    }

    public function createCar(array $car)
    {
        if (!empty($car)) {
            $car = $this->locationAward($car);
            $car['user'] = 1;

            if (!empty($car['photos']))
                $car['photos'] = $this->loadImage($car['photos']);
            $this->service->createPars($car);
        }
    }

    public function loadImage(array $arr)
    {
        if (!empty($arr))
            foreach ($arr as $key => $num) {
                $path = dirname(dirname(__FILE__)) . '/web/image/';
                $img = time() . $key . '_' . rand() . '.jpg';
                file_put_contents($path . $img, file_get_contents($num));
                $arr[$key] = '/image/' . $img;
            }

        return $arr;
    }

    public function locationAward(array $car)
    {
        $localities = $this->locality->list();

        foreach ($localities as $num) {
            if ($num['title'] == $car['locality'])
                $car['locality'] = $num['id'];
        }

        return $car;
    }
}
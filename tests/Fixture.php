<?php

namespace app\tests;

use Yii;

class Fixture
{
    private $db;

    public function testFix()
    {
        $files = \yii\helpers\FileHelper::findFiles(__DIR__ . '/fixtures/data');
        $this->db = Yii::$app->db; // Подключение Базы данных

        foreach ($files as $num)
        {
            $key = basename($num, '.php');

            $arr[$key] = require($num);
        }


        foreach ($arr as $tableName => $table) {

            foreach ($table as $elem) {
                $count = count($elem);
                $i = 1;$column = $value = '';
                foreach ($elem as $key => $num) {
                    if(!empty($num)) {
                    $column .=  $key ;
                    if ($i != $count) $column .= ', ';
                    $value .= '\'' .$num. '\'';
                    if ($i != $count) $value .= ', ';}
                    $i++;
                }

                    $str[] = "INSERT INTO $tableName ($column) VALUES ($value)";
            }
        }
//var_dump($str);die;
        $transaction = $this->db->beginTransaction();
        try {
            foreach ($str as $num) {
                $this->db->createCommand($num)->execute();
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }


    }


}
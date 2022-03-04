<?php

namespace app\validators;

use Yii;

abstract class Validator
{
    private $error = [];

    abstract function validate();

    public function addError($message) {

        $this->error[] = $message;
    }

    public function getErrors()
    {
        if (empty($this->error))
            return true;

        Yii::$app->response->statusCode = 421;

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = [
            'name' => 'Ошибка валидации',
            'message' => $this->error,
            'code' => 0,
            'status' => 421
        ];

       $response->send();
    }
}
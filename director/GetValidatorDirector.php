<?php

namespace app\director;

use app\builders\ValidatorBuilder;
use app\entities\EntityCar;
use app\validators\Validator;

class GetValidatorDirector extends Validator
{
    private $builder;
    private $entity;

    public function __construct(EntityCar $entity)
    {
        $this->entity = $entity;
        $this->builder = new ValidatorBuilder();
    }

    public function validate()
    {
        $this->builder->validateId($this->entity->getId());

        foreach ($this->builder->getErrors() as $error)
        {
            $this->addError($error);
        }

        return $this->getErrors();
    }
}
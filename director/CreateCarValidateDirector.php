<?php

namespace app\director;

use app\builders\ValidatorBuilder;
use app\entities\EntityCar;
use app\validators\Validator;

class CreateCarValidateDirector extends Validator
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
        $this->builder->validateTitle($this->entity->getTitle());
        $this->builder->validateDecoration($this->entity->getDecoration());
        $this->builder->validatePrice($this->entity->getPrice());
        $this->builder->validateLocality($this->entity->getLocality());
        $this->builder->validateUser($this->entity->getUser());

        if (!empty($this->entity->getSpecification())) {
            $specification = $this->entity->getSpecification();
            $this->builder->validateBrand($specification->getBrand());
            $this->builder->validateModel($specification->getModel());
            $this->builder->validateYearOfIssue($specification->getYearOfIssue());
            $this->builder->validateBody($specification->getBody());
            $this->builder->validateMileage($specification->getMileage());
        }

        if (!empty($this->entity->getOptions()))
            foreach ($this->entity->getOptions() as $key => $option)
                $this->builder->validateOptions($option->getId(), $key);

        foreach ($this->builder->getErrors() as $error)
            $this->addError($error);

        return $this->getErrors();
    }
}
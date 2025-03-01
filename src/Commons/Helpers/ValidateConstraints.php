<?php

namespace App\Commons\Helpers;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidateConstraints
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function validate(object $constraints): array
    {
        $result = [];
        $errors = $this->validator->validate($constraints);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $result[$error->getPropertyPath()][] = $error->getMessage();
            }
        }

        return $result;
    }
}

<?php

namespace App\Helper;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

readonly class ValidatorHelper
{
    public function __construct(
        private ValidatorInterface $validator
    ) {
    }

    /**
     * @param object $object
     * @return bool
     */
    public function validate(object $object): bool
    {
        $errors = $this->validator->validate($object);
        Assert::count($errors, '0', $errors);
        return true;
    }
}

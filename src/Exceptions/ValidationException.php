<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ValidationException
 * @package App\Exceptions
 */
class ValidationException extends HttpException
{
    /**
     * @var ConstraintViolationListInterface
     */
    private ConstraintViolationListInterface $list;

    /**
     * ValidationException constructor.
     * @param ConstraintViolationListInterface $list
     */
    public function __construct(ConstraintViolationListInterface $list)
    {
        parent::__construct(422, "The given data was invalid.");

        $this->list = $list;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $errorMessages = [];

        foreach ($this->list as $violation) {
            $accessor->setValue($errorMessages,
                $violation->getPropertyPath(),
                $violation->getMessage());
        }

        return $errorMessages;
    }
}

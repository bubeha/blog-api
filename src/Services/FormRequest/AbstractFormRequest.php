<?php

declare(strict_types=1);

namespace App\Services\FormRequest;

use App\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractFormRequest
 * @package App\Services\FormRequest
 */
abstract class AbstractFormRequest
{
    /** @var ValidatorInterface */
    private ValidatorInterface $validator;

    /** @var Request|null */
    private ?Request $request;

    /**
     * AbstractFormRequest constructor.
     * @param RequestStack $requestStack
     * @param ValidatorInterface $validator
     */
    public function __construct(RequestStack $requestStack, ValidatorInterface $validator)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->validator = $validator;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        if (! $this->request) {
            throw new BadRequestHttpException('Missing request');
        }

        $data = $this->request->request->all();
        $rules = new Collection($this->rules());
        $list = $this->validator->validate($data, $rules);

        if ($list->count() > 0) {
            throw new ValidationException($list);
        }

        return true;
    }

    /**
     * @return array
     */
    abstract protected function rules(): array;
}

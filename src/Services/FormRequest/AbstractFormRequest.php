<?php

declare(strict_types=1);

namespace App\Services\FormRequest;

/**
 * Class AbstractFormRequest
 * @package App\Services\FormRequest
 */
abstract class AbstractFormRequest
{
    /**
     * @return array
     */
    abstract public function rules(): array;
}

<?php

declare(strict_types=1);

namespace App\Requests\Articles;

use App\Services\FormRequest\AbstractFormRequest;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class CreateRequest
 * @package App\Requests\Articles
 */
class CreateRequest extends AbstractFormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [new Length(['min' => 2]), new NotBlank(), new Type("string")],
            'email' => [new Email(), new NotBlank()],
        ];
    }
}

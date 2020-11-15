<?php

declare(strict_types=1);

namespace App\Services\FormRequest;

use App\Exceptions\ValidationException;
use Psr\Cache\InvalidArgumentException;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Class FormRequestBinder
 * @package App\Services\FormRequest
 */
class FormRequestBinder
{
    /** @var ValidatorInterface */
    private ValidatorInterface $validator;

    /** @var CacheInterface */
    private CacheInterface $cache;

    /**
     * FormRequestBinder constructor.
     * @param CacheInterface $cache
     * @param ValidatorInterface $validator
     */
    public function __construct(CacheInterface $cache, ValidatorInterface $validator)
    {
        $this->validator = $validator;
        $this->cache = $cache;
    }

    /**
     * @param Request $request
     * @param $actions
     * @throws InvalidArgumentException
     */
    public function bind(Request $request, callable $actions): void
    {
        $formRequest = $this->matchActionArguments($actions);

        if (! $formRequest) {
            return;
        }

        $rules = $formRequest->rules();

        $list = $this->validator->validate($request->request->all(), new Collection($rules));

        if ($list->count() > 0) {
            throw new ValidationException($list);
        }
    }

    /**
     * @param callable $action
     * @return AbstractFormRequest|null
     * @throws InvalidArgumentException
     */
    private function matchActionArguments(callable $action): ?AbstractFormRequest
    {
        $class = get_class($action[0]);
        $key = str_replace('\\', '_', $class) . '_' . $action[1];

        return $this->cache->get($key, static function () use ($action) {
            $classReflection = new ReflectionClass($action[0]);
            $actionReflection = $classReflection->getMethod($action[1]);

            foreach ($actionReflection->getParameters() as $parameter) {
                $class = $parameter->getClass();

                if (is_a($class->name, AbstractFormRequest::class, true)) {
                    return new $class->name();
                }
            }

            return null;
        });
    }
}

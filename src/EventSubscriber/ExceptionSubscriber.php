<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class JsonExceptionSubscriber
 * @package App\EventSubscriber
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    private const CONTENT_TYPE = 'json';

    private string $environment;

    /**
     * ExceptionSubscriber constructor.
     *
     * @param string $environment
     */
    public function __construct($environment)
    {
        $this->environment = $environment;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                'handle',
                10,
            ],
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function handle(ExceptionEvent $event): void
    {
        $request = $event->getRequest();

        if (! $this->isAvailable($request)) {
            return;
        }

        $throwable = $event->getThrowable();
        $response = $this->getResponse($throwable);

        $event->setResponse($response);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function isAvailable(Request $request): bool
    {
        return static::CONTENT_TYPE === $request->getContentType() && $request->getContent();
    }

    /**
     * @param \Throwable $throwable
     * @return JsonResponse
     */
    private function getResponse(\Throwable $throwable): JsonResponse
    {
        $statusCode = $throwable instanceof HttpExceptionInterface ? $throwable->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        return new JsonResponse($this->getResponseData($throwable), $statusCode);
    }

    /**
     * @param \Throwable $throwable
     *
     * @return (array|int|string)[]
     *
     * @psalm-return array{message: string, code?: int|string, exception?: string, file?: string, line?: int, trace?: array}
     */
    private function getResponseData(\Throwable $throwable): array
    {
        $data = [
            'message' => $throwable->getMessage(),
        ];

        if ('prod' === $this->environment) {
            return $data;
        }

        return array_merge($data, [
            'code' => $throwable->getCode(),
            'exception' => get_class($throwable),
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
            'trace' => $throwable->getTrace(),
        ]);
    }
}

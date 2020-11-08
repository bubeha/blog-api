<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class RequestSubscriber
 * @package App\EventSubscriber
 */
class RequestSubscriber implements EventSubscriberInterface
{
    private const CONTENT_TYPE = 'json';

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                'handle',
                10,
            ],
        ];
    }

    /**
     * @param RequestEvent $event
     */
    public function handle(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (! $this->isAvailable($request)) {
            return;
        }

        $this->transform($request);
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
     * @param Request $request
     * @return void
     */
    private function transform(Request $request): void
    {
        try {
            $parameters = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

            if (! is_array($parameters)) {
                return;
            }

            $request->request->replace($parameters);

        } catch (\JsonException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

}

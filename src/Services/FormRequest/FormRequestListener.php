<?php

declare(strict_types=1);

namespace App\Services\FormRequest;

use Symfony\Component\HttpKernel\Event\ControllerEvent;

/**
 * Class FormRequestListener
 * @package App\Services\FormRequest
 */
class FormRequestListener
{
    /** @var FormRequestBinder */
    private FormRequestBinder $binder;

    /**
     * FormRequestListener constructor.
     * @param FormRequestBinder $binder
     */
    public function __construct(FormRequestBinder $binder)
    {
        $this->binder = $binder;
    }

    /**
     * @param ControllerEvent $event
     */
    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();
        $controller = $event->getController();

        $this->binder->bind($request, $controller);

//        dd($controller);
//
//        $errorResponse = $this->requestBinder->bind($request, $controller);
//
//        if (null === $errorResponse) {
//            return;
//        }

//        $event->setController(function () {
//            return [];
//        });
    }
}

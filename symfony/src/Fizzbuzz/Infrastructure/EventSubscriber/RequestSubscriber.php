<?php

namespace App\Fizzbuzz\Infrastructure\EventSubscriber;

use App\Fizzbuzz\Application\Query\UpsertRequestInterface;
use App\Fizzbuzz\Domain\Entity\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Controller\ErrorController;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private UpsertRequestInterface $upsert) {
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        // Do not record if the request is an error.
        if (!$controller instanceof ErrorController) {
            $path = $event->getRequest()->getPathInfo();
            $method = $event->getRequest()->getMethod();
            $queries = $event->getRequest()->query->all();
            $request = new Request($path, $method, $queries);
            $this->upsert->execute($request);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
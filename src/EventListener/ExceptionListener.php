<?php
/**
 * @author: Robin
 * @date: 13.05.2020
 * @version: 0.1
 */

declare(strict_types=1);

namespace App\EventListener;


use App\Factory\ResponseFactory;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{

    public function onKernelException(ExceptionEvent $event): void
    {
        $event->setResponse(ResponseFactory::createServerErrorResponse(
            'Es ist ein fataler API Fehler aufgetreten.',
            [
                'error' => str_replace(["\n", "\r"], '', $event->getThrowable()->getMessage())
            ]
        ));
    }

}
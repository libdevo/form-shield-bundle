<?php

declare(strict_types=1);

namespace Libdevo\FormShieldBundle\EventListener;

use LibertJeremy\Symfony\Helpers\Traits\TwigAwareTrait;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class StyleResponseInjectorEventListener
{
    use TwigAwareTrait;

    #[AsEventListener(event: KernelEvents::RESPONSE)]
    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->isXmlHttpRequest()) {
            return;
        }

        $response = $event->getResponse();

        if (!$this->isValidResponse($response)) {
            return;
        }

        $this->injectScript($response);
    }

    protected function injectScript(Response $response): void
    {
        $content = $response->getContent();

        if (false === ($pos = strripos($content, '</head>'))) {
            return;
        }

        $styles = "\n".str_replace("\n", '', $this->twig->render('@FormShield/styles/_styles.html.twig'))."\n";
        $content = substr($content, 0, $pos).$styles.substr($content, $pos);
        $response->setContent($content);
    }

    protected function isValidResponse(Response $response): bool
    {
        return !(
            $response instanceof BinaryFileResponse
            || $response instanceof RedirectResponse
            || $response instanceof JsonResponse
            || $response instanceof StreamedResponse
        );
    }
}

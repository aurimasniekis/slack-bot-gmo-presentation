<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SlackRequestValidatorSubscriber implements EventSubscriberInterface
{
    private string $slackSigningSecret;

    /**
     * @param string $slackSigningSecret
     */
    public function __construct(string $slackSigningSecret)
    {
        $this->slackSigningSecret = $slackSigningSecret;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $baseURL = $request->getRequestUri();

        if (false === str_starts_with($baseURL, '/slack')) {
            return;
        }

        $requestTimestamp = $request->headers->get('x-slack-request-timestamp');
        $signature        = $request->headers->get('x-slack-signature');
        $body             = $request->getContent();

        if ((time() - $requestTimestamp) > 60 * 5) {
            throw new BadRequestHttpException();
        }

        $dataForSignature = 'v0:' . $requestTimestamp . ':' . $body;
        $calculatedSignature = 'v0=' . hash_hmac('sha256', $dataForSignature, $this->slackSigningSecret, false);

        if (false === hash_equals($signature, $calculatedSignature)) {
            throw new BadRequestHttpException();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}

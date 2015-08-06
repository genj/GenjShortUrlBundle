<?php

namespace Genj\ShortUrlBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Genj\ShortUrlBundle\Entity\ShortUrlRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class KernelListener
 *
 * @package GenjShortUrlBundle\EventListener
 */
class KernelListener
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var ShortUrlRepository
     */
    protected $shortUrlRepository;

    /**
     * @param Request            $request
     * @param EntityManager      $entityManager
     * @param ShortUrlRepository $shortUrlRepository
     */
    public function __construct(Request $request, EntityManager $entityManager, ShortUrlRepository $shortUrlRepository)
    {
        $this->request            = $request;
        $this->entityManager      = $entityManager;
        $this->shortUrlRepository = $shortUrlRepository;
    }

    /**
     * Capture normal requests.
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->handleShortUrl($event);
    }

    /**
     * If Symfony needs to render an error page, that is an internal subrequest, so we are no longer in the master
     * request by the time we get to onKernelRequest. So we need to do the same thing for exception requests.
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $this->handleShortUrl($event);
    }

    /**
     * @param GetResponseEvent $event
     */
    protected function handleShortUrl(GetResponseEvent $event)
    {
        // Only do something if we are on the master request
        if ($event->isMasterRequest()) {
            return;
        }

        $source   = $this->request->getPathInfo();
        $shortUrl = $this->shortUrlRepository->retrievePublicBySource($source);

        // If there is no public shortUrl object, there is nothing to do
        if (!$shortUrl) {
            return;
        }

        // Append query string if it existed
        $queryString    = $this->request->getQueryString();
        $httpStatusCode = $shortUrl->getHttpStatusCode();
        $target         = $shortUrl->getTarget();

        if ($queryString) {
            $existingQueryString = parse_url($target, PHP_URL_QUERY);

            if ($existingQueryString) {
                $target .= '&' . $queryString;
            } else {
                $target .= '?' . $queryString;
            }
        }

        // Set redirect response
        $response = new RedirectResponse($target, $httpStatusCode);
        $event->setResponse($response);

        // Increment hitCount
        $hitCount = $shortUrl->getHitCount();
        $shortUrl->setHitCount($hitCount + 1);

        $this->entityManager->persist($shortUrl);
        $this->entityManager->flush();
    }
}

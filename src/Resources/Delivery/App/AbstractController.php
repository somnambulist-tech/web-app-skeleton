<?php declare(strict_types=1);

namespace App\Resources\Delivery\App;

use IlluminateAgnostic\Str\Support\Str;
use Somnambulist\Components\Commands\CommandBus;
use Somnambulist\Components\Jobs\JobQueue;
use Somnambulist\Components\Queries\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use function array_merge;

abstract class AbstractController extends BaseController
{
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            CommandBus::class,
            JobQueue::class,
            QueryBus::class,
        ]);
    }

    protected function redirectToReferer(Request $request, string $route, array $params = []): RedirectResponse
    {
        $referer = $request->headers->get('referer');

        if ($referer && Str::contains($referer, 'example.dev')) {
            return $this->redirect($referer);
        }

        return $this->redirectToRoute($route, $params);
    }

    protected function query(): QueryBus
    {
        return $this->container->get(QueryBus::class);
    }

    protected function job(): JobQueue
    {
        return $this->container->get(JobQueue::class);
    }

    protected function command(): CommandBus
    {
        return $this->container->get(CommandBus::class);
    }
}

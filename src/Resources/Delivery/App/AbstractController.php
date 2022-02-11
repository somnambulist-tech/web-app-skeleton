<?php declare(strict_types=1);

namespace App\Resources\Delivery\App;

use IlluminateAgnostic\Str\Support\Str;
use RuntimeException;
use Somnambulist\Bundles\ApiBundle\Request\RequestArgumentHelper;
use Somnambulist\Components\Domain\Commands\CommandBus;
use Somnambulist\Components\Domain\Jobs\JobQueue;
use Somnambulist\Components\Domain\Queries\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use function array_merge;
use function in_array;
use function sprintf;

/**
 * Class AbstractController
 *
 * @package    App\Resources\Delivery\App
 * @subpackage App\Resources\Delivery\App\AbstractController
 *
 * @method array orderBy(Request $request, string $default = null)
 * @method int page(Request $request, int $default = 1)
 * @method int perPage(Request $request, int $default = null, int $max = null)
 * @method int limit(Request $request, int $default = null, int $max = null)
 * @method int offset(Request $request, int $limit = null)
 * @method mixed nullOrValue(ParameterBag $request, array $fields, string $class = null)
 */
abstract class AbstractController extends BaseController
{
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            RequestArgumentHelper::class,
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

    protected function requestArgumentHelper(): RequestArgumentHelper
    {
        return $this->container->get(RequestArgumentHelper::class);
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

    public function __call($name, $arguments)
    {
        if (in_array($name, ['orderBy', 'page', 'perPage', 'limit', 'offset', 'nullOrValue'])) {
            return $this->requestArgumentHelper()->{$name}(...$arguments);
        }

        throw new RuntimeException(sprintf('Method "%s" not found on "%s"', $name, static::class));
    }
}

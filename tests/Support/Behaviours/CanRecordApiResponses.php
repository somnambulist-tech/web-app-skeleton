<?php declare(strict_types=1);

namespace App\Tests\Support\Behaviours;

use Somnambulist\Components\ApiClient\Client\RequestTracker;
use Somnambulist\Components\ApiClient\Client\ResponseStore;
use function dirname;
use function str_replace;

/**
 * Recording API Responses
 *
 * If using the somnambulist/api-client and Symfony HTTPClient for making Api requests,
 * add this trait and setup a decorator around the ApiClient service, and then API calls
 * can be recorded to files for later playback in tests.
 *
 * Be sure to wrap the HTTP Client instance in the recordable client decorator. See:
 * https://github.com/somnambulist-tech/api-client/blob/master/docs/recording.md
 */
trait CanRecordApiResponses
{
    protected function setUpTests(): void
    {
        $this->setRecordingStore();
    }

    protected function setRecordingStore(): void
    {
        $test  = str_replace(['App\\Tests\\', 'Test', '\\'], ['', '', '/'], __CLASS__);
        $store = sprintf('%s/tests/recordings/%s/%s', dirname(__DIR__, 3), $test, $this->getName());

        ResponseStore::instance()->setStore($store);
        RequestTracker::instance()->reset();
    }
}

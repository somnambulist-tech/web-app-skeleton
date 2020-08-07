<?php declare(strict_types=1);

namespace App\Tests\Support\Behaviours;

use ReflectionObject;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use function method_exists;

/**
 * Trait BootTestClient
 *
 * @package App\Tests\Support\Behaviours
 * @subpackage App\Tests\Support\Behaviours\BootTestClient
 *
 * @method void setKernelClass()
 * @method void setUpTests()
 */
trait BootTestClient
{

    /**
     * @var AbstractBrowser
     */
    protected $__kernelBrowserClient;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $ref = new ReflectionObject($this);
        if ($ref->getParentClass()->getName() !== WebTestCase::class) {
            throw new RuntimeException('BootTestClient trait should only be used with WebTestCase class');
        }

        if (method_exists($this, 'setKernelClass')) {
            self::setKernelClass();
        }

        $this->__kernelBrowserClient = self::createClient();

        if (method_exists($this, 'setUpTests')) {
            $this->setUpTests();
        }
    }

    protected function getBrowserClient(): ?AbstractBrowser
    {
        return $this->__kernelBrowserClient;
    }
}

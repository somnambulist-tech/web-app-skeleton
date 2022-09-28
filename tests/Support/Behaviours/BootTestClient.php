<?php declare(strict_types=1);

namespace App\Tests\Support\Behaviours;

use Symfony\Component\BrowserKit\AbstractBrowser;

/**
 * @method void setKernelClass()
 * @method void setUpTests()
 */
trait BootTestClient
{
    protected ?AbstractBrowser $__kernelBrowserClient = null;

    protected function setUp(): void
    {
        if (method_exists($this, 'setKernelClass')) {
            self::setKernelClass();
        }

        $this->__kernelBrowserClient = self::createClient();

        if (method_exists($this, 'setUpTests')) {
            $this->setUpTests();
        }
    }
}

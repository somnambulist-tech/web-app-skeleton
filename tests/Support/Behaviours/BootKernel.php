<?php declare(strict_types=1);

namespace App\Tests\Support\Behaviours;

use ReflectionObject;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use function method_exists;

/**
 * Trait BootKernel
 *
 * @package App\Tests\Support\Behaviours
 * @subpackage App\Tests\Support\Behaviours\BootKernel
 *
 * @method void setKernelClass()
 * @method void setUpTests()
 */
trait BootKernel
{

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $ref = new ReflectionObject($this);
        if ($ref->getParentClass()->getName() !== KernelTestCase::class) {
            throw new RuntimeException('BootKernel trait should only be used with KernelTestCase class');
        }

        if (method_exists($this, 'setKernelClass')) {
            self::setKernelClass();
        }

        self::bootKernel();

        if (method_exists($this, 'setUpTests')) {
            $this->setUpTests();
        }
    }
}

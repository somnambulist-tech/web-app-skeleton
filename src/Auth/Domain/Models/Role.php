<?php declare(strict_types=1);

namespace App\Auth\Domain\Models;

use Somnambulist\Components\Domain\Entities\AbstractEnumeration;

/**
 * Class Constants
 *
 * @package    App\Auth\Domain\Models
 * @subpackage App\Auth\Domain\Models\Constants
 */
final class Role extends AbstractEnumeration
{
    const USER            = 'user';
    const CAN_SWITCH_USER = 'switch_user';
}

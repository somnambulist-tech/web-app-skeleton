<?php declare(strict_types=1);

namespace App\Auth\Domain\Models;

use Somnambulist\Components\Models\AbstractEnumeration;

final class Role extends AbstractEnumeration
{
    const USER            = 'user';
    const CAN_SWITCH_USER = 'switch_user';
}

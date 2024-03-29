<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Services;

use App\Auth\Domain\Models\SecurityUser;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof SecurityUser) {
            return;
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof SecurityUser) {
            return;
        }
    }
}

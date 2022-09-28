<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Services;

use App\Auth\Domain\Models\SecurityUser;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SecurityUserProvider implements UserProviderInterface
{
    /**
     * Some locator that can look up Users by username
     */
    private object $users;

    public function loadUserByIdentifier(string $username): UserInterface
    {
        if (null === $user = $this->users->findOneBy(['email' => $username])) {
            throw new BadCredentialsException();
        }
        
        return SecurityUser::create($user);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof SecurityUser) {
            throw new UnsupportedUserException(sprintf('"%s" is not a supported User type', get_class($user)));
        }

        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return SecurityUser::class === $class;
    }
}

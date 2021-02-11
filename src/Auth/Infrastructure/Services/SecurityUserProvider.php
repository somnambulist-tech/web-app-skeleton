<?php declare(strict_types=1);

namespace App\Auth\Infrastructure\Services;

use App\Auth\Domain\Models\SecurityUser;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class SecurityUserProvider
 *
 * @package    App\Auth\Infrastructure\Services
 * @subpackage App\Auth\Infrastructure\Services\SecurityUserProvider
 */
class SecurityUserProvider implements UserProviderInterface
{

    /**
     * Some locator that can look up Users by username
     *
     * @var object
     */
    private object $users;

    /**
     * @param string $username
     *
     * @return UserInterface
     */
    public function loadUserByUsername(string $username)
    {
        if (null === $user = $this->users->findOneBy(['email' => $username])) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist', $username));
        }
        
        return SecurityUser::create($user);
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof SecurityUser) {
            throw new UnsupportedUserException(sprintf('"%s" is not a supported User type', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass(string $class)
    {
        return SecurityUser::class === $class;
    }
}

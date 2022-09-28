<?php declare(strict_types=1);

namespace App\Auth\Domain\Models;

use ReflectionClass;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Wraps a User object to keep the Symfony interfaces out of the User object.
 * Expose other methods by wrapping them and passing through.
 */
class SecurityUser implements UserInterface, EquatableInterface
{
    private object $user;

    private function __construct(object $user)
    {
        $this->user = $user;
    }

    public static function create(object $user): SecurityUser
    {
        return new static($user);
    }

    public static function nullUser(): SecurityUser
    {
        $ref = new ReflectionClass(self::class);

        return $ref->newInstanceWithoutConstructor();
    }

    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof SecurityUser) {
            return false;
        }

        if ((string)$this->getPassword() !== (string)$user->getPassword()) {
            return false;
        }

        if ((string)$this->getUserIdentifier() !== (string)$user->getUserIdentifier()) {
            return false;
        }

        return true;
    }

    public function getPassword(): string
    {
        return $this->user->password();
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->user->email();
    }

    public function getUsername(): string
    {
        return (string)$this->user->email();
    }

    public function getRoles(): array
    {
        return [Role::USER];
    }

    public function eraseCredentials()
    {

    }
}

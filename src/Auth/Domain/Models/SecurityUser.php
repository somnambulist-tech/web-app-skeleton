<?php declare(strict_types=1);

namespace App\Auth\Domain\Models;

use ReflectionClass;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class SecurityUser
 *
 * Wraps a User object to keep the Symfony interfaces out of the User object.
 * Expose other methods by wrapping them and passing through.
 *
 * @package    App\Auth\Domain\Models
 * @subpackage App\Auth\Domain\Models\SecurityUser
 */
class SecurityUser implements UserInterface, EquatableInterface
{

    /**
     * @var object
     */
    private $user;

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

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof SecurityUser) {
            return false;
        }

        if ((string)$this->getPassword() !== (string)$user->getPassword()) {
            return false;
        }

        if ((string)$this->getUsername() !== (string)$user->getUsername()) {
            return false;
        }

        return true;
    }

    public function getPassword()
    {
        return $this->user->password();
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return (string)$this->user->email();
    }

    public function getRoles()
    {
        return [Role::USER];
    }

    public function eraseCredentials()
    {

    }
}

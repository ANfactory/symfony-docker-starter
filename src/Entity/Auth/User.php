<?php

namespace App\Entity\Auth;

use Doctrine\ORM\Mapping as ORM;
use MsgPhp\Domain\Event\DomainEventHandlerInterface;
use MsgPhp\Domain\Event\DomainEventHandlerTrait;
use MsgPhp\User\Entity\Credential\EmailPassword;
use MsgPhp\User\Entity\Features\EmailPasswordCredential;
use MsgPhp\User\Entity\Features\ResettablePassword;
use MsgPhp\User\Entity\Fields\RolesField;
use MsgPhp\User\Entity\User as BaseUser;
use MsgPhp\User\UserIdInterface;

/**
 * @ORM\Entity()
 */
class User extends BaseUser implements DomainEventHandlerInterface
{
    use DomainEventHandlerTrait;
    use EmailPasswordCredential;
    use ResettablePassword;
    use RolesField;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="msgphp_user_id", length=191)
     */
    private $id;

    public function __construct(UserIdInterface $id, string $email, string $password)
    {
        $this->id = $id;
        $this->credential = new EmailPassword($email, $password);
    }

    public function getId(): UserIdInterface
    {
        return $this->id;
    }
}

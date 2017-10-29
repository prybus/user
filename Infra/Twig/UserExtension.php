<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Twig;

use MsgPhp\User\Infra\Security\SecurityUserFactory;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UserExtension extends AbstractExtension
{
    private $securityUserFactory;

    public function __construct(SecurityUserFactory $securityUserFactory)
    {
        $this->securityUserFactory = $securityUserFactory;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('msgphp_current_user', [$this->securityUserFactory, 'getUser']),
        ];
    }
}

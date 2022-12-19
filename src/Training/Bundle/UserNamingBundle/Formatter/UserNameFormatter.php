<?php

namespace Training\Bundle\UserNamingBundle\Formatter;

use Oro\Bundle\UserBundle\Entity\User;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

/**
 * Replaces placeholder parts with real User fields according to provided format
 */
class UserNameFormatter
{
    public function format(User $user, string $format): string
    {
        $replacements = UserNamingType::getUserNameParts($user);

        return strtr($format, $replacements);
    }
}

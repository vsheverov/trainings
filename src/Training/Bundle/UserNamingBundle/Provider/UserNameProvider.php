<?php

namespace Training\Bundle\UserNamingBundle\Provider;

use Oro\Bundle\EntityBundle\Provider\EntityNameProviderInterface;
use Oro\Bundle\UserBundle\Entity\User;
use Training\Bundle\UserNamingBundle\Formatter\UserNameFormatter;

/**
 * Provides custom full name representation for Entity User
 */
class UserNameProvider implements EntityNameProviderInterface
{
    private EntityNameProviderInterface $originalEntityNameProvider;

    private UserNameFormatter $userNameFormatter;

    public function __construct(
        EntityNameProviderInterface $originalEntityNameProvider,
        UserNameFormatter           $userNameFormatter
    ) {
        $this->originalEntityNameProvider = $originalEntityNameProvider;
        $this->userNameFormatter = $userNameFormatter;
    }

    /**
     * Returns custom user full name representation
     *
     * {@inheritdoc}
     */
    public function getName($format, $locale, $entity): string
    {
        if ($entity instanceof User && $entity->getNamingType()) {
            return $this->userNameFormatter->format($entity, $entity->getNamingType()->getFormat());
        }

        return $this->originalEntityNameProvider->getName($format, $locale, $entity);
    }

    /**
     * {@inheritdoc}
     */
    public function getNameDQL($format, $locale, $className, $alias): string
    {
        return $this->originalEntityNameProvider->getNameDQL($format, $locale, $className, $alias);
    }
}

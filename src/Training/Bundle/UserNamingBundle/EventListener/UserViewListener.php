<?php

namespace Training\Bundle\UserNamingBundle\EventListener;

use Oro\Bundle\UIBundle\Event\BeforeListRenderEvent;
use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * This class listen to BeforeListRenderEvent and some blocks
 */
class UserViewListener
{
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Adds sub-block to user profile page in admin panel
     */
    public function onUserView(BeforeListRenderEvent $event): void
    {
        if (!$event->getEntity() instanceof User) {
            return;
        }

        if (!$this->authorizationChecker->isGranted('user_naming_view')) {
            return;
        }

        $event->getScrollData()->addSubBlockData(0, 0, $this->getTemplate($event));
    }

    private function getTemplate(BeforeListRenderEvent $event): string
    {
        return $event->getEnvironment()->render(
            '@TrainingUserNaming/User/custom_user_block.html.twig',
            ['user' => $event->getEntity()]
        );
    }
}

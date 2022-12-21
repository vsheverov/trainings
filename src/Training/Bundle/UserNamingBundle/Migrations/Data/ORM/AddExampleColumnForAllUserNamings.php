<?php

namespace Training\Bundle\UserNamingBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;
use Training\Bundle\UserNamingBundle\Formatter\UserNameFormatter;

class AddExampleColumnForAllUserNamings extends AbstractFixture implements
    DependentFixtureInterface,
    ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getDependencies(): array
    {
        return [LoadUserNamingData::class];
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var UserNamingType[] $userNamings
         */
        $userNamings = $manager->getRepository(UserNamingType::class)->findAll();

        foreach ($userNamings as $userNaming) {
            if ($userNaming->getExample()) {
                continue;
            }

            $userNaming->setExample(
                $this->generateExample($userNaming->getFormat())
            );
        }

        $manager->flush();
    }

    private function generateExample(string $format): string
    {
        return $this->container->get(UserNameFormatter::class)->formatExample($format);
    }
}

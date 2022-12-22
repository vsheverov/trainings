<?php

namespace Training\Bundle\UserNamingBundle\Integration\Model;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;
use Training\Bundle\UserNamingBundle\Entity\FakeTransportSettings;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class SyncManager
{
    private const TMP_LOCAL_PATH = '/Volumes/sourcecode/oro/trainings/public/bundles/trainingusernaming';
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function createOrSkipUserNamings(FakeTransportSettings $fakeTransportSettings): void
    {
        $url = $fakeTransportSettings->getUrl();

        $sourceUserNamings = \json_decode(file_get_contents(
            str_replace('http://127.0.0.1:8000', self::TMP_LOCAL_PATH, $url)
        ), true);

        foreach ($sourceUserNamings as $userNamingItem) {
            if (!$this->getUserNamingRepository()->find($userNamingItem['id'])) {
                $this->registry->getManager()->persist(
                    UserNamingType::fromArray($userNamingItem)
                );
            }
        }

        $this->registry->getManager()->flush();
    }

    private function getUserNamingRepository(): ObjectRepository
    {
        return $this->registry->getRepository(UserNamingType::class);
    }
}

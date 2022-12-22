<?php

namespace Training\Bundle\UserNamingBundle\Integration\Command;

use Doctrine\Persistence\ManagerRegistry;
use Oro\Bundle\IntegrationBundle\Entity\Channel as Integration;
use Oro\Bundle\IntegrationBundle\Entity\Repository\ChannelRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Training\Bundle\UserNamingBundle\Integration\Model\SyncManager;
use Training\Bundle\UserNamingBundle\Integration\Provider\TrainingFakeChannelType;

class FakeIntegrationSync extends Command
{
    protected static $defaultName = 'training:fake:import-naming';

    private ManagerRegistry $registry;

    private SyncManager $syncManager;

    public function __construct(ManagerRegistry $registry, SyncManager $syncManager)
    {
        parent::__construct();

        $this->registry = $registry;
        $this->syncManager = $syncManager;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $formatter = $this->getHelper('formatter');

        try {
            $integrationInstances = $this->getIntegrationRepository()
                ->getConfiguredChannelsForSync(TrainingFakeChannelType::TYPE);

            foreach ($integrationInstances as $integrationInstance) {
                $this->syncManager->createOrSkipUserNamings($integrationInstance->getTransport());
            }

            $message = $formatter->formatBlock(['Command has been executed successfully'], 'info');

            $output->writeln($message);

            return Command::SUCCESS;
        } catch (\Throwable $throwable) {
            $message = $formatter->formatBlock([
                'Command has been finished with error', $throwable->getMessage()
            ], 'error');

            $output->writeln($message);

            return Command::FAILURE;
        }
    }

    protected function getIntegrationRepository(): ChannelRepository
    {
        return $this->registry->getRepository(Integration::class);
    }
}

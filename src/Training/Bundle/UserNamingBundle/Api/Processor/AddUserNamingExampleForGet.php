<?php

namespace Training\Bundle\UserNamingBundle\Api\Processor;

use Oro\Component\ChainProcessor\ContextInterface;
use Oro\Component\ChainProcessor\ProcessorInterface;
use Training\Bundle\UserNamingBundle\Formatter\UserNameFormatter;

/**
 * Add nameExample property for api get action according to User Naming API configuration
 */
class AddUserNamingExampleForGet implements ProcessorInterface
{
    private const META_PROPERTY_KEY = 'nameExample';

    private UserNameFormatter $nameFormatter;

    public function __construct(UserNameFormatter $nameFormatter)
    {
        $this->nameFormatter = $nameFormatter;
    }

    public function process(ContextInterface $context)
    {
        if (!$context->getMetadata()?->hasProperty(self::META_PROPERTY_KEY)) {
            return;
        }

        $result = $context->getResult();

        if (!$result || !isset($result['format'])) {
            return;
        }

        $result[self::META_PROPERTY_KEY] = $this->nameFormatter->formatExample($result['format']);

        $context->setResult($result);
    }
}

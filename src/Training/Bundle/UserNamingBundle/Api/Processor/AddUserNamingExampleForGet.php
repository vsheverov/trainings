<?php

namespace Training\Bundle\UserNamingBundle\Api\Processor;

use Oro\Component\ChainProcessor\ContextInterface;
use Oro\Component\ChainProcessor\ProcessorInterface;
use Training\Bundle\UserNamingBundle\Formatter\UserNameFormatter;

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

        if (!$result || !isset($item['format'])) {
            return;
        }

        $result[self::META_PROPERTY_KEY] = $this->nameFormatter->formatExample($item['format']);

        $context->setResult($result);
    }
}

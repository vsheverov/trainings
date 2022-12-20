<?php

namespace Training\Bundle\UserNamingBundle\Api\Processor;

use Oro\Component\ChainProcessor\ContextInterface;
use Oro\Component\ChainProcessor\ProcessorInterface;
use Training\Bundle\UserNamingBundle\Formatter\UserNameFormatter;

class AddUserNamingExampleForGetMethods implements ProcessorInterface
{
    private const META_PROPERTY_KEY = 'nameExample';

    private UserNameFormatter $nameFormatter;
    public function __construct(UserNameFormatter $nameFormatter)
    {
        $this->nameFormatter = $nameFormatter;
    }

    public function process(ContextInterface $context)
    {
        if (! $context->getMetadata()?->hasProperty(self::META_PROPERTY_KEY)) {
            return;
        }

        $result = $context->getResult();

        if (! $result) {
            return;
        }

        $isSingleResult = $context->getAction() === 'get';

        if ($isSingleResult) {
            $result = [$result];
        }

        foreach ($result as $key => $item) {
            if (!isset($item['format'])) {
                continue;
            }

            $result[$key][self::META_PROPERTY_KEY] = $this->nameFormatter->formatExample($item['format']);
        }

        if ($isSingleResult) {
            $result = $result[0];
        }

        $context->setResult($result);
    }
}

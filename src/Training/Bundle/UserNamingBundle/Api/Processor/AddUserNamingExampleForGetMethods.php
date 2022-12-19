<?php

namespace Training\Bundle\UserNamingBundle\Api\Processor;

use Oro\Component\ChainProcessor\ContextInterface;
use Oro\Component\ChainProcessor\ProcessorInterface;

class AddUserNamingExampleForGetMethods implements ProcessorInterface
{

    public function process(ContextInterface $context)
    {
        //dd($context->getResult());
    }
}

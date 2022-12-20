<?php

namespace Training\Bundle\UserNamingBundle\Twig;

use Training\Bundle\UserNamingBundle\Formatter\UserNameFormatter;
use Twig\Extension\RuntimeExtensionInterface;

class TrainingNameFormatRuntime implements RuntimeExtensionInterface
{
    private UserNameFormatter $nameFormatter;

    public function __construct(UserNameFormatter $nameFormatter)
    {
        $this->nameFormatter = $nameFormatter;
    }

    public function getExampleForUserNaming(string $format): string
    {
        return $this->nameFormatter->formatExample($format);
    }
}

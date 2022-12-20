<?php

namespace Training\Bundle\UserNamingBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TrainingFormatExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('training_example_user_naming', [
                TrainingNameFormatRuntime::class, 'getExampleForUserNaming'
            ]),
        ];
    }
}

<?php

namespace Training\Bundle\UserNamingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Provides settings for the fake integration
 *
 * @ORM\Entity
 * @Config()
 */
class FakeTransportSettings extends Transport
{
    /**
     * @ORM\Column(name="fki_url", type="string", length=120)
     */
    private string $url;

    private ?ParameterBag $settings = null;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getSettingsBag()
    {
        if (null === $this->settings) {
            $this->settings = new ParameterBag([
                'url' => $this->getUrl()
            ]);
        }

        return $this->settings;
    }
}

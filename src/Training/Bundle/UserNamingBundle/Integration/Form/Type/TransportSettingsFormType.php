<?php

namespace Training\Bundle\UserNamingBundle\Integration\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Training\Bundle\UserNamingBundle\Entity\FakeTransportSettings;

class TransportSettingsFormType extends AbstractType
{
    const NAME = 'training_fake_transport_setting_form_type';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'url',
            UrlType::class,
            [
                'label' => 'oro.website.url.label',
                'required' => true
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => FakeTransportSettings::class]);
    }

    public function getName(): string
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix(): string
    {
        return self::NAME;
    }
}

<?php

namespace Training\Bundle\UserNamingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Training\Bundle\UserNamingBundle\Model\ExtendUserNamingType;

/**
 * UserNamingType contains different formats for User full name representation
 *
 * @ORM\Entity()
 * @ORM\Table(name="training_user_naming_type")
 * @Config(
 *     defaultValues={
 *          "security"={
 *              "type"="ACL",
 *              "group_name"="",
 *              "category"="user_naming_management"
 *          }
 *     }
 * )
 */
class UserNamingType extends ExtendUserNamingType
{
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int|null $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     */
    private string|null $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private string|null $format;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private string|null $example;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int|null $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string|null
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFormat(): string|null
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getExample(): ?string
    {
        return $this->example;
    }

    public function setExample(?string $example): void
    {
        $this->example = $example;
    }

    /**
     * Provides parts of the User name that we can use in user naming
     */
    public static function getUserNameParts(User $user): array
    {
        return [
            'PREFIX' => $user->getNamePrefix(),
            'FIRST' => $user->getFirstName(),
            'MIDDLE' => $user->getMiddleName(),
            'LAST' => $user->getLastName(),
            'SUFFIX' => $user->getNameSuffix(),
        ];
    }

    public static function getExampleUser(): User
    {
        $user = new User();

        $user->setNamePrefix('Mr.')
            ->setFirstName('John')
            ->setMiddleName('M')
            ->setLastName('Doe')
            ->setNameSuffix('Jr.');

        return $user;
    }

    public static function fromArray(array $source): self
    {
        $userNaming = new self();

        $userNaming->id = $source['id'];
        $userNaming->title = $source['title'];
        $userNaming->format = $source['format'];

        return $userNaming;
    }
}

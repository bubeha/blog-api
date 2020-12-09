<?php

declare(strict_types=1);

namespace App\Entity\Embedded;

use Doctrine\ORM\Mapping AS ORM;

/**
 * Class FullName
 * @package App\Entity\Embedded
 */
class FullName
{
    /**
     * @var string
     * @ORM\Column(type="string)
     */
    private string $firstName;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $lastName;

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
}

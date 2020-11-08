<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\Table("articles")
 */
class Article
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=\Ramsey\Uuid\Doctrine\UuidGenerator::class)
     */
    private UuidInterface $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Article
     */
    public function setName(string $name): Article
    {
        $this->name = $name;

        return $this;
    }
}

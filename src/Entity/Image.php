<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImageRepository;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Image(
     *      maxSize = "1M",
     *      maxSizeMessage = "Votre avatar ne doit pas dépasser 1 Mo",
     * )
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Figure::class, inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $figures;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFigures(): ?Figure
    {
        return $this->figures;
    }

    public function setFigures(?Figure $figures): self
    {
        $this->figures = $figures;

        return $this;
    }
}

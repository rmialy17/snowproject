<?php

namespace App\Entity;

use App\Entity\Figure;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VideoRepository;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

  /**
     * @ORM\Column(type="string", length=255)
     */
    private $URL;

    /**
     * @ORM\ManyToOne(targetEntity=Figure::class, inversedBy="videos", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $figures;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getURL(): ?string
    {
        return $this->URL;
    }

    public function setURL(?string $URL): self
    {
        $this->URL = $URL;

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

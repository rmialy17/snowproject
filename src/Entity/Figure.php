<?php

namespace App\Entity;

use App\Entity\Commentaire;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FigureRepository;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * @ORM\Entity(repositoryClass=FigureRepository::class)
 * @UniqueEntity(
 * fields = {"nom"},
 * message="La figure existe déjà."
 * )
 */
class Figure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**

    * @ORM\Column(type="string", length=255, nullable=true)
    * @Assert\NotBlank(
    *      message = "Ce champ est requis !"
    * )
    * @Assert\Length(
    *      min = 3,
    *      max = 50,
    *      minMessage = "Votre titre de figure doit contenir au moins {{ limit }} caractères !",
    *      maxMessage = "Votre titre de figure ne peut pas contenir plus que {{ limit }} caractères !"
    * )
     */

    private $nom;
    
 
    private $nomfig;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Ce champ est requis !"
     * )
     * @Assert\Length(
     *      min = 5,
     *      minMessage = "La description du figure doit contenir au moins {{ limit }} caractères !",
     *      max = 10000,
     *      maxMessage = "La description du figure ne peut pas contenir plus que {{ limit }} caractères !"
     * )

     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $imagetop;

     /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="figures",  orphanRemoval=true, cascade={"persist"})
     */
    private $videos;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="figures")
     * @Assert\NotBlank(
     *      message = "Ce champ est requis !"
     * )
     */
    private $categorie;

   
    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="figures", cascade={"remove"})
     */
    private $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="figures")
     */
    private $user;


    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="figures", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

   
    private $imagetop_upload;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */

    private $slug;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();


    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImagetop(): ?string
    {
        return $this->imagetop;
    }

    public function setImagetop(string $imagetop): self
    {
        $this->imagetop = $imagetop;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }


    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setFigures($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getFigures() === $this) {
                $commentaire->setFigures(null);
            }
        }

        return $this;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setUser(?Utilisateur $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setFigures($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getFigures() === $this) {
                $image->setFigures(null);
            }
        }

        return $this;
    }

        /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setFigures($this);

        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getFigures() === $this) {
                $video->setFigures(null);

            }
        }

        return $this;
    }
  
    public function getImagetopUpload(): ?string
    {
        return $this->imagetop_upload;
    }

    public function setImagetopUpload(string $imagetop_upload): self
    {
        $this->imagetop_upload = $imagetop_upload;
      
        return $this;
    }

    public function getNomfig(): ?string
    {
        return $this->nomfig;
    }

    public function setNomfig(string $nomfig): self
    {
        $this->nomfig = $nomfig;
      

        return $this;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}

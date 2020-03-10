<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\SeriesRepository")
 */
class Series
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startday;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endday;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"})
     */

    private $affiche;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbsaison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="series")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

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

    public function getStartday(): ?\DateTimeInterface
    {
        return $this->startday;
    }

    public function setStartday(\DateTimeInterface $startday): self
    {
        $this->startday = $startday;

        return $this;
    }

    public function getEndday(): ?\DateTimeInterface
    {
        return $this->endday;
    }

    public function setEndday(\DateTimeInterface $endday): self
    {
        $this->endday = $endday;

        return $this;
    }

    public function getAffiche()
    {
        return $this->affiche;
    }

    public function setAffiche($affiche)
    {
        $this->affiche = $affiche;

        return $this;
    }

    public function getNbsaison(): ?int
    {
        return $this->nbsaison;
    }

    public function setNbsaison(int $nbsaison): self
    {
        $this->nbsaison = $nbsaison;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}

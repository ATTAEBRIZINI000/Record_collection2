<?php

namespace App\Entity;

use App\Repository\RecordsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecordsRepository::class)]
class Records
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['get_records'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_records'])]
    private ?string $artist = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_records'])]
    private ?string $albumTitle = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_records'])]
    private ?string $label = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['get_records'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_records'])]
    private ?string $vinylsNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_records'])]
    private ?string $category = null; 

    #[ORM\Column(length: 255)]
    #[Groups(['get_records'])]
    private ?string $state = null;

    // Getters and setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getAlbumTitle(): ?string
    {
        return $this->albumTitle;
    }

    public function setAlbumTitle(string $albumTitle): self
    {
        $this->albumTitle = $albumTitle;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getVinylsNumber(): ?string
    {
        return $this->vinylsNumber;
    }

    public function setVinylsNumber(string $vinylsNumber): self
    {
        $this->vinylsNumber = $vinylsNumber;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }
}

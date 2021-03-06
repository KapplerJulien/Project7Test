<?php

namespace App\Entity;

use App\Repository\PhoneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PhoneRepository::class)
 */
class Phone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"list", "show"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list", "show"})
     * @Assert\NotBlank()
     * @Assert\Length(min="2", minMessage="Ce champ doit contenir un minimum de 2 caractères", max="255", maxMessage="Ce champ doit contenir un maximum de 255 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"list", "show"})
     * @Assert\NotBlank()
     * @Assert\Range(min="0", minMessage="La valeur minimum autorisée est 0", max="1500", maxMessage="La valeur maximum autorisée est 1500")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     * @Assert\NotBlank()
     * @Assert\Length(min="2", minMessage="Ce champ doit contenir un minimum de 2 caractères", max="255", maxMessage="Ce champ doit contenir un maximum de 255 caractères")
     */
    private $color;

    /**
     * @ORM\Column(type="text")
     * @Groups({"show"})
     */
    private $description;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

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
}

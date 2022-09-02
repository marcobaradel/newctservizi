<?php

namespace App\Entity;

use App\Repository\BuyerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuyerRepository::class)]
class Buyer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 5)]
    private ?string $cap = null;

    #[ORM\ManyToOne(inversedBy: 'buyers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Countries $country = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone2 = null;

    #[ORM\Column(length: 255)]
    private ?string $p_iva = null;

    #[ORM\Column(length: 255)]
    private ?string $c_fis = null;

    #[ORM\OneToMany(mappedBy: 'buyer', targetEntity: Ticket::class, orphanRemoval: true)]
    private Collection $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCap(): ?string
    {
        return $this->cap;
    }

    public function setCap(string $cap): self
    {
        $this->cap = $cap;

        return $this;
    }

    public function getCountry(): ?Countries
    {
        return $this->country;
    }

    public function setCountry(?Countries $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone2(): ?string
    {
        return $this->phone2;
    }

    public function setPhone2(string $phone2): self
    {
        $this->phone2 = $phone2;

        return $this;
    }

    public function getPIva(): ?string
    {
        return $this->p_iva;
    }

    public function setPIva(string $p_iva): self
    {
        $this->p_iva = $p_iva;

        return $this;
    }

    public function getCFis(): ?string
    {
        return $this->c_fis;
    }

    public function setCFis(string $c_fis): self
    {
        $this->c_fis = $c_fis;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setBuyer($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getBuyer() === $this) {
                $ticket->setBuyer(null);
            }
        }

        return $this;
    }
}

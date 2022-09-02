<?php

namespace App\Entity;

use App\Repository\ZtlPassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZtlPassTypeRepository::class)]
class ZtlPassType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price_low = null;

    #[ORM\Column]
    private ?int $price_high = null;

    #[ORM\OneToMany(mappedBy: 'pass_type', targetEntity: Ticket::class, orphanRemoval: true)]
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

    public function getPriceLow(): ?int
    {
        return $this->price_low;
    }

    public function setPriceLow(int $price_low): self
    {
        $this->price_low = $price_low;

        return $this;
    }

    public function getPriceHigh(): ?int
    {
        return $this->price_high;
    }

    public function setPriceHigh(int $price_high): self
    {
        $this->price_high = $price_high;

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
            $ticket->setPassType($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getPassType() === $this) {
                $ticket->setPassType(null);
            }
        }

        return $this;
    }
}

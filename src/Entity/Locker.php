<?php

namespace App\Entity;

use App\Repository\LockerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LockerRepository::class)]
class Locker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $locker_number = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?int $volume = null;

    #[ORM\OneToMany(mappedBy: 'locker', targetEntity: Package::class)]
    private Collection $packages;

    #[ORM\ManyToOne(inversedBy: 'lockers')]
    private ?RelayCenter $relayCenter = null;

    #[ORM\ManyToOne(inversedBy: 'lockers')]
    private ?User $user = null;

    public function __construct()
    {
        $this->packages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLockerNumber(): ?int
    {
        return $this->locker_number;
    }

    public function setLockerNumber(int $locker_number): static
    {
        $this->locker_number = $locker_number;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(int $volume): static
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * @return Collection<int, Package>
     */
    public function getPackages(): Collection
    {
        return $this->packages;
    }

    public function addPackage(Package $package): static
    {
        if (!$this->packages->contains($package)) {
            $this->packages->add($package);
            $package->setLocker($this);
        }

        return $this;
    }

    public function removePackage(Package $package): static
    {
        if ($this->packages->removeElement($package)) {
            // set the owning side to null (unless already changed)
            if ($package->getLocker() === $this) {
                $package->setLocker(null);
            }
        }

        return $this;
    }

    public function getRelayCenter(): ?RelayCenter
    {
        return $this->relayCenter;
    }

    public function setRelayCenter(?RelayCenter $relayCenter): static
    {
        $this->relayCenter = $relayCenter;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

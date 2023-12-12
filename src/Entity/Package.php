<?php

namespace App\Entity;

use App\Repository\PackageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PHLAK\StrGen;

#[ORM\Entity(repositoryClass: PackageRepository::class)]
class Package
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $weight = null;

    #[ORM\Column]
    private ?int $volume = null;

    #[ORM\ManyToOne(inversedBy: 'packages')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'packages')]
    private ?Locker $locker = null;

    #[ORM\Column(length: 255)]
    private ?string $tracking_number = null;

    #[ORM\OneToMany(mappedBy: 'package', targetEntity: Localisation::class)]
    private Collection $localisations;

    public function __construct()
    {
        $this->localisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getLocker(): ?Locker
    {
        return $this->locker;
    }

    public function setLocker(?Locker $locker): static
    {
        $this->locker = $locker;

        return $this;
    }

    public function getTrackingNumber(): ?string
    {
        return $this->tracking_number;
    }

    public function setTrackingNumber(string $tracking_number): static
    {
        $this->tracking_number = $tracking_number;

        return $this;
    }

    /**
     * @return Collection<int, Localisation>
     */
    public function getLocalisations(): Collection
    {
        return $this->localisations;
    }

    public function addLocalisation(Localisation $localisation): static
    {
        if (!$this->localisations->contains($localisation)) {
            $this->localisations->add($localisation);
            $localisation->setPackage($this);
        }

        return $this;
    }

    public function removeLocalisation(Localisation $localisation): static
    {
        if ($this->localisations->removeElement($localisation)) {
            // set the owning side to null (unless already changed)
            if ($localisation->getPackage() === $this) {
                $localisation->setPackage(null);
            }
        }

        return $this;
    }

    public function generateTrackingNumber(){
        $generator = new StrGen\Generator();
        return $generator->length(10)->charset([StrGen\CharSet::UPPER_ALPHA, StrGen\CharSet::NUMERIC])->generate();
    }

    public function getLastLocalisation(){
        $iterator = $this->localisations->getIterator();
        $iterator->uasort(function (Localisation $a, Localisation $b) {
            return $a->getTimestamp() > $b->getTimestamp() ? 1 : -1;
        });
        $localisations = new ArrayCollection(iterator_to_array($iterator));
        return $localisations->last() ? $localisations->last() : null;
    }
}

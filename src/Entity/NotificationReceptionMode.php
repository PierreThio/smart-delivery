<?php

namespace App\Entity;

use App\Repository\NotificationReceptionModeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationReceptionModeRepository::class)]
class NotificationReceptionMode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reception_mode = null;

    #[ORM\OneToMany(mappedBy: 'notification_reception_mode', targetEntity: Notification::class)]
    private Collection $notifications;

    public function __construct()
    {
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceptionMode(): ?string
    {
        return $this->reception_mode;
    }

    public function setReceptionMode(string $reception_mode): static
    {
        $this->reception_mode = $reception_mode;

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setNotificationReceptionMode($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getNotificationReceptionMode() === $this) {
                $notification->setNotificationReceptionMode(null);
            }
        }

        return $this;
    }
}

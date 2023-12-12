<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timestamp = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?NotificationReceptionMode $notification_reception_mode = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?NotificationContent $notification_content = null;

    #[ORM\Column]
    private ?bool $checked = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;

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

    public function getNotificationReceptionMode(): ?NotificationReceptionMode
    {
        return $this->notification_reception_mode;
    }

    public function setNotificationReceptionMode(?NotificationReceptionMode $notification_reception_mode): static
    {
        $this->notification_reception_mode = $notification_reception_mode;

        return $this;
    }

    public function getNotificationContent(): ?NotificationContent
    {
        return $this->notification_content;
    }

    public function setNotificationContent(?NotificationContent $notification_content): static
    {
        $this->notification_content = $notification_content;

        return $this;
    }

    public function isChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(bool $checked): static
    {
        $this->checked = $checked;

        return $this;
    }
}

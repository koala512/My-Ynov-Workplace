<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\GetConversationCollectionController;
use App\Controller\GetConversationController;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ConversationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ConversationRepository::class)]
#[ApiResource(
    security: "is_granted('ROLE_USER')",
    operations: [
    new Get(controller: GetConversationController::class),
    new GetCollection(controller: GetConversationCollectionController::class),
    new Post(),
    new Delete(security: "is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') and object.owner == user")
    ],
normalizationContext: ['groups' => ['conversation:read']],
denormalizationContext: ['groups' => ['conversation:write']]
)]
class Conversation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ownerConversations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['conversation:read'])]
    private ?User $owner = null;

    #[ORM\ManyToOne(inversedBy: 'guestConversations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['conversation:read', 'conversation:write'])]
    private ?User $guest = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getGuest(): ?User
    {
        return $this->guest;
    }

    public function setGuest(?User $guest): self
    {
        $this->guest = $guest;

        return $this;
    }
}

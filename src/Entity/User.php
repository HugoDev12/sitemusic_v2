<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields:["email"], message: "Il y a déjà un compte avec cette adresse mail.")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 15)]
    private ?string $pseudo = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_alone;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $instrument = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $style_music = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $book = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $last_login = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $level = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Advertisement>
     */
    #[ORM\OneToMany(targetEntity: Advertisement::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $advertisement;

    /**
     * @var Collection<int, Messages>
     */
    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'sender', orphanRemoval: true)]
    private Collection $messages_sent;

       /**
     * @var Collection<int, Messages>
     */
    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'recipient', orphanRemoval: true)]
    private Collection $messages_received;

    public function __construct()
    {
        $this->roles = ["ROLE_USER"];
        $this->date = new \DateTime();
        $this->is_alone = true;
        $this->advertisement = new ArrayCollection();
        $this->messages_sent = new ArrayCollection();
        $this->messages_received = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(string $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function isIsAlone(): ?bool
    {
        return $this->is_alone;
    }

    public function setIsAlone(bool $is_alone): static
    {
        $this->is_alone = $is_alone;

        return $this;
    }

    public function getInstrument(): ?string
    {
        return $this->instrument;
    }

    public function setInstrument(?string $instrument): static
    {
        $this->instrument = $instrument;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getStyleMusic(): ?string
    {
        return $this->style_music;
    }

    public function setStyleMusic(?string $style_music): static
    {
        $this->style_music = $style_music;

        return $this;
    }

    public function getBook(): ?string
    {
        return $this->book;
    }

    public function setBook(?string $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->last_login;
    }

    public function setLastLogin(?\DateTimeInterface $last_login): static
    {
        $this->last_login = $last_login;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Advertisement>
     */
    public function getAdvertisement(): Collection
    {
        return $this->advertisement;
    }

    public function addAdvertisement(Advertisement $advertisement): static
    {
        if (!$this->advertisement->contains($advertisement)) {
            $this->advertisement->add($advertisement);
            $advertisement->setUser($this);
        }

        return $this;
    }

    public function removeAdvertisement(Advertisement $advertisement): static
    {
        if ($this->advertisement->removeElement($advertisement)) {
            // set the owning side to null (unless already changed)
            if ($advertisement->getUser() === $this) {
                $advertisement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getMessagesReceived(): Collection
    {
        return $this->messages_received;
    }

    public function addMessageReceived(Messages $messages_received): static
    {
        if (!$this->messages_received->contains($messages_received)) {
            $this->messages_received->add($messages_received);
            $messages_received->setRecipient($this);
        }

        return $this;
    }

    public function removeMessageReceived(Messages $messages_received): static
    {
        if ($this->messages_received->removeElement($messages_received)) {
            // set the owning side to null (unless already changed)
            if ($messages_received->getRecipient() === $this) {
                $messages_received->setRecipient(null);
            }
        }

        return $this;
    }

        /**
     * @return Collection<int, Messages>
     */
    public function getMessagesSent(): Collection
    {
        return $this->messages_sent;
    }

    public function addMessageSent(Messages $messages_sent): static
    {
        if (!$this->messages_sent->contains($messages_sent)) {
            $this->messages_sent->add($messages_sent);
            $messages_sent->setSender($this);
        }

        return $this;
    }

    public function removeMessageSent(Messages $messages_sent): static
    {
        if ($this->messages_sent->removeElement($messages_sent)) {
            // set the owning side to null (unless already changed)
            if ($messages_sent->getSender() === $this) {
                $messages_sent->setSender(null);
            }
        }

        return $this;
    }

      /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}

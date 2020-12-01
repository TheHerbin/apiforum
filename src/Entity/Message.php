<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;


/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @ApiResource()

 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $titre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePoste;

    /**
     * @ORM\Column(type="text")
     */
      private $corps;

      /**
       * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages", cascade={"persist"})
       * @ORM\JoinColumn(nullable=false)
       */
      private $user;
  
      /**
       * @ORM\ManyToOne(targetEntity=Message::class, inversedBy="messages")
       */
      private $message;
  
      /**
       * @ORM\OneToMany(targetEntity=Message::class, mappedBy="message")
       */
      private $messages;
  
      public function __construct()
      {
          $this->messages = new ArrayCollection();
      }
  
      public function getId(): ?int
      {
          return $this->id;
      }
  
      public function getTitre(): ?string
      {
          return $this->titre;
      }
  
      public function setTitre(string $titre): self
      {
          $this->titre = $titre;
  
          return $this;
      }
  
      public function getDatePoste(): ?\DateTimeInterface
      {
          return $this->datePoste;
      }
  
      public function setDatePoste(\DateTimeInterface $datePoste): self
      {
          $this->datePoste = $datePoste;
  
          return $this;
      }
      public function getCorps(): ?string
      {
          return $this->corps;
      }
  
      public function setCorps(string $corps): self
      {
          $this->corps = $corps;
  
          return $this;
      }
  
      public function getUser(): ?User
      {
          return $this->user;
      }
  
      public function setUser(?User $user): self
      {
          $this->user = $user;
  
          return $this;
      }
  
      public function getMessage(): ?self
      {
          return $this->message;
      }
  
      public function setMessage(?self $message): self
      {
          $this->message = $message;
  
          return $this;
      }
  
      /**
       * @return Collection|self[]
       */
      public function getMessages(): Collection
      {
          return $this->messages;
      }
  
      public function addMessage(self $message): self
      {
          if (!$this->messages->contains($message)) {
              $this->messages[] = $message;
              $message->setMessage($this);
          }
          return $this;
    }

    public function removeMessage(self $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getMessage() === $this) {
                $message->setMessage(null);
            }
        }

        return $this;
    }
}

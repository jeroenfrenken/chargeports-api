<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("read")
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Groups("read")
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @Groups("read")
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=UserToken::class, mappedBy="user", orphanRemoval=true)
     */
    private $userTokens;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->userTokens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFullName()
    {
        return "{$this->getFirstName()} {$this->getLastName()}";
    }

    public function getRoles()
    {
        return ["ROLE_USER"];
    }

    public function getSalt()
    {
        return "";
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    {
        $this->password = null;
    }

    /**
     * @return Collection|UserToken[]
     */
    public function getUserTokens(): Collection
    {
        return $this->userTokens;
    }

    public function addUserToken(UserToken $userToken): self
    {
        if (!$this->userTokens->contains($userToken)) {
            $this->userTokens[] = $userToken;
            $userToken->setUser($this);
        }

        return $this;
    }

    public function removeUserToken(UserToken $userToken): self
    {
        if ($this->userTokens->contains($userToken)) {
            $this->userTokens->removeElement($userToken);
            // set the owning side to null (unless already changed)
            if ($userToken->getUser() === $this) {
                $userToken->setUser(null);
            }
        }

        return $this;
    }
}

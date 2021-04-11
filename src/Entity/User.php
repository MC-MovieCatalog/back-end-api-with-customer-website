<?php

namespace App\Entity;

use DateTime;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`users`")
 * @UniqueEntity(fields={"email"}, message="Un compte existe déjà pour cette adresse email")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(type="string", length=180, unique=true)
     * 
     * @Assert\Email(
     *     message = "L'adresse email '{{ value }}' n'est pas valide."
     * )
     * @Assert\NotBlank(message="L'email est obligatoire")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * Getting and setting user password befor enconding by password property
     *
     * @var string
     * @Assert\Length(
     *      min=6,
     *      minMessage="Vous ne pouvez pas saisir moins de 6 caractères",
     *      max=255, 
     *      maxMessage="Vous ne pouvez pas saisir plus de 255 caractères"
     * )
     * @Assert\NotBlank(message="Le mot de passe est obligatoire")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\Type("string", message="Format non pris en charge")
     * @Assert\Length(
     *      min=2,
     *      minMessage="Vous devez saisir un nom contenant au moins deux caractères", 
     *      max=80, 
     *      maxMessage="Vous ne pouvez pas dépasser 80 caractères"
     * )
     * @Assert\NotBlank(message="Le nom est obligatoire")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=80)
     * @ORM\Column(type="string", length=80)
     * @Assert\Type("string", message="Format non pris en charge")
     * @Assert\Length(
     *      min=2,
     *      minMessage="Vous devez saisir un prénom contenant au moins deux caractères", 
     *      max=80, 
     *      maxMessage="Vous ne pouvez pas saisir plus de 80 caractères"
     * )
     * @Assert\NotBlank(message="Le prénom est obligatoire")
     */
    private $firstName;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $inscriptionDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expirationDate;

    /* -- RGPD -- */

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message="L'utilisation de nos services require votre consentement")
     * @Assert\Type(
     *     type="bool",
     *     message="La valeur {{ value }} n'est pas un {{ type }} valid."
     * )
     */
    private $agreeTerms;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $agreeTermsValidateAt;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="author", orphanRemoval=true)
     */
    private $ratings;

    /**
     * @ORM\OneToMany(targetEntity=Invoice::class, mappedBy="customer")
     */
    private $invoices;

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="user")
     */
    private $addresses;

    public function __construct() {
        if (!empty($this->id)) {
            $this->inscriptionDate = new DateTime('now');
        }
        $this->ratings = new ArrayCollection();
        $this->invoices = new ArrayCollection();
        $this->addresses = new ArrayCollection();
    }

    /**
     * Create user
     *
     * @ORM\PrePersist
     * 
     * @return void
     */
    public function createUser() {
        if (empty($this->inscriptionDate)) {
            $this->inscriptionDate = new DateTime('now');
        }
        if(!empty($this->agreeTerms)) {
            $this->agreeTermsValidateAt = new \DateTime('now');
        }
    }

    /**
     * Active user if isVerified = true
     *
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function activeOrDesactivateUser() {
        
        if ($this->isActive !== NULL) {
            if($this->isActive === false) {
                $this->expirationDate = new DateTime('now');
            } else {
                if($this->isActive === true) {
                    $this->expirationDate = NULL;
                }
            }
        } else {
            if(empty($this->isActive) && !empty($this->isVerified)) {
                $this->isActive = 1;
            }
        }
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getInscriptionDate(): ?\DateTimeInterface
    {
        return $this->inscriptionDate;
    }

    public function setInscriptionDate(?\DateTimeInterface $inscriptionDate): self
    {
        $this->inscriptionDate = $inscriptionDate;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(?\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /* --RGPD-- */

    public function getAgreeTerms(): ?bool
    {
        return $this->agreeTerms;
    }

    public function setAgreeTerms(bool $agreeTerms): self
    {
        $this->agreeTerms = $agreeTerms;

        return $this;
    }

    public function getAgreeTermsValidatedAt(): ?\DateTimeInterface
    {
        return $this->agreeTermsValidateAt;
    }

    public function setAgreeTermsValidatedAt(?\DateTimeInterface $agreeTermsValidateAt): self
    {
        $this->agreeTermsValidateAt = $agreeTermsValidateAt;

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setAuthor($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getAuthor() === $this) {
                $rating->setAuthor(null);
            }
        }

        return $this;
    }

    public function getFullName(){
        return "{$this->firstName} {$this->lastName}";
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setCustomer($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getCustomer() === $this) {
                $invoice->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setUser($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }

        return $this;
    }
}

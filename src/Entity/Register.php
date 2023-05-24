<?php

namespace App\Entity;

use App\Repository\RegisterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegisterRepository::class)]
class Register
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $payment = null;

    #[ORM\ManyToOne(inversedBy: 'registers')]
    private ?user $member = null;





    public function __construct()
    {
        $this->lesson = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPayment(): ?string
    {
        return $this->payment;
    }

    public function setPayment(string $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getMember(): ?user
    {
        return $this->member;
    }

    public function setMember(?user $member): self
    {
        $this->member = $member;

        return $this;
    }

    /**
     * @return Collection<int, lesson>
     */









}

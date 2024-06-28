<?php

namespace App\Entity;

use App\Repository\TelefoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TelefoneRepository::class)]
class Telefone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 11)]
    private string $telefone;

    #[ORM\Column(length: 255)]
    private string $descricao;

    #[ORM\ManyToOne(inversedBy: 'telefones')]
    private ?Pessoa $pessoa = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): static
    {
        $this->telefone = $telefone;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): static
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getPessoa(): ?Pessoa
    {
        return $this->pessoa;
    }

    public function setPessoa(?Pessoa $pessoa): static
    {
        $this->pessoa = $pessoa;

        return $this;
    }
}

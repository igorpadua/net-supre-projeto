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

    /**
     * @var Collection<int, Pessoa>
     */
    #[ORM\ManyToMany(targetEntity: Pessoa::class, mappedBy: 'telefone')]
    private Collection $pessoas;

    public function __construct()
    {
        $this->pessoas = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Pessoa>
     */
    public function getPessoas(): Collection
    {
        return $this->pessoas;
    }

    public function addPessoa(Pessoa $pessoa): static
    {
        if (!$this->pessoas->contains($pessoa)) {
            $this->pessoas->add($pessoa);
            $pessoa->addTelefone($this);
        }

        return $this;
    }

    public function removePessoa(Pessoa $pessoa): static
    {
        if ($this->pessoas->removeElement($pessoa)) {
            $pessoa->removeTelefone($this);
        }

        return $this;
    }
}

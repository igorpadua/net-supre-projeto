<?php

namespace App\Entity;

use App\Repository\PessoaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PessoaRepository::class)]
class Pessoa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $nome;

    #[ORM\Column(length: 11, unique: true)]
    private string $cpf;

    #[ORM\Column(length: 9, unique: true)]
    private string $rg;

    #[ORM\Column(length: 8)]
    private string $cep;

    #[ORM\Column(length: 255)]
    private string $logradouro;

    #[ORM\Column(length: 255)]
    private string $complemento;

    #[ORM\Column(length: 255)]
    private string $setor;

    #[ORM\Column(length: 255)]
    private string $cidade;

    #[ORM\Column(length: 2)]
    private string $uf;

    /**
     * @var Collection<int, Telefone>
     */
    #[ORM\OneToMany(targetEntity: Telefone::class, mappedBy: 'pessoa')]
    private Collection $telefones;

    public function __construct()
    {
        $this->telefones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): static
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getRg(): ?string
    {
        return $this->rg;
    }

    public function setRg(string $rg): static
    {
        $this->rg = $rg;

        return $this;
    }

    public function getCep(): ?string
    {
        return $this->cep;
    }

    public function setCep(string $cep): static
    {
        $this->cep = $cep;

        return $this;
    }

    public function getLogradouro(): ?string
    {
        return $this->logradouro;
    }

    public function setLogradouro(string $logradouro): static
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    public function getComplemento(): ?string
    {
        return $this->complemento;
    }

    public function setComplemento(string $complemento): static
    {
        $this->complemento = $complemento;

        return $this;
    }

    public function getSetor(): ?string
    {
        return $this->setor;
    }

    public function setSetor(string $setor): static
    {
        $this->setor = $setor;

        return $this;
    }

    public function getCidade(): ?string
    {
        return $this->cidade;
    }

    public function setCidade(string $cidade): static
    {
        $this->cidade = $cidade;

        return $this;
    }

    public function getUf(): ?string
    {
        return $this->uf;
    }

    public function setUf(string $uf): static
    {
        $this->uf = $uf;

        return $this;
    }

    /**
     * @return Collection<int, Telefone>
     */
    public function getTelefones(): Collection
    {
        return $this->telefones;
    }

    public function addTelefone(Telefone $telefone): static
    {
        if (!$this->telefones->contains($telefone)) {
            $this->telefones->add($telefone);
            $telefone->setPessoa($this);
        }

        return $this;
    }

    public function removeTelefone(Telefone $telefone): static
    {
        if ($this->telefones->removeElement($telefone)) {
            // set the owning side to null (unless already changed)
            if ($telefone->getPessoa() === $this) {
                $telefone->setPessoa(null);
            }
        }

        return $this;
    }
}

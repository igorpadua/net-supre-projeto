<?php

namespace App\Entity;

use App\Repository\PessoaRepository;
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

    #[ORM\Column(length: 11)]
    private string $cpf;

    #[ORM\Column(length: 7)]
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

    #[ORM\Column(type: Types::ARRAY)]
    private array $telefones;

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

    public function getTelefones(): array
    {
        return $this->telefones;
    }

    public function setTelefones(array $telefones): static
    {
        $this->telefones = $telefones;

        return $this;
    }
}

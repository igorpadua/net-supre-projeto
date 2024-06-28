<?php

namespace App\Controller;

use App\Entity\Pessoa;
use App\Entity\Telefone;
use App\Repository\PessoaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pessoa')]
class PessoaController extends AbstractController
{
    #[Route('/', name: 'app_pessoa', methods: ['GET'])]
    public function index(PessoaRepository $pessoaRepository): JsonResponse
    {
        $pessoas = $pessoaRepository->findAll();
        $data = [];

        foreach ($pessoas as $pessoa) {

            $telefones = [];
            foreach ($pessoa->getTelefones() as $telefone) {
                $telefones[] = [
                    'id' => $telefone->getId(),
                    'telefone' => $telefone->getTelefone(),
                    'descricao' => $telefone->getDescricao(),
                ];
            }

            $data[] = [
                'id' => $pessoa->getId(),
                'nome' => $pessoa->getNome(),
                'cpf' => $pessoa->getCpf(),
                'rg' => $pessoa->getRg(),
                'cep' => $pessoa->getCep(),
                'logradouro' => $pessoa->getLogradouro(),
                'complemento' => $pessoa->getComplemento(),
                'setor' => $pessoa->getSetor(),
                'cidade' => $pessoa->getCidade(),
                'uf' => $pessoa->getUf(),
                'telefones' => $telefones,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/{id}', name: 'app_pessoa_show', methods: ['GET'])]
    public function show(PessoaRepository $pessoaRepository, int $id): JsonResponse
    {
        $pessoa = $pessoaRepository->find($id);

        if (!$pessoa) {
            return new JsonResponse(
                [
                    'status' => '404',
                    'message' => 'Pessoa não encontrada',
                    'error' => 'Not Found',
                ],
                Response::HTTP_NOT_FOUND);
        }

        $telefones = [];

        foreach ($pessoa->getTelefones() as $telefone) {
            $telefones[] = [
                'id' => $telefone->getId(),
                'telefone' => $telefone->getTelefone(),
                'descricao' => $telefone->getDescricao(),
            ];
        }


        $data = [
            'id' => $pessoa->getId(),
            'nome' => $pessoa->getNome(),
            'cpf' => $pessoa->getCpf(),
            'rg' => $pessoa->getRg(),
            'cep' => $pessoa->getCep(),
            'logradouro' => $pessoa->getLogradouro(),
            'complemento' => $pessoa->getComplemento(),
            'setor' => $pessoa->getSetor(),
            'cidade' => $pessoa->getCidade(),
            'uf' => $pessoa->getUf(),
            'telefones' => $telefones,
        ];

        return new JsonResponse($data);
    }

    #[Route('/{id}', name: 'app_pessoa_delete', methods: ['DELETE'])]
    public function delete(PessoaRepository $pessoaRepository, int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $pessoa = $pessoaRepository->find($id);

        if (!$pessoa) {
            return new JsonResponse(
                [
                    'status' => '404',
                    'message' => 'Pessoa não encontrada',
                    'error' => 'Not Found',
                ]
                , Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($pessoa);
        $entityManager->flush();

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }

    #[Route('/', name: 'app_pessoa_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $pessoa = new Pessoa();
        $pessoa->setNome($data['nome']);

        $cpf = $entityManager->getRepository(Pessoa::class)->findOneBy(['cpf' => $data['cpf']]);
        if ($cpf) {
            return new JsonResponse(
                [
                    'status' => '400',
                    'message' => 'CPF já cadastrado',
                    'error' => 'Bad Request',
                ],
                Response::HTTP_BAD_REQUEST);
        }

        $pessoa->setCpf($data['cpf']);

        $rg = $entityManager->getRepository(Pessoa::class)->findOneBy(['rg' => $data['rg']]);
        if ($rg) {
            return new JsonResponse(
                [
                    'status' => '400',
                    'message' => 'RG já cadastrado',
                    'error' => 'Bad Request',
                ],
                Response::HTTP_BAD_REQUEST);
        }

        $pessoa->setRg($data['rg']);
        $pessoa->setCep($data['cep']);
        $pessoa->setLogradouro($data['logradouro']);
        $pessoa->setComplemento($data['complemento']);
        $pessoa->setSetor($data['setor']);
        $pessoa->setCidade($data['cidade']);
        $pessoa->setUf($data['uf']);

        if (isset($data['telefones']) && is_array($data['telefones'])) {
            foreach ($data['telefones'] as $telefoneData) {
                $telefone = new Telefone();
                $telefone->setTelefone($telefoneData['telefone']);
                $telefone->setDescricao($telefoneData['descricao']);
                $pessoa->addTelefone($telefone);
                $entityManager->persist($telefone);
            }
        }

        $entityManager->persist($pessoa);
        $entityManager->flush();

        return new JsonResponse($data, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_pessoa_edit', methods: ['PUT'])]
    public function edit(Request $request, PessoaRepository $pessoaRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $pessoa = $pessoaRepository->find($id);

        if (!$pessoa) {
            return new JsonResponse(
                [
                    'status' => '404',
                    'message' => 'Pessoa não encontrada',
                    'error' => 'Not Found',
                ],
                Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $pessoa->setNome($data['nome']);
        $pessoa->setCpf($data['cpf']);
        $pessoa->setRg($data['rg']);
        $pessoa->setCep($data['cep']);
        $pessoa->setLogradouro($data['logradouro']);
        $pessoa->setComplemento($data['complemento']);
        $pessoa->setSetor($data['setor']);
        $pessoa->setCidade($data['cidade']);
        $pessoa->setUf($data['uf']);

        if (isset($data['telefones']) && is_array($data['telefones'])) {
            foreach ($pessoa->getTelefones() as $telefone) {
                $entityManager->remove($telefone);
            }

            foreach ($data['telefones'] as $telefoneData) {
                $telefone = new Telefone();
                $telefone->setTelefone($telefoneData['telefone']);
                $telefone->setDescricao($telefoneData['descricao']);
                $pessoa->addTelefone($telefone);
                $entityManager->persist($telefone);
            }
        }

        $entityManager->persist($pessoa);
        $entityManager->flush();

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
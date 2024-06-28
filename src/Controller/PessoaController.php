<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PessoaController extends AbstractController
{
    #[Route('/pessoa', name: 'app_pessoa')]
    public function index(): Response
    {
        return $this->render('pessoa/index.html.twig', [
            'controller_name' => 'PessoaController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PknController extends AbstractController
{
    /**
     * @Route("/pkn", name="pkn")
     */
    public function index()
    {
        return $this->render('pkn/index.html.twig', [
            'controller_name' => 'PknController',
        ]);
    }
}

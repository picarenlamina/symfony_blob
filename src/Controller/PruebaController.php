<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class PruebaController extends AbstractController
{
    /**
     * @Route("/prueba", name="prueba")
     */
    public function prueba()
    {
      
      return new Response( "<h1>Prueba</H1>");
    }

    
}

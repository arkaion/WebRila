<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Toto\Toto;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(Toto $toto)
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController', 'toto' => $toto
        ]);
    }

    /**
    * @Route("/toto/{valeur}", name="toto")
    */
    public function toto($valeur)
    {
        return $this->render('test/toto.html.twig', [
            'name' => $valeur,
        ]);
    }

    /**
     * @Route("/Accueil", name="accueil")
     */
    public function accueil()
    {
        return $this->render('test/accueil.html.twig', [

        ]);
    }


}

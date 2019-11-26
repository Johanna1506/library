<?php


namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class Accueil extends AbstractController
{

    /**
     * @Route("/accueil", name="accueil")
     */

    public function accueilShow(){

        return $this->render('accueil.html.twig');
    }

}
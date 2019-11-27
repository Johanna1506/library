<?php


namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class AuthorController extends AbstractController
{

    /**
     * @Route("/authors_controller", name="authors_controller")
     */

    public function authorsRepository(AuthorRepository $authorRepository){
        $authors = $authorRepository->findall();
        return $this->render('authors.html.twig',[
            'authors' => $authors,

        ]);
    }

    /**
     * @Route("/author_controller/{id}", name="author_controller")
     */

    public function authorRepository(AuthorRepository $authorRepository, $id){
        $author = $authorRepository->find($id);
        return $this->render('author.html.twig',[
            'author' => $author,
        ]);
    }

    /**
     * @Route("/author_search/{word}", name="author_search")
     */
    public function authorSearch(AuthorRepository $authorRepository, $word){
        $authors = $authorRepository->getByWord($word);
        return $this->render('authors.html.twig',[
            'authors' => $authors]);

    }

    /**
     * @Route("/author_delete", name="author_delete")
     */
    public function deleteAuthor(BookRepository $authorRepository, EntityManagerInterface $entityManager)
    {
        // Je récupère un enregistrement book en BDD grâce au repository de book
        $author = $authorRepository->find(2);
        // j'utilise l'entity manager avec la méthode remove pour enregistrer
        // la suppression du book dans l'unité de travail
        $entityManager->remove($author);
        // je valide la suppression en bdd avec la méthode flush
        $entityManager->flush();
    }


}
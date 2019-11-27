<?php


namespace App\Controller;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
class BookController extends AbstractController
{
    //Methode pour chercher tous les livres
    /**
     * @Route("/books_controller", name="books_controller")
     */
    public function booksShow(BookRepository $bookRepository)
    {
        $books = $bookRepository->findall();
        return $this->render('books.html.twig', [
            'books' => $books]);
    }

    //methode pour chercher un seul livre

    /**
     * @Route("/book_controller/{id}", name="book_controller")
     */
    public function bookShow(BookRepository $bookRepository, $id)
    {
        $book = $bookRepository->find($id);
        return $this->render('book.html.twig', [
            'book' => $book]);
    }

    //Methode pour rechercher un livre par style

    /**
     * @Route("/book_style/{style}", name="book_style")
     */
    public function getBooksByStyle(BookRepository $bookRepository, $style)
    {
        $books = $bookRepository->getByStyle($style);
        dump($books);
        die;
    }

    /**
     * @Route("/book_form", name="book_form")
     */

    public function insertShow()
    {

        return $this->render('book_insert.html.twig');
    }

    //Methode pour inserer un livre dans la BDD

    /**
     * @Route("/book_insert", name="book_insert")
     */
    public function insertBook(EntityManagerInterface $entityManager, Request $request)
    {
        $new_book = 'Votre livre a bien ete enregistre';

        $title = $request->request->get('title');
        $style = $request->request->get('style');
        $inStock = $request->request->get('inStock' );
        $nbPages = $request->request->get('nbPages');
        $description = $request->request->get('description');


        $book = new Book();
        $book->setTitle($title);
        $book->setStyle($style);
        $book->setInStock($inStock);
        $book->setNbPages($nbPages);
        $book->setDescription($description);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->render('book.html.twig', [
            'book' => $book,
            'new_book' => $new_book
        ]);
    }


    /**
     * @Route("/book_delete/{id}", name="book_delete")
     */
    public function deleteBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id){
        $book_delete = 'Le livre a ete supprime';
        $book_update = 'Le livre a bien ete modifie';

        // Je récupère un enregistrement book en BDD grâce au repository de book
        $book = $bookRepository->find($id);
        // j'utilise l'entity manager avec la méthode remove pour enregistrer
        // la suppression du book dans l'unité de travail
        $entityManager->remove($book);
        // je valide la suppression en bdd avec la méthode flush
        $entityManager->flush();

        return $this->render('book_change.html.twig', [
            'book' => $book,
            'book_delete'=>$book_delete,
        ]);
    }

    /**
     * @Route("/book_update/{id}", name="book_update")
     */
    public function updateBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id){
        $book_update = 'Le livre a bien ete modifie';


        $book = $bookRepository->find($id);

        $book->setTitle('update');
//        $book->setDescription();
//        $book->setInStock();
//        $book->setNbPages();
//        $book->setStyle();

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->render('book_change.html.twig', [
            'book' => $book,
            'book_update'=>$book_update,

        ]);


    }
}
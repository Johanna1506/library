<?php


namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class BookController extends AbstractController
{

    /**
     * @Route("/books_controller", name="books_controller")
     */
    public function booksShow(BookRepository $bookRepository){
        $books = $bookRepository->findall();
        return $this->render('books.html.twig', [
            'books' => $books]);
    }

    /**
     * @Route("/book_controller/{id}", name="book_controller")
     */
    public function bookShow(BookRepository $bookRepository, $id){
        $book = $bookRepository->find($id);
        return $this->render('book.html.twig', [
            'book' => $book]);
    }

    /**
     * @Route("/book_style/{style}", name="book_style")
     */
    public function getBooksByStyle(BookRepository $bookRepository, $style){
        $books = $bookRepository->getByStyle($style);
        dump($books); die;
    }




}
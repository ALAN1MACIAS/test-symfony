<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
  private $logger;

  public function __construct(LoggerInterface $logger)
  {
    $this->logger = $logger;
  }

  /**
   * @Route("/books", name="books_get")
   */
  public function list(Request $request, BookRepository $bookRepository){
    $title = $request->get('title', 'Alegria');
    $books = $bookRepository->findAll();
    $booksArray = [];
    foreach ($books as $book){
      $booksArray[] = [
        'id' => $book->getId(),
        'title' => $book->getTitle(),
        'image' => $book->getImage()
      ];
    }
    $response = new JsonResponse();
    $response->setData([
      'success' => true,
      'data' => $booksArray
    ]);
    return $response;
  }

  /**
  * @Route("/book/create", name="create_book")
  */
  public function createBook(Request $request, EntityManagerInterface $em){
    $book = new Book();
    $response = new JsonResponse();
    $title = $request->get('title', null);
    if (empty($title)){
      $response->setData([
        'success' => true,
        'data' => [
          [
            'id' => false,
            'error' => 'Title cannot be empty',
            'title' => null
          ]
        ]
      ]);
      return $response;
    }
    $book->setTitle('Alquimista');
    $em->persist($book); // Controla los objetos
    $em->flush(); // Almacenando en la DB
    $response->setData([
      'success' => true,
      'data' => [
        [
          'id' => $book->getId(),
          'title' => $book->getTitle()
        ]
      ]
    ]);
    return $response;
  }
}
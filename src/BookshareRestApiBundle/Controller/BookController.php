<?php

namespace BookshareRestApiBundle\Controller;

use BookshareRestApiBundle\Entity\Book;
use BookshareRestApiBundle\Service\Books\BookServiceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @Route("/search-book", methods={"GET"})
     * @return Response
     */
    public function searchBook() {
        $search = $_GET['search'];
        $books = $this->bookService->getBooksBySearch($search);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizer->setIgnoredAttributes(["chooses", "bookRequests", "users"]);

        $serializer = new Serializer(array($normalizer), array($encoder));
        $json = $serializer->serialize($books, 'json');

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }

    /**
     * @Route("private/user-books", methods={"GET"})
     * @return Response
     */
    public function getBooksForCurrentUser() {
        $books = $this->bookService->getBooksByCurrentUser();

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizer->setIgnoredAttributes(["chooses", "bookRequests", "users", "subcategory", "description"]);

        $serializer = new Serializer(array($normalizer), array($encoder));
        $json = $serializer->serialize($books, 'json');

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }

    /**
     * @Route("book/{id}", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function getBookById(int $id) {
        $book = $this->bookService->bookById($id);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($book) {
            /** @var Book $book */
            return $book->getId();
        });
        $normalizer->setIgnoredAttributes(["bookRequests", "chooses", "books", "receipts"]);

        $serializer = new Serializer(array($normalizer), array($encoder));
        $json = $serializer->serialize($book, 'json');

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }

    /**
     * @Route("/most-exchanged-books", methods={"GET"})
     *
     * @return Response
     */
    public function getMostExchangedBooks() {
        $books = $this->bookService->getMostExchangedBooks();

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($books) {
            /** @var Book $book */
            return $books->getId();
        });
        $normalizer->setIgnoredAttributes(["bookRequests", "users", "chooses", "books", "receipts"]);

        $serializer = new Serializer(array($normalizer), array($encoder));
        $json = $serializer->serialize($books, 'json');

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }

    /**
     * @Route("/newest-books", methods={"GET"})
     *
     * @return Response
     */
    public function getNewestBooks() {
        $books = $this->bookService->getNewestBooks();

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($books) {
            /** @var Book $book */
            return $books->getId();
        });
        $normalizer->setIgnoredAttributes(["bookRequests", "users", "chooses", "books", "receipts"]);

        $serializer = new Serializer(array($normalizer), array($encoder));
        $json = $serializer->serialize($books, 'json');

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }
}

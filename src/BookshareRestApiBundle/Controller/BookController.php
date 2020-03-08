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
    private $encoder;
    private $normalizer;

    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
        $this->encoder = new JsonEncoder();
        $this->normalizer = new ObjectNormalizer();
        $this->normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
    }

    /**
     * @Route("/search-book", methods={"GET"})
     * @return Response
     */
    public function searchBook() {
        $search = $_GET['search'];
        $books = $this->bookService->getBooksBySearch($search);

        $this->normalizer->setIgnoredAttributes(["chooses", "bookRequests", "users"]);

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));
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

        $this->normalizer->setIgnoredAttributes(["chooses", "bookRequests", "users", "subcategory", "description"]);

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));
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

        $this->normalizer->setIgnoredAttributes(["bookRequests", "chooses", "books", "receipts"]);

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));
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

        $this->normalizer->setIgnoredAttributes(["bookRequests", "users", "chooses", "books", "receipts"]);

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));
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

        $this->normalizer->setIgnoredAttributes(["bookRequests", "users", "chooses", "books", "receipts"]);

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));
        $json = $serializer->serialize($books, 'json');

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }
}

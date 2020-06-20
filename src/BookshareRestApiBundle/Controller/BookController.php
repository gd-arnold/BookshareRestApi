<?php

namespace BookshareRestApiBundle\Controller;

use BookshareRestApiBundle\Entity\Book;
use BookshareRestApiBundle\Form\BookType;
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
     * @Route("private/book/{id}", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function getBookByIdPrivate(int $id) {
        $book = $this->bookService->bookById($id);

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));
        $json = $serializer->serialize($book, 'json', ['attributes' => ['id', 'title', 'author', 'description', 'publisher', 'datePublished', 'imageURL',
            'users' => ['id', 'email',
                'requests' => ['id',
                    'requestedBook' => ['id']
                ]
            ]
        ]]);

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }

    /**
     * @Route("book/{id}", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function getBookByIdPublic(int $id) {
        $book = $this->bookService->bookById($id);

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));
        $json = $serializer->serialize($book, 'json', ['attributes' => ['id', 'title', 'author', 'description', 'publisher', 'datePublished', 'imageURL']]);

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

    /**
     * @Route("/private/create-book", methods={"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function createBook(Request $request) {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book, ['method' => 'POST']);
        $form->submit($request->request->all());

        $subcategory = $this->bookService->subcategoryById(json_decode($request->getContent(), true)['subcategoryId']);
        $book->setSubcategory($subcategory);

        $this->bookService->save($book);
        $this->bookService->deleteBookSuggestion($this->bookService->bookSuggestionById(json_decode($request->getContent(), true)['suggestionId']));
        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/private/all-categories", methods={"GET"})
     *
     * @return Response
     */
    public function getAllCategories() {
        $categories = $this->bookService->getAllCategories();

        $this->normalizer->setIgnoredAttributes(["subcategories"]);

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));
        $json = $serializer->serialize($categories, 'json');

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }

    /**
     * @Route("/private/subcategories-by-category/{id}", methods={"GET"})
     *
     * @param string $id
     * @return Response
     */
    public function getAllSubcategoriesByCategory(string $id) {
        $category = $this->bookService->categoryById($id);

        $subcategories = $this->bookService->getAllSubcategoriesByCategory($category);

        $this->normalizer->setIgnoredAttributes(["category", "books"]);

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));
        $json = $serializer->serialize($subcategories, 'json');

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }

    /**
     * @Route("/private/suggested-books", methods={"GET"})
     *
     */
    public function getSuggestedBooksForCurrentUser() {
        $this->bookService->getSuggestedBooksForUser();
    }
}

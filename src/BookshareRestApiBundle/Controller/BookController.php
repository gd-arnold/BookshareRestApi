<?php

namespace BookshareRestApiBundle\Controller;

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

        $normalizer->setIgnoredAttributes(["requests", "users"]);

        $serializer = new Serializer(array($normalizer), array($encoder));
        $json = $serializer->serialize($books, 'json');

        return new Response($json,
            Response::HTTP_OK,
            ['content_type' => 'application/json']);

    }
}

<?php

namespace BookshareRestApiBundle\Controller;

use BookshareRestApiBundle\Service\Books\BookServiceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @Route("/search-book", methods={"POST"})
     * @param Request $request
     * @return string
     */
    public function searchBook(Request $request) {
        $search = $request->request->all()['search'];
        $books = $this->bookService->getBooksBySearch($search);

        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($books, 'json');

        return new Response($json,
            Response::HTTP_OK,
            ['content_type' => 'application/json']);

    }
}

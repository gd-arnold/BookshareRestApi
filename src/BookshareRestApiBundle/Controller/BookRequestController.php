<?php

namespace BookshareRestApiBundle\Controller;

use BookshareRestApiBundle\Service\Books\BookServiceInterface;
use BookshareRestApiBundle\Service\Requests\RequestServiceInterface;
use BookshareRestApiBundle\Service\Users\UsersServiceInterface;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookRequestController extends Controller
{
    private $bookRequestService;
    private $userService;
    private $bookService;

    public function __construct(RequestServiceInterface $bookRequestService,
                                UsersServiceInterface $userService,
                                BookServiceInterface $bookService)
    {
        $this->bookRequestService = $bookRequestService;
        $this->userService = $userService;
        $this->bookService = $bookService;
    }

    /**
     * @Route("/private/request-book", methods={"POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function requestBook(Request $request) {
        $book = $this->bookService->bookById($request->request->all()['book_id']);

        $this->bookRequestService->createRequest($book);

        return new Response(null, Response::HTTP_CREATED);
    }
}

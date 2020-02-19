<?php

namespace BookshareRestApiBundle\Controller;

use BookshareRestApiBundle\Entity\User;
use BookshareRestApiBundle\Form\UserType;
use BookshareRestApiBundle\Service\Books\BookServiceInterface;
use BookshareRestApiBundle\Service\Users\UsersServiceInterface;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    /**
     * @var UsersServiceInterface
     */
    private $userService;
    private $bookService;

    public function __construct(UsersServiceInterface $userService,
                                BookServiceInterface $bookService)
    {
        $this->userService = $userService;
        $this->bookService = $bookService;
    }

    /**
     * @Route("/register", methods={"POST"})
     * @param Request $request
     *
     * @return string
     */
    public function register(Request $request) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['method' => 'POST']);
        $form->submit($request->request->all());

        $this->userService->save($user);

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/private/add-book", methods={"POST"})
     * @param Request $request
     *
     * @return string
     */
    public function addBook(Request $request) {
        $id = intval(json_decode($request->getContent(), true)['id']);
        $book = $this->bookService->bookById($id);
        $this->userService->addBook($book);

        return new Response(null, Response::HTTP_CREATED);
    }

    
}

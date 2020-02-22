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
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $user->enableUser();
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

    /**
     * @Route("/private/current-user-basic-data", methods={"GET"})
     * @return Response
     */
    public function getCurrentUserData() {
        $user = $this->userService->getCurrentUser();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($user) {
            /** @var User $user */
            return $user->getId();
        });

        $normalizer->setIgnoredAttributes(["books", "receipts", "password"]);

        $serializer = new Serializer(array($normalizer), array($encoder));
        $json = $serializer->serialize($user, 'json');

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }

    
}

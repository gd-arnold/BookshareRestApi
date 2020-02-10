<?php

namespace BookshareRestApiBundle\Controller;

use BookshareRestApiBundle\Service\Users\UserService;
use BookshareRestApiBundle\Entity\User;
use BookshareRestApiBundle\Form\UserType;
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

    public function __construct(UsersServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/register")
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
}

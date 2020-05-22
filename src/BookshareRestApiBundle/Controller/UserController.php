<?php

namespace BookshareRestApiBundle\Controller;

use BookshareRestApiBundle\Entity\User;
use BookshareRestApiBundle\Form\UserType;
use BookshareRestApiBundle\Service\Addresses\AddressServiceInterface;
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

    private $userService;
    private $bookService;
    private $addressService;
    private $encoder;
    private $normalizer;

    public function __construct(UsersServiceInterface $userService,
                                BookServiceInterface $bookService,
                                AddressServiceInterface $addressService)
    {
        $this->userService = $userService;
        $this->bookService = $bookService;
        $this->addressService = $addressService;
        $this->encoder = new JsonEncoder();
        $this->normalizer = new ObjectNormalizer();
        $this->normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
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
     * @Route("/private/add-address", methods={"POST"})
     * @param Request $request
     *
     * @return string
     */
    public function addAddress(Request $request) {
        $id = intval(json_decode($request->getContent(), true)['addressId']);
        $phoneNumber = json_decode($request->getContent(), true)['phoneNumber'];

        $address = $this->addressService->addressById($id);

        $this->userService->addDeliveryInfo($address);
        $this->userService->updatePhoneNumber($phoneNumber);

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/private/remove-book", methods={"POST"})
     * @param Request $request
     *
     * @return string
     */
    public function removeBook(Request $request) {
        $id = intval(json_decode($request->getContent(), true)['id']);
        $book = $this->bookService->bookById($id);
        $this->userService->removeBook($book);

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/private/current-user-basic-data", methods={"GET"})
     * @return Response
     */
    public function getCurrentUserData() {
        $user = $this->userService->getCurrentUser();

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));

        $json = $serializer->serialize($user, 'json', ['attributes' => ['id', 'email', 'firstName', 'address', 'phoneNumber', 'lastName',
            'addresses' => ['id', 'address', 'city' => ['id', 'cityName'], 'courierService' => ['id', 'courierServiceName']], 'requests' => ['id', 'isAccepted', 'isReadByReceiver', 'isReadByRequester', 'receiver' => ['id'], 'requestedBook' => ['id', 'title', 'author', 'description', 'publisher', 'datePublished', 'pages', 'imageURL', 'rating']],
                'receipts' => ['id', 'isAccepted', 'isReadByReceiver', 'isReadByRequester', 'requester' => ['id'], 'requestedBook' => ['id', 'title', 'author', 'description', 'publisher', 'datePublished', 'pages', 'imageURL', 'rating']]
            ]
        ]);

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }

    /**
     * @Route("/private/update-user-basic-data", methods={"POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function updateUserBasicData(Request $request) {
        $data = json_decode($request->getContent(), true)['data'];

        $this->userService->updateUserBasicData($data);

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/private/update-password", methods={"POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function updatePassword(Request $request) {
        $currPassword = json_decode($request->getContent(), true)['currPassword'];
        $newPassword = json_decode($request->getContent(), true)['newPassword'];

        $this->userService->updatePassword($currPassword, $newPassword);

        return new Response(null, Response::HTTP_CREATED);
    }
}

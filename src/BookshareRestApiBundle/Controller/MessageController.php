<?php


namespace BookshareRestApiBundle\Controller;


use BookshareRestApiBundle\Service\Messages\MessageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\Serializer\Serializer;

class MessageController extends Controller
{
    private $encoder;
    private $normalizer;
    private $messageService;

    public function __construct(MessageServiceInterface $messageService)
    {
        $this->encoder = new JsonEncoder();
        $this->normalizer = new ObjectNormalizer();
        $this->normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $this->messageService = $messageService;
    }

    /**
     * @Route("/private/send-message", methods={"POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function sendMessage(Request $request) {
        $description = json_decode($request->getContent(), true)['description'];

        $this->messageService->createMessage($description);

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/private/all-messages", methods={"GET"})
     *
     * @return Response
     */
    public function getAllMessages() {
        $messages = $this->messageService->getAllMessages();

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));

        $json = $serializer->serialize($messages, 'json', ['attributes' => ['id', 'description',
            'sender' => ['id', 'firstName', 'lastName', 'email']]]);

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }

    /**
     * @Route("/private/delete-message", methods={"POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function deleteMessage(Request $request) {
        $messageId = intval(json_decode($request->getContent(), true)['messageId']);
        $message = $this->messageService->messageById($messageId);

        $this->messageService->deleteMessage($message);

        return new Response(null, Response::HTTP_CREATED);
    }
}